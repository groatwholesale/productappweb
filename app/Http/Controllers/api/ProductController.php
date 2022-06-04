<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Product;
use App\Models\Addtocart;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderproduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            return $this->successResponse($carts,"Add to cart Product retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function addtocart(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'products' => 'required'
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            $products=json_decode($request->products,true);
            if(count($products)>0){
                foreach($products as $product){
                    $cart=new Addtocart;
                    $cart->user_id=Auth::user()->id;
                    $cart->product_id=$product['productid'];
                    $cart->quantity=$product['quantity'];
                    $cart->save();
                }
            }
            return $this->successResponse($request->all(),"Product add to carted Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function updatecartproducts(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|numeric',
                'quantity' => 'required|numeric'
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            Addtocart::where(['id'=>$request->order_id])->update(['quantity'=>$request->quantity]);
            return $this->successResponse($request->all(),"Update add to cart product Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }
    
    public function deletecartproducts(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|numeric'
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            Addtocart::where(['id'=>$request->order_id])->delete();
            return $this->successResponse($request->all(),"add to cart product removed Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function topproduct()
    {
        try{
            $product = Product::with('attachments:id,file_name,product_id')->select('id','title','description','price')->where('is_product_top',1)->get();
            return $this->successResponse($product,"Top 10 Product retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function getbuyproduct()
    {
        try{
            $product = Order::with('orderproducts.products')->get();
            return $this->successResponse($product,"Get Buy Products retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function buyproduct(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'products' => 'required',
                'total_price' => 'required'
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            $products=json_decode($request->products,true);
            if(count($products)>0){
                $order=new Order;
                $order->total_price=$request->total_price;
                $order->user_id=Auth::user()->id;
                $order->save();
                foreach($products as $product){
                    $cart=new Orderproduct();
                    $cart->user_id=Auth::user()->id;
                    $cart->product_id=$product['productid'];
                    $cart->order_id=$order->id;
                    $cart->quantity=$product['quantity'];
                    $cart->price=$product['price'];
                    $cart->save();
                }
            }
            return $this->successResponse($request->all(),"Order added Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }
}
