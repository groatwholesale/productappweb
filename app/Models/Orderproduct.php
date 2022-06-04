<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderproduct extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "order_products";
    protected $hidden=['deleted_at','updated_at'];
    
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id')->withDefault()->withTrashed();
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault()->withTrashed();
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id')->withDefault()->withTrashed();
    }
}
