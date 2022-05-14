<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails())
            {
                return $this->errorResponse(['errors'=>$validator->errors()], 422);
            }
            $user = User::where('email', $request->email)->where('role_id',0)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return $this->successResponse($response,"Login Successfully");
                } else {
                    $response = ["message" => "Credentials does not match"];
                    return $this->errorResponse($response, 422);
                }
            } else {
                $response = ["message" =>'Credentials does not match'];
                return $this->errorResponse($response, 422);
            }
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
