<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model {
  use HasFactory;

  public $timestamps = true;
  protected $table = 'user_profiles';
  protected $fillable = [
    'user_id',
    'phone',
    'company_name',
    'company_address',
    'company_district',
    'company_state',
    'company_pincode',
    'vendor_id',
    'LicenseNumber',
    'CIBRegistrationCertificate',
    'profile_pic',
  ];

  public function User() {
    return $this->hasMany(User::class);
  }
}
