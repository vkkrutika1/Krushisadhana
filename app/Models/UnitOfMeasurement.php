<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UnitOfMeasurement extends Model {
  use HasFactory;
  public $timestamps = true;
  protected $fillable = [
    'name',
    'status',
  ];

  public function PrimaryLabel() {
    return $this->hasMany(PrimaryLabel::class);
  }

  public function Product() {
    return $this->hasMany(Product::class);
  }

  public function SecondaryLabel() {
    return $this->hasMany(SecondaryLabel::class);
  }
}
