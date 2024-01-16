<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    protected $fillable = [

      'name',
      'item_category_id',
      'sub_category_id',
      'item_id',
      'uom_id',
      'packet_size',
      'status',

    ];

    public function Product() {
      return $this->hasMany(Product::class);
    }
}
