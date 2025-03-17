<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    use HasFactory;

    protected $fillable = ['zip_code_id', 'name', 'address', 'phone_number', 'email', 'status'];

    public function zipCode()
    {
        return $this->belongsTo(ZipCode::class);
    }
}
