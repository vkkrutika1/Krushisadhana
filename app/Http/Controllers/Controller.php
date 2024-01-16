<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Log;
use Auth;
use App\Models\PrimaryLabel;
use App\Models\SecondaryLabel;
use App\Models\UserProfile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class Controller extends BaseController {
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
 // public $apiURL = "https://kkisan.karnataka.gov.in/KKISANQRAPI/api/";
  public $apiURL = "https://example.com/api/";
  public $userName = "sadukthi@gmail.com";
  public $password = '$Adukthi@432!';
  public $accessToken = '';

  public function fetchAPIData($endPoint) { 
    $dataURL = $this->apiURL.$endPoint;
    $ch = curl_init($dataURL);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $contents = curl_exec($ch);
    if ($contents === false) {
      echo 'Curl error: ' . curl_error($ch);
    } 
    $data = json_decode($contents);
    curl_close($ch);
    return $data;
  }

  public function pr($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }

  public function getPrependCode($codeType='') {
    $prependProCode = config('constant.PREPEND_PRODUCT_CODE');
    $prependConCode = config('constant.PREPEND_CONTAINER_CODE');
    $portalID = config('constant.PORTAL_ID');
    $vendorID = Auth::user()->UserProfile->vendor_id;
    $prependCode = '';
    switch($codeType) {
      case 'product':
        $prependCode = $prependProCode;
      break;
      case 'container':
        $prependCode = $prependConCode;
      break;
    }
    $prependCode .= $portalID.$vendorID;
    return $prependCode;
  }

  public function postDatatoAPI($endPoint, $postData, $token) {
    header('Content-Type: application/json'); // Specify the type of data
    $dataURL = $this->apiURL.$endPoint;
    $ch = curl_init($dataURL); // Initialise cURL
    // $this->pr($postData);
    $post = json_encode($postData); // Encode the data array into a JSON string
    // echo $post;
    // exit;
    $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
    // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
    $contents = curl_exec($ch); // Execute the cURL statement
    // exit;
    if ($contents === false) {
      $error = 'Curl error: ' . curl_error($ch);
      Log::error($error);
    } else { 
      if ($contents) {
        $info = curl_getinfo($ch);
        $data = json_decode(json_encode($contents), true);
        json_decode($contents);
        // $this->pr($data);
        if ($info && $info['http_code'] > 299) {
          $info = 'Api Returns Error'.serialize($contents);
          Log::info($info);
        }
        // $data = json_decode($contents);
      } else {
        $data = array("success"=>true, "Message"=>"Successfull");
      }
    }
    // echo 'came here'.$this->pr($data);
    // exit;
    curl_close($ch);
    return $data;
  }

  public function getAPIToken($endPoint="token") {
    $dataURL = $this->apiURL.$endPoint;
    $ch = curl_init($dataURL);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $payload = http_build_query(array("username"=>$this->userName, "password"=>$this->password, "grant_type"=>"password"));
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    
    // curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $contents = curl_exec($ch);
    if ($contents === false) {
      echo 'Curl error: ' . curl_error($ch);
    } 
    $data = json_decode($contents, true);
    // $this->pr($data);
    if ($data) {
      UserProfile::where('id','>',0)->update(['access_token' => $data['access_token'], 'expires'=>$data['.expires']]);
    }
    curl_close($ch);
    return $data;
  }

  public function getLastRecordCounter() {
    // $primaryRecord = 1300;
    $primaryRecord = 0;
    $primaryRecord += PrimaryLabel::sum('quantity') ?? 0;  
    // $secondaryRecord = PrimaryLabel::sum('quantity') ?? 0; 
    // $secondaryRecord = SecondaryLabel::sum('primary_quantity') ?? 0;  
    $secondaryRecord = SecondaryLabel::get()->count() ?? 0;  
    return $lastRecord = $primaryRecord + $secondaryRecord;
  }

  public function generateQrCodes($qrCodes, $labelFrom, $labelTo, $type, $recordID) {
    $qrCodesArray = [];
    $counter = 0;
    $labelFrom--;
    switch($type) {
      case 'primary':
        $prependQRCode = config('constant.PREPEND_PRIMARY_CODE');
      break;
      case 'secondary':
        $prependQRCode = config('constant.PREPEND_SECONDARY_CODE');
      break;
    }
    // echo $prependCode = $this->getPrependCode();
    // echo '<br/>';
    $filePath = public_path("qrcodes".DIRECTORY_SEPARATOR."$type".DIRECTORY_SEPARATOR."$recordID");
    if (!file_exists("$filePath")) {
      mkdir("$filePath", 0777, true);
    }
    for ($counter = $labelFrom; $counter<$labelTo; $counter++) {
      $value = $qrCodes[$counter];
      // $qrCodeValue = $prependCode . str_pad($value, 10, '0', STR_PAD_LEFT);
      $dbQRCodeValue = str_pad($value, 10, '0', STR_PAD_LEFT);
      $imgQRCode = $prependQRCode.$dbQRCodeValue;
      // contiune;
      $fileName = "qrcode_$dbQRCodeValue.svg";
      $filefullPath = $filePath.DIRECTORY_SEPARATOR.$fileName;
      if (!file_exists("$filefullPath")) {
        $qrCode = QrCode::generate("$imgQRCode", $filefullPath);
      }
      // $qrCode = QrCode::format('png')->generate("$qrCodeValue", $filefullPath);
      $qrCodesArray[] = [
        'qrCode' => $filefullPath,
        'value' => $dbQRCodeValue,
        'prependQRCode' => $prependQRCode,
      ];       
      // echo '<br/>';     
      // file_put_contents($filePath, $qrCode);
    }
    // exit;
    return $qrCodesArray;
  }
  public function generateSecQRCodes() {
    $selectFields = array(
      'id',
      'QRCode',
      'SecondaryContainerCode',
      'SecondaryLabelDetail',
    );
    $objSecondaryRecords = SecondaryLabel::select($selectFields)
      // ->where('ProductCode',$product->ProductCode)
      // ->whereNull('api_sync_status')
    ->get();
    foreach($objSecondaryRecords as $secondaryRecord) {
      $secondaryRecord["SecondaryLabelDetail"] = json_decode($secondaryRecord["SecondaryLabelDetail"], true);
      $secondaryContainerDetail["secondaryContainerDetail"][] = $secondaryRecord;
      $secQRCodes = array($secondaryRecord->QRCode);
      $this->generateQrCodes($secQRCodes, 1, 1, "secondary", $secondaryRecord->id);
    }
  }

  public function generatePriQRCodes() {
    $selectFields = array(
      'id',
      'QRCode',
      'quantity',
    );
    $objPrimaryRecords = PrimaryLabel::select($selectFields)
    ->get();
      // ->where('ProductCode',$product->ProductCode)
      // ->whereNull('api_sync_status')
    foreach($objPrimaryRecords as $primary) {
      $labelFrom = 1;
      $labelTo = $primary->quantity;
      $qrCodes = json_decode($primary->QRCode);
      $qrCodesArray = $this->generateQrCodes($qrCodes, $labelFrom, $labelTo, 'primary',$primary->id);
    }
  }

   public function getDataFromAPI($endPoint, $token) {
    echo $dataURL = $this->apiURL.$endPoint;
    $ch = curl_init($dataURL);
    // curl_setopt($ch, CURLOPT_POST, TRUE);
    $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $contents = curl_exec($ch);
    if ($contents === false) {
      echo 'Curl error: ' . curl_error($ch);
    } 
    // $data = json_decode($contents, true);
    // $this->pr($data);
    curl_close($ch);
    return $contents;
  }
}