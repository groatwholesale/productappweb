<?php

namespace App\Http\Controllers;

use App\Models\Addtocart;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $records = Addtocart::with(['products','users'])->orderBy('id','desc')->get();
            return view('orders.index',compact('records'));
        }
        catch(Exception $ex){
            return redirect()->route('home')->withError($ex->getMessage());
        }
    }

    public function lists(Request $request)
    {
        // try{
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
            $totalRecords = Addtocart::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Addtocart::select('count(*) as allcount')
            // ->where('name', 'like', '%' .$searchValue . '%')
            ->count();
        
            // Fetch records
            $records = Addtocart::with(['products','users'])->orderBy($columnName,$columnSortOrder)
                // ->where('addtocarts.name', 'like', '%' .$searchValue . '%')
                ->select(['addtocarts.*','users.name','products.title'])
                ->join('users','users.id','=','addtocarts.user_id')
                ->join('products','products.id','=','addtocarts.product_id')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            $data_arr = array();
            
            foreach($records as $record){
                $id = $record->id;
                $productname = $record->products->title;
                $username = $record->users->name;
                $quantity=$record->quantity;
        
                $data_arr[] = array(
                    "id" => $id,
                    "title" => $productname,
                    "name" => $username,
                    "quantity" => $quantity,
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
        // }
        // catch(Exception $ex){
        //     return redirect()->route('order.index')->withError($ex->getMessage());
        // }
    }
}
