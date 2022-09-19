<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddressDetails extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="order_address_details";
    protected $fillable=["order_id","address_details"];
}
