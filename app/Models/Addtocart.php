<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addtocart extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="addtocarts";
    protected $fillable=['user_id','product_id','quantity'];
    protected $hidden=['deleted_at','updated_at'];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
