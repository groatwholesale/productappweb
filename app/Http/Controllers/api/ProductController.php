<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Product;
use App\Models\Addtocart;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ApiResponser;
    public function index()
    {
        try{
            $search = request()->get('search');
            $product = Product::with('attachments:id,file_name,product_id')->orderBy('id','desc')->select('id','title','description','price')
            ->when(!is_null($search),function($query) use($search){
                $query->where('title','like','%'.$search.'%');
            })
            ->paginate(10);            
            return $this->successResponse($product,"Product retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function show($id=null)
    {
        try{
            $product = Product::with('attachments:id,file_name,product_id')->select('id','title','description','price')->where('id',$id)->first();
            return $this->successResponse($product,"Single Product retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function getaddtocart_products()
    {
        try{
            $carts=Addtocart::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
            return $this->successResponse($carts,"Product add carted Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function addtocart(Request $request)
    {
        try{
            return $this->successResponse($request->all(),"Product add carted Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }
}
