<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;

    protected $fillable = [

      'name',
      'item_category_id',
      'status',

    ];

    public function Product() {
      return $this->hasMany(Product::class);
    }

    public function PrimaryLabel() {
      return $this->hasMany(PrimaryLabel::class);
    }
}
