<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return view('category.index');
        }
        catch(Exception $ex){
            return redirect()->route('category.index')->withError($ex->getMessage());
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
            $totalRecords = Category::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Category::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();
        
            // Fetch records
            $records = Category::orderBy($columnName,$columnSortOrder)
                ->where('categories.name', 'like', '%' .$searchValue . '%')
                ->select('categories.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        
            $data_arr = array();
            
            foreach($records as $record){
                $id = $record->id;
                $name = $record->name;
        
                $data_arr[] = array(
                    "id" => $id,
                    "name" => $name,
                    "action" => '<div class="d-flex"><a href="'.route('category.edit',$id).'" class="btn btn-info"><i class="fa fa-edit"></i></a><a onclick="event.preventDefault();
                    document.getElementById(\'categorydelete-form\').submit();" class="btn btn-danger"><i class="fa fa-trash"></i></a></div><form id="categorydelete-form" action="'.route('category.destroy',$id) .'" method="POST" class="d-none">'.csrf_token().'<input type="hidden" name="_method" value="DELETE"></form>'
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
            return redirect()->route('category.index')->withError($ex->getMessage());
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
            return view('category.create');
        }
        catch(Exception $ex){
            return redirect()->route('category.index')->withError($ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try{
            $category = new Category;
            $category->name=$request->categoryname;
            if($category->save()){
                return redirect()->route('category.index')->withSuccess("Category stored successfully.");
            }
        }
        catch(Exception $ex){
            return redirect()->route('category.index')->withError($ex->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        try{
            return view('category.edit',compact('category'));
        }
        catch(Exception $ex){
            return redirect()->route('category.index')->withError($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try{
            $category->update(['name'=>$request->categoryname]);
            return redirect()->route('category.index')->withSuccess("Category updated successfully.");
        }
        catch(Exception $ex){
            return redirect()->route('category.index')->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try{
            if($category->delete()){
                return redirect()->route('category.index')->withSuccess("Category deleted successfully.");
            }
        }
        catch(Exception $ex){
            return redirect()->route('category.index')->withError($ex->getMessage());
        }
    }
}
