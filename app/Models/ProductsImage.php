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
}
