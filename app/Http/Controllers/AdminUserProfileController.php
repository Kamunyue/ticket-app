<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserProfileController extends Controller
{
    // gets all users from db
    public function getAllUsers()
    {
        $users = User::all();

        if (empty($users)) {
            return [
                'success' =>false,
                'response'=> [
                    'error' => 'no users found'
                ]
                ];
        }

        return[
            'success' => true,
            'response' => 
            [
                'users' => $users
            ]
            ];
    }

    // search for user by name
    public function searchUserByName($name)
    {
        return User::where('name', 'like', '%'.$name.'%')->get();
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
    

    
}
