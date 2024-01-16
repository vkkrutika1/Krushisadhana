<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\UnitOfMeasurement;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\UserProfile;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Item;
use App\Models\PrimaryLabel;
use App\Models\SecondaryLabel;
use Carbon\Carbon;

class CronController extends Controller {
  public $now = null;
  public function __construct() {
    $this->now = Carbon::now('utc')->toDateTimeString();
  }
  public function getApplications() {
    \Log::info("Started Cron job getApplications");
    $newApplications = null;
    $applications = $this->fetchAPIData('Master/GetKKISANApplications');
    if ($applications) {
      $modelObj = new Application();
      $this->recordInsert($modelObj, 'Application', $applications);
    }
  }

  public function getUnitOfMeasurements() {
    \Log::info("Started Cron job getUnitOfMeasurements");
    // $item = $this->fetchAPIData('Master/GetItemDetail?ApplicationID=FL');
    $uoms = $this->fetchAPIData('GetUnitOfMeasurements');
    if ($uoms) {
      $modelObj = new UnitOfMeasurement();
      $this->recordInsert($modelObj, 'UnitOfMeasurement', $uoms);
    }
  }

  public function getCategories() {
    \Log::info("Started Cron job getCategories");
    $applications = Application::where('local_status', 1)->pluck('ApplicationID');
    foreach ($applications as $application) {
      $categories = $this->fetchAPIData('Master/GetItemCategory?ApplicationID='.$application);
      if ($categories && is_array($categories)) {
        $modelObj = new Category();
        $this->recordInsert($modelObj, 'Category', $categories);
      }
    }
  }

  public function getSubCategories() {
    \Log::info("Started Cron job getSubCategories");
    $applications = Application::where('local_status', 1)->pluck('ApplicationID');
    foreach ($applications as $application) {
      $subCategories = $this->fetchAPIData('Master/GetItemSubCategory?ApplicationID='.$application);
      $this->pr($subCategories);
      if ($subCategories && is_array($subCategories)) {
        $modelObj = new SubCategory();
        $this->recordInsert($modelObj, 'SubCategory', $subCategories);
      }
    }
  }
  public function getItems() {
    \Log::info("Started Cron job getItems");
    $applications = Application::where('local_status', 1)->pluck('ApplicationID');
    foreach ($applications as $application) {
      $items = $this->fetchAPIData('Master/GetItemDetail?ApplicationID='.$application);
      $this->pr($items);
      if ($items && is_array($items)) {
        $modelObj = new Item();
        $this->recordInsert($modelObj, 'Item', $items);
      }
    }
  }

  function recordInsert($modelObj, $model, $apiRecords) {
    $newRecords = null;
    foreach ($apiRecords as $apiRecord) {
      switch($model) {
        case 'Application':
          $conditions = ['ApplicationID'=>$apiRecord->ApplicationID];
          $existingRecords[] = $apiRecord->ApplicationID;
        break; 
        case 'Category':
          $conditions = ['ItemCategoryID'=>$apiRecord->ItemCategoryID];
          $existingRecords[] = $apiRecord->ItemCategoryID;
        break; 
        case 'SubCategory':
          $conditions = ['ItemCategoryID'=>$apiRecord->ItemCategoryID, 'SubCategoryID'=>$apiRecord->SubCategoryID];
          $existingRecords[] = $apiRecord->SubCategoryID;
        break;
        case 'Item':
          $conditions = ['ItemCategoryID'=>$apiRecord->ItemCategoryID, 'SubCategoryID'=>$apiRecord->SubCategoryID, 'ItemID'=>$apiRecord->ItemID];
          $existingRecords[] = $apiRecord->ItemID;
        break;
        case 'UnitOfMeasurement':
          $conditions = ['UomID'=>$apiRecord->UomID];
          $existingRecords[] = $apiRecord->UomID;
        break;
      }
      $modelRecord = $modelObj::where($conditions)->first();
      if (!$modelRecord) {
        $apiRecordArr = (array) $apiRecord;
        $newRecord = array();
        foreach($apiRecordArr as $fieldName=>$value) {
          $newRecord["$fieldName"] = $value;
        }
        $newRecord['local_status'] = 1;
        $newRecord['created_at'] = $this->now;
        $newRecord['updated_at'] = $this->now;
        $newRecords[] = $newRecord;
      }
      // $this->pr($newRecords);
    }
    if ($newRecords) {
      $modelObj::insert($newRecords);
    }
  }

  public function getApplicationsBackup() {
    $newApplications = null;
    $applications = $this->fetchAPIData('Master/GetKKISANApplications');
    if ($applications) {
      // foreach ($applications as $application) {
      //   $applicationRecord = Application::where('application_id', $application->ApplicationID)->first();
      //   if (!$applicationRecord) {
      //     $newApplications[] = array(
      //       'application_id' => $application->ApplicationID, 
      //       'application_name' => $application->ApplicationName,
      //       'status' => 1,
      //       'created_at' => $this->now,
      //       'updated_at' => $this->now,
      //     );
      //   } 
      //   $existingApplications[] = $application->ApplicationID;
      // }
      // // $this->pr($existingApplications);
      // if ($newApplications) {
      //   Application::insert($newApplications);
      // }
      $modelObj = new Application();
      $this->recordInsert($modelObj, 'Application', $applications);
    }
  }

  public function getAPIToken($endPoint="token") {
    \Log::info("Started Cron job getAPIToken");
    $dataURL = $this->apiURL.$endPoint;
    $ch = curl_init($dataURL);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $payload = http_build_query(array("username"=>$this->userName, "password"=>$this->password, "grant_type"=>"password"));
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    
    // curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $contents = curl_exec($ch);
    if ($contents === false) {
      echo 'Curl error: ' . curl_error($ch);
    } 
    $data = json_decode($contents, true);
    // $this->pr($data);
    if ($data) {
      // UserProfile::where('id','>',0)->update(['access_token' => $data['access_token'], 'expires'=>$data['.expires']]);
      Setting::where('id','>',0)->update(['api_access_token' => $data['access_token'], 'api_token_expires_at'=>$data['.expires']]);
    }
    curl_close($ch);
    return $data;
  }


  public function apiSyncProducts() {
    \Log::info("Started Cron job apiSyncProducts");
    $settingModel = new Setting();
    $this->accessToken = $settingModel->getAPIAccessToken();
    $productObj = new Product();
    $productSelQryObj = $productObj->selectQuery();
    $productSelRecObj = $productSelQryObj->whereNull('api_sync_status')->get();
    if ($productSelRecObj) {
      foreach($productSelRecObj as $product) {
        $productData = array(
          "ApplicationID"=> $product->ApplicationID,
          "ProductCode"=> $product->ProductCode,
          "MarketedBy"=> $product->MarketedBy,
          "LicenseNumber"=> $product->LicenseNumber,
          "CIBRegistrationCertificate"=> $product->CIBRegistrationCertificate,
          "ManufacturerName"=> $product->ManufacturerName,
          "SupplierName"=> $product->SupplierName,
          "ItemCategoryID"=> $product->ItemCategoryID,
          "CategoryName"=> $product->Category->ItemCategoryName,
          "SubCategoryID"=> $product->SubCategoryID,
          "SubCategoryName"=> $product->SubCategoryName,
          "ItemID"=> $product->ItemID? $product->ItemID: 0,
          "ProductName"=> $product->ProductName,
          "BrandName"=> $product->BrandName,
          "UomID"=> $product->UomID,
          "Weight"=> $product->Weight
        );
        // $this->pr($productData);
        $apiResult = $this->postDatatoAPI("SaveProductMaster", $productData, $this->accessToken);
        $this->pr($apiResult);
        if ($apiResult && isset($apiResult['success'])) {
          Product::where('id', $product->id)->update(['api_sync_status' => true]);
        }
      }
    }
    exit; 
  }

  public function apiSyncPrimaryLabels(Request $request) {
    \Log::info("Started Cron job apiSyncPrimaryLabels");
    $settingModel = new Setting();
    $this->accessToken = $settingModel->getAPIAccessToken();
    $selectFields = array(
      'id',
      'QRCode',
      'ProductCode',
      'BatchNumber',
      'SerialNumber',
      'ManufactureDate',
      'ExpiryDate',
    );
    $productCodes = Product::where('is_secondary',0)->pluck('ProductCode');
    $primaryLabels = PrimaryLabel::select($selectFields)->whereIn('ProductCode', $productCodes)->whereNull('api_sync_status')->orderBy('id','desc')->get();
    // $this->pr($primaryLabels->toArray());
    // exit;
    if ($primaryLabels) {
      foreach($primaryLabels as $primary) {
        $qrCodes = json_decode($primary->QRCode);
        $serialNumbers = json_decode($primary->SerialNumber, true);
        $apiManufactureDate = date('d/m/Y', strtotime($primary->ManufactureDate));
        $apiExpiryDate = date('d/m/Y', strtotime($primary->ExpiryDate));
        foreach($qrCodes as $key=>$qrCode) { 
          $primaryLabelData[] = array (
            "QRCode"=>$qrCode,
            "ProductCode"=>$primary->ProductCode,
            "BatchNumber"=>$primary->BatchNumber,
            "SerialNumber"=>$serialNumbers[$key],
            "ManufactureDate"=>$apiManufactureDate,
            "ExpiryDate"=>$apiExpiryDate,
          );
        }
        
        $apiResult = $this->postDatatoAPI("SavePrimaryQRDetail", $primaryLabelData, $this->accessToken);
        if ($apiResult && isset($apiResult['success'])) {
          PrimaryLabel::where('id', $primary->id)->update(['api_sync_status' => true]);
        }
        // $this->pr($primaryLabelData);
        $this->pr($apiResult);
      }
    }
    exit;
  }

  public function apiSyncSecondaryLabels(Request $request) {
    \Log::info("Started Cron job apiSyncSecondaryLabels");
    $settingModel = new Setting();
    $this->accessToken = $settingModel->getAPIAccessToken();
    $selectFields = array(
      'id',
      'QRCode',
      'SecondaryContainerCode',
      'SecondaryLabelDetail',
    );
    $secondaryLabels = SecondaryLabel::select($selectFields)->whereNull('api_sync_status')->orderBy('id','desc')->get();
    // $this->pr($secondaryLabels->toArray());
    // exit;
    if ($secondaryLabels) {
      foreach($secondaryLabels as $secondaryRecord) {
        $postData['secondaryContainerDetail'][] = array(
          'QRCode' => $secondaryRecord['QRCode'],
          'SecondaryContainerCode' =>$secondaryRecord['SecondaryContainerCode'] ,
          'SecondaryLabelDetail' => json_decode($secondaryRecord["SecondaryLabelDetail"], true)
        );
        $apiResult = $this->postDatatoAPI("SaveSecondaryQRDetail", $postData, $this->accessToken);
        if ($apiResult && isset($apiResult['success'])) {
          SecondaryLabel::where('id', $secondaryRecord->id)->update(['api_sync_status' => true]);
        }
        // $this->pr($primaryLabelData);
        $this->pr($apiResult);
      }
    }
    exit;
  }
    
}
