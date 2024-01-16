<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model {
  use HasFactory;
  public $timestamps = true;
  protected $fillable = [
    'name',
    'status',
  ];

  public function Product() {
    return $this->hasMany(Product::class);
  }
}