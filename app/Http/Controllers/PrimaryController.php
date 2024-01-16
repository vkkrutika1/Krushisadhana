<?php
namespace App\Http\Controllers;
use App\Models\PrimaryLabel;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Product;
use App\Models\LabelType;
use App\Models\Setting;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use PDF;

class PrimaryController extends Controller {

  public function index() {
    $primaries = PrimaryLabel::orderBy('id','desc')->get();
    return view('primaries.index',['primaries' => $primaries]);
  }

  public function create() {
    $products = Product::where('local_status', 1)->orderBy('id', 'desc')->get();
    $types = LabelType::where('status', 1)->get();
    return view('primaries.create', compact('products','types'));
  }

  public function getRelatedData(Request $request) {
    $productCode = $request->input('productCode');
    $productObj = new Product();
    $productSelQryObj = $productObj->selectQuery();
    $relatedData = $productSelQryObj->where('ProductCode', $productCode)->get();
    // $relatedData = Product::with(['Category', 'SubCategory'])
    //   ->where('ProductCode', $productCode)
    //   ->get();
    return response()->json($relatedData);
  }

  public function generateNumber() {
    $lastNumber = PrimaryLabel::max('QRCode');
    if ($lastNumber && is_numeric($lastNumber) && $lastNumber >= 2300000001 && $lastNumber <= 2300999999) {
      $nextNumber = $lastNumber + 1;
    } else {
      $nextNumber = 2300000001;
    }
    return $nextNumber;
  }

  public function store(Request $request) {
    // $this->pr($request->all());
    // exit;
    $product = Product::where('ProductCode', $request->product_id)->first();
    $productName = $product->product_name;
    $searchCategoryName = $request->category;
    $qrcodes = [];
    $serialNumbers = [];
    $primaryLabelData = [];
    $validator = Validator::make($request->all(), [
      'product_id' => ['required'],
      'manufacturer_name' => ['required'],
      'supplier_name' => ['required'],
      'category_id' => ['required'],
      'sub_category_id' => ['required'],
      'brand_name' => ['required'],
      'weight' => ['required'],
      'uom_id' => ['required'],
      'batch_no' => ['required','max:20'],
      'mfg_date' => ['required'],
      'exp_date' => ['required'],
      'quantity' => ['required'],
      'mrp' => ['required'],
    ]);
    if ($validator->passes()) {
      if ($request->quantity) {
        $lastRecord = $this->getLastRecordCounter();  
        $startSerialNumber = 0;   
        $quantity = $request->quantity;
        $apiManufactureDate = date('d/m/Y', strtotime($request->mfg_date));
        $apiExpiryDate = date('d/m/Y', strtotime($request->exp_date));
        $prependCode = $this->getPrependCode('qrcode');
        for ($i = 0; $i < $quantity; $i++) {
          $lastRecord++;
          $qrCode = $prependCode.str_pad($lastRecord, 6, '0', STR_PAD_LEFT);
          $qrCodes[] = $qrCode;
          $serialNumbers[] = $startSerialNumber++;
          $primaryLabelData[] = array (
            "QRCode"=>$qrCode,
            "ProductCode"=>$request->product_id,
            "BatchNumber"=>$request->batch_no,
            "SerialNumber"=>$startSerialNumber,
            "ManufactureDate"=>$apiManufactureDate,
            "ExpiryDate"=>$apiExpiryDate,
          );
        }
      }
      // $this->pr($primaryLabelData);
      // echo json_encode($primaryLabelData);
      // exit;
      $primaryLabel = new PrimaryLabel();
      $primaryLabel->ApplicationID = $request->application_id;
      $primaryLabel->ProductCode = $request->product_id;
      $primaryLabel->ManufacturerName = $request->manufacturer_name;
      $primaryLabel->SupplierName = $request->supplier_name;
      $primaryLabel->ItemCategoryID = $request->category_id;
      $primaryLabel->SubCategoryID = $request->sub_category_id;
      $primaryLabel->BrandName = $request->brand_name;
      $primaryLabel->UomID = $request->uom_id;
      $primaryLabel->Weight = $request->weight;
      $primaryLabel->BatchNumber = $request->batch_no;
      $primaryLabel->SerialNumber = json_encode($serialNumbers);
      $primaryLabel->ManufactureDate = $request->mfg_date;
      $primaryLabel->ExpiryDate = $request->exp_date;
      $primaryLabel->quantity = $request->quantity;
      $primaryLabel->mrp = $request->mrp;
      $primaryLabel->label_type = $request->type;
      $primaryLabel->QRCode = json_encode($qrCodes);
      $primaryLabel->user_id = Auth::user()->id;
      if ($primaryLabel->save()) {
        if (!$product->is_secondary) {
          $settingModel = new Setting();
          $this->accessToken = $settingModel->getAPIAccessToken();
          $apiResult = $this->postDatatoAPI("SavePrimaryQRDetail", $primaryLabelData, $this->accessToken);
          if ($apiResult && isset($apiResult['success'])) {
            $primaryLabel->api_sync_status = true;
            $primaryLabel->save();
          }
        }
        Alert::success('Congrats', 'Primary Successfully Added');
      } else {
        Alert::error('Error', 'Some Server Error Occurred! Please try after sometimes');
      }
      return redirect()->route('primaries.index');
    } else {
      // $errors = $validator->errors();
      // $this->pr($errors);
      // exit;
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }

  public function edit($id) {
    $primary = PrimaryLabel::find($id);
    return view('primaries.edit',['primary'=>$primary]); 
  }

  public function update($id, Request $request) {
    $primaries = PrimaryLabel::find($id);
    $validator = Validator::make($request->all(),[
      'secondary' => ['string', 'max:255'],
      'applicationid' => ['string', 'max:255'],
      'primary_code' => ['string', 'max:255'],
      'company_name' => ['string', 'max:255'],
      'manufacturer_name' => ['string', 'max:255'],
      'primary_name' => ['string', 'max:255'],
      'supplier_name' => ['string', 'max:255'],
      'category' => ['string', 'max:255'],
      'sub_category' => ['string', 'max:255'],
      'brand_name' => ['string', 'max:255'],
      'weight' => ['string', 'max:255'],
      'uomid' => ['string', 'max:255'],
    ]);
    if ($validator->passes()) {
      $primaryLabel = PrimaryLabel::find($id);
      $primaryLabel->secondary = $request->secondary;
      $primaryLabel->applicationid = $request->applicationid;
      $primaryLabel->primary_code = $request->primary_code;
      $primaryLabel->company_name = $request->company_name;
      $primaryLabel->manufacturer_name = $request->manufacturer_name;
      $primaryLabel->primary_name = $request->primary_name;
      $primaryLabel->supplier_name = $request->supplier_name;
      $primaryLabel->category = $request->category;
      $primaryLabel->sub_category = $request->sub_category;
      $primaryLabel->brand_name = $request->brand_name;
      $primaryLabel->weight = $request->weight;
      $primaryLabel->uomid = $request->uomid;
      $primaryLabel->save();
      Alert::success('Success', 'Primary Successfully Updated');
      return redirect()->route('primaries.edit',$id);
    } else {
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->route('primaries.edit',$id)->withErrors($validator)->withInput();
    }
  }

  public function destroy($id, Request $request) {
    $primary = PrimaryLabel::find($id);
    $primary->delete(); 
    Alert::success('Success', 'Primary Deleted Successfully');
    return redirect()->back();
  }

  public function deleteprimary(Request $request){
    $ids = $request->ids;
    $primary = PrimaryLabel::whereIn('id', $ids)->get();
    PrimaryLabel::whereIn('id', $ids)->delete();
    Alert::success('Success', 'Primary Deleted Successfully');
    return redirect()->back();
  }

  public function view($id) { 
    // $primary = PrimaryLabel::where('id', $id)
    //   ->join('sub_categories', function ($join) {
    //     $join->on('primary_labels.ApplicationID', '=', 'sub_categories.ApplicationID')
    //     ->On('primary_labels.SubCategoryID', '=', 'sub_categories.SubCategoryID')
    // })->get();
    $primary = PrimaryLabel::select('primary_labels.*', 'sub_categories.SubCategoryName as SubCategoryName')->where('primary_labels.id', $id)
      ->join('sub_categories', function ($join) {
        $join->on('primary_labels.ApplicationID', '=', 'sub_categories.ApplicationID')
        ->On('primary_labels.SubCategoryID', '=', 'sub_categories.SubCategoryID');
    })->first();
      // $this->pr($primary);
      // exit;
    return view('primaries.view',['primary'=>$primary]);  
  }  
  public function printLabel($id) { 
    $primary = PrimaryLabel::find($id); 
    return view('primaries.printLabel',['primary'=>$primary]);  
  }

  public function primaryprint(Request $request, $id) { 
    $primary = PrimaryLabel::find($id);
    $userProfile = UserProfile::where('user_id', $primary->user_id)->first();
    $totalQuantity = $primary->quantity;
    $validator = Validator::make($request->all(),[
      'from' => 'required|numeric|min:1|max:'.$totalQuantity,
      'to' => 'required|integer|gte:from|max:'.$totalQuantity,     
    ]);
    if ($validator->passes()) {
      $labelFrom = $request->from;
      $labelTo = $request->to;
      $qrCodes = json_decode($primary->QRCode);
      $serialNos = json_decode($primary->SerialNumber);
      $qrCodesArray = $this->generateQrCodes($qrCodes, $labelFrom, $labelTo, 'primary',$id);
      $viewName = 'primaries.';
      switch($primary->LabelType->name) {
        case 'green':
          $paperSize = array(0, 0, 283, 425);
          $viewName .= 'pdfGreen';
        break;
        case 'white':
          $paperSize = array(0, 0, 283, 425);
          $viewName .= 'pdfWhite';
        break;
        case 'medium':
          $paperSize = array(0, 0, 171, 227);
          $viewName .= 'pdfMedium';
        break;
        default:
          // $paperSize = array(0, 0, 140, 142);
          $paperSize = array(0, 0, 71, 142);
          $viewName .= 'pdf';
          // $paperSize = array(0,0,311.88,311.88);
        break;
      }
      $pdf = PDF::loadView($viewName, [
        'qrCodesArray' => $qrCodesArray,
        'userProfile'=>$userProfile,
        'primary' => $primary,
        'serialNos'=> $serialNos
      ]);
      // return view($viewName,[
      //   'qrCodesArray' => $qrCodesArray,
      //   'userProfile'=>$userProfile,
      //   'primary' => $primary,
      // ]);
      $downloadedFileName = "primaries_".$primary->BatchNumber.".pdf";
      $pdf->setPaper($paperSize, 'landscape');
      // $pdf->set_paper("A4", "portrait");
      return $pdf->download("$downloadedFileName");
    } else {
      Alert::error('Error', 'Some Error Occurred');
      // $this->pr($validator->errors());
      // exit;
      return redirect()->route('primaries.printLabel',$id)->withErrors($validator)->withInput();
    }
  }
}
