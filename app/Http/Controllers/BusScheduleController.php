<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BusScheduleController extends Controller
{
    public function inputBusSchedule(Request $request)
    {
        $validated_input = $request->validate([
            'bus_id' => 'unique:bus_schedules',
            'route_id',
            'departure_time',
            'arrival_time',
            'date'
        ]);

        if ($validated_input)
        {
            $schedule = new BusSchedule;

            $schedule->bus_id = $request->bus_id;
            $schedule->route_id = $request->route_id;
            $schedule->departure_time = $request->departure_time;
            $schedule->arrival_time = $request->arrival_time;

            $schedule->save();

            return response()->json(['message'=>'Schedule saved']);
        }

        else {
            return response()->json(['error' => 'invalid input']);
        }

        

    }

    public function editBusSchedule(Request $request, $id)
    {
        $data = $request->all();
        $bus = BusSchedule::find($id);

        foreach ($data as $key => $value) {
            $schedule->{$key} = $value;
        }

        $result = $schedule->save();

        return ['success'=> $result , "response"=>$bus];
    }

    public function deleteBusSchedule()
    {
        $schedule = BusSchedule::find($id);

        if (empty($schedule)){
            $success = false;
            $response = [
                'error' => 'schedule not found',
                'status_code' => 403,
            ];
        }else{
            $success = $schedule->delete();
            $response = [
                'message' => 'schedule deleted successful',
            ];
        }

        return[
            'success'=> $success,
            'response'=>['message'=>$response]
            ];
    }
}
