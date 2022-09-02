<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsImage;
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
            $category=Category::has('products')->orderBy('name','asc')->select('id','name')->get();
            return view('products.index',compact('category'));
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
            $category_id=$request->has('category_id') ? $request->category_id : null;
            // Total records
            $totalRecords = Product::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Product::select('count(*) as allcount')
            ->where(function($query) use($searchValue){
                $query->where('title', 'like', '%' .$searchValue . '%')->orWhere('description', 'like', '%' .$searchValue . '%');
            })
            ->when(!is_null($category_id), function($query) use($category_id){
                $query->where('category_id',$category_id);
            })
            ->count();
        
            // Fetch records
            $records = Product::with('category')->orderBy($columnName,$columnSortOrder)
            ->where(function($query) use($searchValue){
                $query->where('products.title', 'like', '%' .$searchValue . '%')
                ->orWhere('products.description', 'like', '%' .$searchValue . '%');
            })
            ->when(!is_null($category_id), function($query) use($category_id){
                $query->where('category_id',$category_id);
            })
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
                $category = is_null($record->category) ? "---" : $record->category->name ;
                $data_arr[] = array(
                    "id" => $id,
                    "title" => $title,
                    "price" => $price,
                    "category" => $category,
                    "description" => $description,
                    "action" => '<div class="d-flex"><a href="'.route('products.edit',$id).'" class="btn btn-info"><i class="fa fa-edit"></i></a><a href="'.route('products.delete',$id).'" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>'
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
            $product->is_product_top=isset($request->producttop) ? 1 :0;
            if($product->save()){
                if(!is_null($request->images)){
                    foreach($request->images as $index=>$file){
                        $imagename = $index.time().'.'.$file->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads/products/'.$product->id);
                        $file->move($destinationPath, $imagename);
                        $product_images=new ProductsImage;
                        $product_images->file_name=$imagename;
                        $product_images->product_id=$product->id;
                        $product_images->save();
                    }
                }
                return redirect()->route('products.index')->withSuccess("Product stored successfully.");
            }
        }
        catch(Exception $ex){
            dd($ex->getMessage());
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
            if(!is_null($request->images)){
                foreach($request->images as $index=>$file){
                    $imagename = $index.time().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/products/'.$product->id);
                    $file->move($destinationPath, $imagename);
                    $product_images=new ProductsImage;
                    $product_images->file_name=$imagename;
                    $product_images->product_id=$product->id;
                    $product_images->save();
                }
            }
            $product->update(['title'=>$request->title,'description'=>$request->description,'price'=>$request->price,'category_id'=>$request->category,'is_product_top'=>intval($request->producttop)]);
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
    public function destroy($id=null)
    {
        try{
            if(Product::where('id',$id)->delete()){
                ProductsImage::where('product_id',$id)->delete();
                return redirect()->route('products.index')->withSuccess("Product deleted successfully.");
            }
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }

    public function product_delete_image($id)
    {
        try{
            $productid=ProductsImage::where('id',$id)->first();
            $singleproduct=$productid->product_id;
            @unlink(public_path("uploads/products/".$singleproduct."/".$productid->getRawOriginal('file_name')));
            ProductsImage::where('id',$id)->delete();
            return redirect()->route('products.edit',$id)->withSuccess("Product image deleted successfully.");
        }
        catch(Exception $ex){
            return redirect()->route('products.index')->withError($ex->getMessage());
        }
    }
}
