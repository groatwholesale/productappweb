<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "categories";
    protected $fillable = ['name','image'];
    protected $hidden = ['deleted_at'];

    public function getImageAttribute($value)
    {
        if(empty($value) || is_null($value)){
            return "";
        }
        return asset("uploads/category/".$this->id)."/".$value;
    }
    public function products()
    {
        return $this->belongsTo(Product::class,'id','category_id');
    }
}
