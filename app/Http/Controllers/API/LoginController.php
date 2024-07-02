<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function WaiterLogin(Request $request)
    {
           
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $admin = Admin::where('type','Waiter')->where('email',$request->email)->first();
            if($admin && Hash::check($request->password,$admin->password))
            {
                $token = $admin->createToken($request->email)->plainTextToken;
                return response([
                    'token' => $token,
                    'message'=>'Login Successfully',
                    'status'=> 'success'
                ],200);

            }
            return response([
                'message' =>'The Provided Credentials are incorrect',
                'status' =>'failed'
            ],401);


    }

    public function WaiterLogout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' =>'Logout Success',
            'status' =>'success'
        ],200);
    }

}
