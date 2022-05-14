<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use ApiResponser;
    public function index($id=null)
    {
        try{
            if(is_null($id)){
                $product = Product::orderBy('id','desc')->select('id','title','description')->paginate(10);
            }
            else
            {
                $product = Product::select('id','title','description')->where('id',$id)->first();
            }
            return $this->successResponse($product,"Product retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }
}
