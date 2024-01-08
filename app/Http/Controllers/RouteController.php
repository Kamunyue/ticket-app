<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function inputRoute(Request $request)
    {
        $route = Route::create([
            'departure_location' => $request->departure_location ,
            'arrival_location' => $request->arrival_location,
            'fare' => $request->fare,
        ]);

        


    }
}

