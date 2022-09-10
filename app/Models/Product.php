<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "products";
    protected $fillable = ['title','description','category_id','price','is_product_top'];
    protected $hidden = ['updated_at','deleted_at'];

    public function attachments()
    {
        return $this->hasMany(ProductsImage::class,'product_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
