<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiResponser;
    public function index()
    {
        try{
            $category = Category::orderBy('id','desc')->select('id','name','image')->get();
            return $this->successResponse($category,"Category retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }
}
