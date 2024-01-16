<?php
namespace App\Http\Controllers;
use App\Models\SecondaryLabel;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Product;
use App\Models\PrimaryLabel;
use App\Models\Setting;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;


class SecondaryController extends Controller {
  public function index() {
    $this->generateSecQRCodes();
    $this->generatePriQRCodes();

    $secondaries = SecondaryLabel::orderBy('id','desc')->get();
    // dd($secondaries);
    // $this->pr($secondaries->toArray());
    // exit;
    return view('secondaries.index',['secondaries' => $secondaries]);
  }

  public function create() {
    $products = Product::select('ProductCode')->where('is_secondary', 1)->where('local_status', 1)->orderBy('id', 'desc')->get();
    // $this->pr($products->toArray());
    // exit;
    $productCodes = $products->pluck('ProductCode')->toArray();
    //$this->pr($productIds);
    $primaries = PrimaryLabel::whereIn('ProductCode',$productCodes)->where('local_status', 1)->orderBy('id', 'desc')->get();
    // $this->pr($primaries);
    // exit;
    return view('secondaries.create', compact('products','primaries'));
  }

  public function getSRelatedData(Request $request) {
    $recordID = $request->input('id');
    $relatedDataSecondary = PrimaryLabel::where('id', $recordID)->first();
    $relatedData = $relatedDataSecondary->quantity;
    return response()->json($relatedData);
  }

  public function store(Request $request) {
    $totalPrimaryLabels = $request->quantity;
    $validator = Validator::make($request->all(),[
      'labelid' => 'required',
      'quantity' => 'required|numeric',
      'label_numbers' => 'required|numeric|min:1|max:'.$totalPrimaryLabels,     
    ]);
    // $this->pr($request->all);
    if ($validator->passes()) {
      $labelsPerContainer = $request->label_numbers;
      if ($labelsPerContainer > 1) {
        $totalSecRecords = intval($totalPrimaryLabels / $labelsPerContainer);
      } else {
        $totalSecRecords = $labelsPerContainer;
      }
      $lastRecord = $this->getLastRecordCounter();
      $primary = PrimaryLabel::where('id', $request->labelid)->first();
      $product = Product::find($primary->Product->id)->first();
      $prependCode = $this->getPrependCode('qrcode');
      $secPrependCodeCont = $this->getPrependCode('container');
      $primaryCodes = json_decode($primary->QRCode);
      $serialNumbers = json_decode($primary->SerialNumber);
      $prQrcodesOfContainer = array_chunk($primaryCodes, $labelsPerContainer);
      $prSrNumsOfContainer = array_chunk($serialNumbers, $labelsPerContainer);
      $totalSecRecords = count($prQrcodesOfContainer);
      for ($counter = 0; $counter<$totalSecRecords; $counter++) {
        $lastRecord++;
        $recordCounter = str_pad($lastRecord, 6, '0', STR_PAD_LEFT);
        $qrCode = $prependCode.$recordCounter;
        $SecondaryContainerCode = $secPrependCodeCont.$recordCounter;
        $secondaryRecords[] = array (
          "QRCode"=> $qrCode,
          "SecondaryContainerCode"=> $SecondaryContainerCode,
          "ProductCode"=> $product->ProductCode,
          "primary_label_id"=> $primary->id,
          "primary_quantity"=> $totalSecRecords,
          "label_type"=> $primary->label_type,
          "user_id" => Auth::user()->id,
          "created_at"=> date('Y-m-d H:s:i'),
          "updated_at"=> date('Y-m-d H:s:i'),
          "SecondaryLabelDetail"=> $this->formSecLabelDetail($prQrcodesOfContainer[$counter], $prSrNumsOfContainer[$counter], $product->ProductCode, $primary->BatchNumber, $primary->ManufactureDate, $primary->ExpiryDate)
        );
      } 
      // $this->pr($secondaryRecords);
      // exit;
      if (SecondaryLabel::insert($secondaryRecords)) {
        // $postData = array('secondaryContainerDetail'=>$secondaryRecords);
        $selectFields = array(
          'QRCode',
          'SecondaryContainerCode',
          'SecondaryLabelDetail',
        );
        $objSecondaryRecords = SecondaryLabel::select($selectFields)
          ->where('ProductCode',$product->ProductCode)
          ->whereNull('api_sync_status')->get();
        $postData = array();
        foreach ($objSecondaryRecords as $secondaryRecord) {
          $postData['secondaryContainerDetail'][] = array(
            'QRCode' => $secondaryRecord['QRCode'],
            'SecondaryContainerCode' =>$secondaryRecord['SecondaryContainerCode'] ,
            'SecondaryLabelDetail' => json_decode($secondaryRecord["SecondaryLabelDetail"], true)
          );
          $secondaryContainerDetail["secondaryContainerDetail"][] = $secondaryRecord;
          $secQRCodes = array($secondaryRecord->QRCode);
          $this->generateQrCodes($secQRCodes, 1, 1, "secondary", $secondaryRecord->id);
        }
        $settingModel = new Setting();
        $this->accessToken = $settingModel->getAPIAccessToken();
        $apiResult = $this->postDatatoAPI("SaveSecondaryQRDetail", $postData, $this->accessToken);
        if ($apiResult && isset($apiResult['success'])) {
          SecondaryLabel::where('ProductCode',$product->ProductCode )->update(['api_sync_status' => true]);
          PrimaryLabel::where('id', $primary->id)->update(['api_sync_status' => true]);
        }
        Alert::success('Congrats', 'Secondary Successfully Added');
      }
      //return redirect()->back();
      return redirect()->route('secondaries.index');
    } else {
      // $errors = $validator->errors();
      // $this->pr($errors);
      // exit;
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }

  public function view($id) {
    $secondary = SecondaryLabel::find($id);
    return view('secondaries.view',['secondary'=>$secondary]); 
  }

  public function edit($id) {
    $secondary = SecondaryLabel::find($id);
    return view('secondaries.edit',['secondary'=>$secondary]); 
  }

  public function update($id, Request $request) {
    $secondaries = SecondaryLabel::find($id);
    $validator = Validator::make($request->all(),[
      'secondary' => ['string', 'max:255'],
      'applicationid' => ['string', 'max:255'],
      'secondary_code' => ['string', 'max:255'],
      'company_name' => ['string', 'max:255'],
      'manufacturer_name' => ['string', 'max:255'],
      'secondary_name' => ['string', 'max:255'],
      'supplier_name' => ['string', 'max:255'],
      'category' => ['string', 'max:255'],
      'sub_category' => ['string', 'max:255'],
      'brand_name' => ['string', 'max:255'],
      'weight' => ['string', 'max:255'],
      'uomid' => ['string', 'max:255'],
    ]);
    if ($validator->passes()) {
      $secondaries = SecondaryLabel::find($id);
      $secondaries->secondary = $request->secondary;
      $secondaries->applicationid = $request->applicationid;
      $secondaries->secondary_code = $request->secondary_code;
      $secondaries->company_name = $request->company_name;
      $secondaries->manufacturer_name = $request->manufacturer_name;
      $secondaries->secondary_name = $request->secondary_name;
      $secondaries->supplier_name = $request->supplier_name;
      $secondaries->category = $request->category;
      $secondaries->sub_category = $request->sub_category;
      $secondaries->brand_name = $request->brand_name;
      $secondaries->weight = $request->weight;
      $secondaries->uomid = $request->uomid;
      $secondaries->save();
      Alert::success('Success', 'Secondary Successfully Updated');
      return redirect()->route('secondaries.edit',$id);
    } else {
      Alert::error('Error', 'Some Error Occurred');
      return redirect()->route('secondaries.edit',$id)->withErrors($validator)->withInput();
    }
  }

  public function destroy($id, Request $request) {
    $secondary = SecondaryLabel::find($id);
    $secondary->delete(); 
    Alert::success('Success', 'Secondary Deleted Successfully');
    return redirect()->back();
  }

  public function deletesecondary(Request $request){
    $ids = $request->ids;
    $secondary = SecondaryLabel::whereIn('id', $ids)->get();
    SecondaryLabel::whereIn('id', $ids)->delete();
    Alert::success('Success', 'Secondary Deleted Successfully');
    return redirect()->back();
  } 

  public function formPrimaryQRArray($qrCodes, $labelFrom, $labelTo) {
    $qrCodesArray = [];
    $counter = 0;
    $labelFrom--;
    for ($counter = $labelFrom; $counter<$labelTo; $counter++) {
      $value = $qrCodes[$counter];
      $qrCodeValue = "01" . str_pad($value, 10, '0', STR_PAD_LEFT);
      $filePath = public_path("qrcodes");
      // contiune;
      $fileName = "qrcode_$counter.svg";
      $filefullPath = $filePath.DIRECTORY_SEPARATOR.$fileName;
      $qrCode = QrCode::generate("$qrCodeValue", $filefullPath);
      // $qrCode = QrCode::format('png')->generate("$qrCodeValue", $filefullPath);
      $qrCodesArray[] = [
        'qrCode' => $filefullPath,
        'value' => $qrCodeValue,
      ];            
      // file_put_contents($filePath, $qrCode);
    }
    return $qrCodesArray;
  } 

  function formSecLabelDetail($priQRCodes, $serialNumCodes, $productCode, $batchNumber, $manufactureDate, $expiryDate) {
    $secLabelDetail = array();
    foreach($priQRCodes as $key=>$QRCode) {
      $secLabelDetail[] = array (
        "QRCode"=> $QRCode,
        "ProductCode"=> $productCode,
        "BatchNumber"=> $batchNumber,
        "SerialNumber"=> $serialNumCodes[$key],
        "ManufactureDate"=> date('d/m/Y', strtotime($manufactureDate)),
        "ExpiryDate"=> date('d/m/Y', strtotime($expiryDate))
      );
    }
    return json_encode($secLabelDetail);
  }

  public function secondaryPrint(Request $request, $id) { 
    $secondary = SecondaryLabel::find($id);
    $userProfile = UserProfile::where('user_id', $secondary->user_id)->first();
    $prependPriQRCode = config('constant.PREPEND_PRIMARY_CODE');
    $prependSecQRCode = config('constant.PREPEND_SECONDARY_CODE');
    $viewName = 'secondaries.';
    if ($secondary) {
      switch($secondary->LabelType->name) {
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
          $paperSize = array(0, 0, 71, 142);
          $viewName .= 'pdf';
          // $paperSize = array(0,0,311.88,311.88);
        break;
      }

      $pdf = PDF::loadView($viewName, [
        'secondary' => $secondary,
        'userProfile'=>$userProfile,
        'prependPriQRCode'=> $prependPriQRCode,
        'prependSecQRCode'=> $prependSecQRCode,
      ]);
      // return view('secondaries.pdfGreen',['secondary'=>$secondary,
      //   'userProfile'=>$userProfile,
      //   'prependPriQRCode'=> $prependPriQRCode,
      //   'prependSecQRCode'=> $prependSecQRCode,
      // ]); 
      $downloadedFileName = "secondaries_".$secondary->PrimaryLabel->BatchNumber.".pdf";
      $pdf->setPaper($paperSize, 'landscape');
      return $pdf->download("$downloadedFileName");
    } else {
      Alert::error('Error', 'Some Error Occurred');
      // $this->pr($validator->errors());
      // exit;
      return redirect()->route('secondaries.printLabel',$id)->withErrors($validator)->withInput();
    }
  }
}