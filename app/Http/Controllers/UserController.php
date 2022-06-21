<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return view('users.index');
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
            $totalRecords = User::select('count(*) as allcount')->where('users.role_id',0)->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('users.role_id',0)
            ->where(function($query) use($searchValue){
                $query->where('name', 'like', '%' .$searchValue . '%')
                ->orWhere('phonenumber', 'like', '%' .$searchValue . '%')
                ->orWhere('email', 'like', '%' .$searchValue . '%')
                ->orWhere('birth_date', 'like', '%' .$searchValue . '%')
                ->orWhere('address', 'like', '%' .$searchValue . '%');
            })
            ->count();
        
            // Fetch records
            $records = User::orderBy($columnName,$columnSortOrder)
                ->where('users.role_id',0)
                ->where(function($query) use($searchValue){
                    $query->where('name', 'like', '%' .$searchValue . '%')
                    ->orWhere('phonenumber', 'like', '%' .$searchValue . '%')
                    ->orWhere('email', 'like', '%' .$searchValue . '%')
                    ->orWhere('birth_date', 'like', '%' .$searchValue . '%')
                    ->orWhere('address', 'like', '%' .$searchValue . '%');
                })->select('users.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        
            $data_arr = array();
            
            foreach($records as $record){
                $id = $record->id;
                $name = $record->name;
                $email = $record->email;
                $phonenumber = $record->phonenumber;
                $birth_date = $record->birth_date;
                $address = $record->address;
        
                $data_arr[] = array(
                    "id" => $id,
                    "name" => $name,
                    "phonenumber" => $phonenumber,
                    "email" => $email,
                    "birth_date" => $birth_date,
                    "address" => $address,
                    "action" => '<div class="d-flex"><a href="'.route('users.edit',$id).'" class="btn btn-info"><i class="fa fa-edit"></i></a><a href="'.route('users.delete',$id).'" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>'
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
            return redirect()->route('users.index')->withError($ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $user=User::where('role_id',0)->findOrFail($id);
            return view('users.edit',compact('user'));
        }
        catch(Exception $ex){
            return redirect()->route('user.index')->withError($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try{
            $user=User::where('id',$id)->update($request->only(['birth_date','gender','name','email','address']));
            return redirect()->route('users.index')->withSuccess("User updated successfully.");
        }
        catch(Exception $ex){
            return redirect()->route('users.index')->withError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=null)
    {
        try{
            if(User::where('id',$id)->delete()){
                return redirect()->route('users.index')->withSuccess("User deleted successfully.");
            }
        }
        catch(Exception $ex){
            return redirect()->route('users.index')->withError($ex->getMessage());
        }
    }
}
