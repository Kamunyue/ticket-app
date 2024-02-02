<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function inputRoute(Request $request)
    {
        $request->validate([
            'departure_location'=>'required',
            'arrival_location'=>'required',
            'fare'=>'required',
        ]);
        $route = new Route;

        $route->departure_location=$request->departure_location;
        $route->arrival_location=$request->arrival_location;
        $route->fare=$request->fare;

        $route->save();      
    }
    public function readRoute(Request $request, $id){
        $route = Route :: find($id);
        
        return [$route, $id];
    }
    public function editRoute(Request $request, $id){
        $data=$request->all();
        $route = Route::find($id);

        foreach ($data as $key => $value) {
            $bus->{$key} = $value;
        }

        $result=$route->save();

        return [$result,$route];
    }
    public function deleteRoute(Request $request, $Id){
        $route = Route::find($id);

        $result = $route->delete();

        return [$result, $id];
    }
}

