<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrimaryLabel extends Model {
    use HasFactory;
    // protected $table = 'primary_labels';

    protected $fillable = [
      'ApplicationID',
      'ProductCode',
      'ManufacturerName',
      'SupplierName',
      'ItemCategoryID',
      'SubCategoryID',
      'BrandName',
      'UomID',
      'Weight',
      'BatchNumber',
      'SerialNumber',
      'ManufactureDate',
      'ExpiryDate',
      'QRCode',
      'status',
      'quantity',
      'label_type',
      'mrp',
    ];

    protected $with = ['LabelType','UnitOfMeasurement','Category','SubCategory','Product'];

    public function LabelType() {
      return $this->belongsTo(LabelType::class, 'label_type', 'id');
    }

    public function UnitOfMeasurement() {
      return $this->belongsTo(UnitOfMeasurement::class, 'UomID', 'id');
    }

    public function Category() {
      return $this->belongsTo(Category::class, 'ItemCategoryID', 'id');
    }

    public function SubCategory() {
      return $this->belongsTo(SubCategory::class, 'SubCategoryID', 'id');
    }

    public function Product() {
      return $this->belongsTo(Product::class, 'ProductCode', 'ProductCode');
    }

    public function SecondaryLabel() {
      return $this->hasMany(SecondaryLabel::class);
    }
}

