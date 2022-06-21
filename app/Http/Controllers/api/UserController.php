<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'phonenumber' => 'required|numeric'
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            $user = User::where('phonenumber', $request->phonenumber)->where('role_id',0)->first();
            if ($user) {
                $user->otp=rand(1111,9999);
                $user->role_id=0;
                $user->save();
                // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['user' => $user];
            } else {
                $user=new User;
                $user->phonenumber=$request->phonenumber;
                $user->otp=rand(1111,9999);
                $user->role_id=0;
                $user->save();
                // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ["user" => $user];
            }
            return $this->successResponse($response,"Login Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function opt_verification(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'otp' => 'required|numeric',
                'user_id' => 'required|numeric'
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            $user = User::where(['otp'=>$request->otp,'id'=>$request->user_id])->where('role_id',0)->first();
            if ($user) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                $user->otp=null;
                $user->save();
                return $this->successResponse($response,"Login Successfully");
            } else {
                return $this->errorResponse("Please enter valid OTP", 422);
            }
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function get_profile()
    {
        try{
            $response = ['user' => Auth::user()];
            return $this->successResponse($response,"Profile details retrieved Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function update_profile(Request $request)
    {
        try{
            $user=User::find(Auth::user()->id);
            if(isset($request->name) && !empty($request->name)){
                $user->name=$request->name;
            }
            if(isset($request->email) && !empty($request->email)){
                $user->email=$request->email;
            }
            if(isset($request->birth_date) && !empty($request->birth_date)){
                $user->birth_date=$request->birth_date;
            }
            if(isset($request->gender) && !empty($request->gender)){
                $user->gender=$request->gender;
            }
            if(isset($request->address) && !empty($request->address)){
                $user->address=$request->address;
            }
            if(isset($request->pincode) && !empty($request->pincode)){
                $user->pincode=$request->pincode;
            }
            $user->save();
            $response = ['user' => $user];
            return $this->successResponse($response,"Profile details updated Successfully");
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }

    public function logout (Request $request) {
        try{
            $token = $request->user()->token();
            $token->revoke();
            $response = ['message' => 'You have been successfully logged out!'];
            return response($response, 200);
        }catch(Exception $ex){
            return $this->errorResponse($ex->getMessage(), 422);
        }
    }
}
