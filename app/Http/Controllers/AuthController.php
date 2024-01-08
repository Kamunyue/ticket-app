<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function signUp(Request $request){
        $validated_credentials = $request->validate([
            'name'=>'required|min:3|max:20|unique:users',
            'email'=>'email|unique:users',
            'password'=>'required|confirmed'
        ]);
 
        try {
            $user = new User;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->role = $user->getDefaultRole();

            $user->save();

            return response()->json(['msg'=> 'signup successful']);
        } catch (err) {
            return response()->json(['err'=> err]);
        }
        
    }
    public function logIn(Request $request)
    {
        $credentials = $request->only('email','password');
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('auth-token')->plainTextToken;
 
            return response()->json(['msg'=>'Login Successful','auth-token'=>$token]);
        }else{
            return response()->json('error');
        }
    }

    public function logOut(Request $request)
    {
        $user= $request->user();

        $user->tokens ()->delete();

        return response()->json(['msg'=>'Logged out successfully']);
    }


}
