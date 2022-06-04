<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "banners";
    protected $hidden =['deleted_at','updated_at'];

    public function getImageAttribute($val)
    {
        if(empty($val) || is_null($val)){
            return "";
        }
        return asset("uploads/banner")."/".$val;
    }
}
