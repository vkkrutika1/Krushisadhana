<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryLabel extends Model {
  use HasFactory;
  protected $fillable = [
    'SecondaryContainerCode',
    'Secondary_quantity',
    'Secondary_QRCode',
    'ProductCode',
    'primary_label',
    'SerialNumber',
    'QRCode',
    'label_type',
    'status',
  ];

  protected $with = ['LabelType','PrimaryLabel','Product'];

    public function LabelType() {
      return $this->belongsTo(LabelType::class, 'label_type', 'id');
    }

    public function Product() {
      return $this->belongsTo(Product::class, 'ProductCode', 'ProductCode');
    }

    public function PrimaryLabel() {
      return $this->belongsTo(PrimaryLabel::class, 'primary_label_id', 'id');
    }
}
