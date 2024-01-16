<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Setting;


class StatusCheckController extends Controller {
  public function index() {
    return view('statuscheck.index');
  }

  public function checkLabel(Request $request) {
    $validator = Validator::make($request->all(),[
      'qrCode' => ['required', 'numeric', 'digits:10'],
      'type'=>['required']
    ]);
    if ($validator->passes()) {
      $settingModel = new Setting();
      $this->accessToken = $settingModel->getAPIAccessToken();
      $type = 'primary';
      switch($request->type) {
        case 'primary':
          $endPoint = 'GetPrimaryDetail';
        break;
        case 'secondary':
          $endPoint = 'GetSecondaryDetail';
        break;
      }
      $endPoint .= '?QRCode='.$request->qrCode;
      $result = $this->getDataFromAPI($endPoint, $this->accessToken);
      return redirect()->back()->with('result', $result);
    } else {
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }

  public function checkProduct(Request $request) {
    $validator = Validator::make($request->all(),[
      'productCode' => ['required', 'numeric', 'digits:14'],
    ]);
    if ($validator->passes()) {
      $settingModel = new Setting();
      $this->accessToken = $settingModel->getAPIAccessToken();
      $endPoint = 'GetProductDetail?ProductCode='.$request->productCode;
      $result = $this->getDataFromAPI($endPoint, $this->accessToken);
      // exit;
      return redirect()->back()->with('result', $result);
    } else {
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }
}
