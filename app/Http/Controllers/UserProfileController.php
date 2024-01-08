<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfileController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth');
    }

    public function viewUserInfo(Request $request, string $id)
    {
    
        $user = User::find($id);


        if (empty($user)) {
            $success = false;
            $response = ['error'=>'no user found'];

        }else {
            $success = true;
            $response = ['user' => $user];
        }
        
        return [
            'success'=>$success,
            'response'=>$response
        ];

        
    }

    public function editUserInfo(Request $request, $id)
    {
        $data = $request -> all();
        $user = User::find($id);

        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }

        $result = $user->save();

        return ['success'=> $result , "response"=>$user];
    }

    public function deleteUserProfile(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            $success = false;
            $response = ['error'=>'user could not be found'];

        }else {
            $success = $user->delete();
            $response = ['message' => 'user has been successfully deleted'];
        }

        return ['success'=>$success , 'response' => $response];
    }

}
