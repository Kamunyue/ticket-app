<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Trip;
use App\Models\Route;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripController extends Controller
{
    public function makeTrip(Request $request){
        $user_id = auth()->id();
        $available_routes = Route::select('arrival_location', 'departure_location')->get();//these need to be looped through and the results returned to the user as a dropdown
        $user_schedules = BusSchedule::where('user_id', $user_id)
                        ->select('departure_time', 'arrival_time')
                        ->get();//these need to be looped through and the results returned to the user as a dropdown
        $user_buses = Bus::where('bus_operator_id', $user_id)
                    ->get();//these need to be looped through and the results returned to the user as a dropdown
        $trip = new Trip;
        $message;

        if ($user_buses && $user_schedules && $available_routes) {
            $trip->bus_id = $request->input('bus');
            $trip->route_id = $request->input('route');
            $trip->schedule_id =$request->input('schedule');

            $trip->save();

            $message = [
                'trip_details'=> $request->all(),
                'routes' => $available_routes,
                'my_buses' => $user_buses,
                'my_schedules' => $user_schedules,
            ];
        }
        elseif (empty($user_buses)) {
            $message = 'You have no available buses';
        }
        elseif (empty($user_schedules)) {
            $message = 'You have no available schedules';
        }
        else {
            $message = 'Invalid input';
        }        

        return response()->json(['message' => $message]);
    }
    public function readTrips(){
           
    }
    // public function makeTrip(){
        
    // }
    //     public function makeTrip(){
        
    // }
}
