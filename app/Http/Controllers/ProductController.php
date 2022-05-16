<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return view('products.index');
        }
        catch(Exception $ex){
            return redirect()->route('home')->withError($ex->getMessage());
        }
    }
    
    public function lists(Request $request)
    {
        try{
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page
        
            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');
        
            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value
        
            // Total records
            $totalRecords = Product::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Product::select('count(*) as allcount')->where('title', 'like', '%' .$searchValue . '%')->orWhere('description', 'like', '%' .$searchValue . '%')->count();
        
            // Fetch records
            $records = Product::orderBy($columnName,$columnSortOrder)
            ->where('products.title', 'like', '%' .$searchValue . '%')
            ->orWhere('products.description', 'like', '%' .$searchValue . '%')
            ->select('products.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        
            $data_arr = array();
            
            foreach($records as $record){
                $id = $record->id;
                $title = $record->title;
                $price = $record->price;
                $description = $record->description;
                $image = "Image";
        
                $data_arr[] = array(
                    "id" => $id,
                    "image" => $image,
                    "title" => $title,
                    "price" => $price,
                    "description" => $description,
                    "action" => '<div class="d-flex"><a href="'.route('products.edit',$id).'" class="btn btn-info"><i class="fa fa-edit"></i></a><a onclick="event.preventDefault();
                    document.getElementById(\'productsdelete-form\').submit();" class="btn btn-danger"><i class="fa fa-trash"></i></a></div><form id="productsdelete-form" action="'.route('products.destroy',$id) .'" method="POST" class="d-none">'.csrf_token().'<input type="hidden" name="_method" value="DELETE"></form>'
                );
            }
        
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );
        
            echo json_encode($response);
            exit;
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $category = Category::orderBy('name','asc')->get();
            return view('products.create',compact('category'));
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        try{
            $product = new Product;
            $product->title=$request->title;
            $product->description=$request->description;
            $product->category_id=$request->category;
            $product->price=$request->price;
            if($product->save()){
                foreach($request->images as $file){
                    $destinationpath=public_path("uploads/products/".$product->id)."/".
                    $file->move();
                }
                return redirect()->route('products.index')->withSuccess("Product stored successfully.");
            }
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try{
            return view('products.show',compact('products'));
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        try{
            $category = Category::orderBy('name','asc')->get();
            return view('products.edit',compact('product','category'));
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try{
            $product->update(['title'=>$request->title,'description'=>$request->description,'price'=>$request->price,'category_id'=>$request->category]);
            return redirect()->route('products.index')->withSuccess("Products updated successfully.");
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
            if($product->delete()){
                return redirect()->route('products.index')->withSuccess("Product deleted successfully.");
            }
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }
}
