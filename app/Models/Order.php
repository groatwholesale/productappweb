<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="orders";
    protected $fillable=['user_id','status','total_price'];
    protected $hidden=['deleted_at','updated_at'];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id')->withDefault()->withTrashed();
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault()->withTrashed();
    }

    public function orderproducts()
    {
        return $this->hasMany(Orderproduct::class,'order_id','id');
    }
}
