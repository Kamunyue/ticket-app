<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BusScheduleController extends Controller
{
    public function inputBusSchedule(Request $request)
    {
        $validated_input = $request->validate([
            'departure_time'=> 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
        ]);

        if ($validated_input)
        {
            $schedule = new BusSchedule;

            $schedule->departure_time = $request->departure_time;
            $schedule->arrival_time = $request->arrival_time;
            $schedule->user_id = auth()->id();
            // $schedule->duration = $request->arrival_time->diffInSeconds($request->departure_time);/** check if duration calc works */

            $schedule->save();

            return response()->json(['message'=>'Schedule saved', 'schedule' => $schedule]);
        }

        else {
            return response()->json(['error' => 'invalid input']);
        }

        

    }

    public function viewBusSchedule(){
        $user_id = auth()->id();
        $schedules = BusSchedule :: where('user_id', $user_id)->get();
        $user_info = User :: where('id', $user_id)->get();

        return [$user_info,$schedules];
    }

    public function viewAllSchedules(){
        $schedules = BusSchedules :: all();

        return $schedules;
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
