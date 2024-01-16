<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabelType extends Model {
    use HasFactory;

  public $timestamps = true;
  protected $table = 'label_types';
  protected $fillable = [
    'name',
    'display_name',
    'status',
  ];

  public function PrimaryLabel() {
    return $this->hasMany(PrimaryLabel::class);
  }
}
