<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsImage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="products_image";
    protected $fillable=['file_name','product_id'];
    protected $hidden=['deleted_at'];
    
    public function getFileNameAttribute($value)
    {
        if(empty($value) || is_null($value)){
            return "";
        }
        return asset("uploads/products/".$this->product_id)."/".$value;
    }
}
