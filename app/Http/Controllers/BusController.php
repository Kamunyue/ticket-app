<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusController extends Controller
{

    public function inputBus(Request $request)
    {   
        $request->validate([
            'total_seats'=>'required|integer|min:6|max:30',
        ]);

        $bus = new Bus; 

        $bus->total_seats = $request->total_seats;
        $bus->bus_operator_id = $request->user()->id;
        $bus->available_seats = $request->total_seats;/** this number needs to change automatically when booking happens */

        $bus->save();

        for ($i = 1; $i <= $bus->total_seats; $i++) {
            $seat = new Seat([
                'bus_id' => $bus->id,
                'seat_number' => "Seat $i",
            ]);
            $seat->save();
        }

        return response()->json(['msg'=>'Bus details saved']);
    }

    public function viewBusDetails(Request $request, $id)
    {
        $bus = Bus::find($id);

        if (empty($bus)) {
            $success = false;
            $response = ['error'=> 'bus not found'];
        }else {
            $success = true;
            $response = ['Bus Details'=> $bus];
        }

        return[
            'success'=> $success,
            'response'=>['msg'=>$response]
            ];
    }

    public function editBusDetails(Request $request, $id)
    {
        $data = $request->all();
        $bus = Bus::find($id);

        foreach ($data as $key => $value) {
            $bus->{$key} = $value;
        }

        $result = $bus->save();

        return ['success'=> $result , "response"=>$bus];
    }

    public function deleteBusDetails(Request $request, $id)
    {
        $bus = Bus::find($id);
        
        if (empty($bus)) {
            $success = false;
            $response = ['error'=> 'bus not found'];
        }else {
            $success = $bus->delete();
            $response = ['message'=> 'bus successfully deleted'];
        }

        return[
            'success'=> $success,
            'response'=>['message'=>$response]
            ];
        
    }

    public function useSchedule(){
        $user_id = auth::id();
        $schedule = BusSchedule :: findOrFail($user_id);
        
    }




    //relationship between bus and bus operator
    // public function busOperator(): HasOne
    // {
    //     return $this->hasOne(OperatorBus::class);
    // }

}