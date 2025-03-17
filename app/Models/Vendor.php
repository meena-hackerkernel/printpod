<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Authenticatable
{
    use HasFactory;

    protected $table = 'vendors';
    
    protected $fillable = ['zip_code_id', 'name', 'address', 'phone_number', 'email', 'password', 'status'];

    public function zipCode()
    {
        return $this->belongsTo(ZipCode::class);
    }
}
