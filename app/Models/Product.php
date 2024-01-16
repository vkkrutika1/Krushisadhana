<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model {
  use HasFactory;
  public $timestamps = true;
  protected $fillable = [
    'ApplicationID',
    'ProductCode',
    'ManufacturerName',
    'MarketedBy',
    'is_secondary',
    'LicenseNumber',
    'CIBRegistrationCertificate',
    'SupplierName',
    'ItemCategoryID',
    'SubCategoryID',
    'SubCategoryName',
    'ItemID',
    'ProductName',
    'BrandName',
    'UomID',
    'Weight',
    'company_name',
    'api_sync_status',
    'local_status',
    'user_id',
  ];

  protected $with = ['Application','UnitOfMeasurement','Category','SubCategory','Item'];

  public function UnitOfMeasurement() {
    return $this->belongsTo(UnitOfMeasurement::class, 'UomID', 'id');
  }

  public function Application() {
    return $this->belongsTo(Application::class, 'ApplicationID', 'id');
  }

  public function Category() {
    return $this->belongsTo(Category::class, 'ItemCategoryID', 'ItemCategoryID');
  }

  public function SubCategory() {
    return $this->belongsTo(SubCategory::class, 'SubCategoryID', 'id');
  }

  public function Item() {
    return $this->belongsTo(Item::class, 'ItemID', 'id');
  }

  public function PrimaryLabel() {
    return $this->hasMany(PrimaryLabel::class);
  }

  public function SecondaryLabel() {
    return $this->hasMany(SecondaryLabel::class);
  }

  public function selectQuery() {
    $selectFields = array (
      'products.id as id',
      'company_name',
      'products.created_at as created_at',
      'products.api_sync_status as api_sync_status',
      'products.is_secondary as is_secondary',
      'products.ApplicationID as ApplicationID',
      'ProductCode',
      'MarketedBy',
      'LicenseNumber',
      'CIBRegistrationCertificate',
      'ManufacturerName',
      'SupplierName',
      'products.ItemCategoryID as ItemCategoryID',
      'products.SubCategoryID as SubCategoryID',
      // 'SubCategoryName',
      'sub_categories.SubCategoryName as SubCategoryName',
      'ItemID',
      'ProductName',
      'BrandName',
      'UomID',
      'Weight',
    );
    $objProductRecords = Product::select($selectFields)
      ->join('sub_categories', function ($join) {
        $join->on('products.ApplicationID', '=', 'sub_categories.ApplicationID')
        ->On('products.SubCategoryID', '=', 'sub_categories.SubCategoryID');
    });
    if (!(Auth::user()->role_id)) {
      $userID = Auth::user()->id;
      $objProductRecords = $objProductRecords->where('user_id', $userID);
    }
    return $objProductRecords;
  }
}