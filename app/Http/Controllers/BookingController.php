<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function makeBooking(Request $request)
    {
        $bus = Bus::find($request->bus_id);

        // Check if there are available seats
        if ($bus->available_seats > 0) {
            $bus->booked_seats++;
            $bus->available_seats--;
            $bus->save();

            // Create a new booking record in the database
            $booking = Booking::create([
                'user_id' => auth()->user()->id,
                'schedule_id' => $bus->id,
                'payement_status' => $booking->defaultStatusFun(),
                'seat_numbers'=> [$bus->booked_seats],
                // Other booking details
            ]);

            // Return a success response
        }
    }
    public function cancelBooking(Request $request)
    {
        $bus = Bus::find($request->bus_id);

        // Check if the user has a booking to cancel
        if ($bus->booked_seats > 0) {
            $bus->booked_seats--;
            $bus->available_seats++;
            $bus->save();

            // Delete the booking record from the database
            Booking::where('user_id', auth()->user()->id)
                ->where('bus_id', $bus->id)
                ->delete();
        }
    }
    
}
