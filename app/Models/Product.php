<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "products";
    protected $fillable = ['title','description','category_id'];
    protected $hidden = ['deleted_at'];

    public function attachments()
    {
        return $this->hasMany(ProductsImage::class,'product_id','id');
    }
}
