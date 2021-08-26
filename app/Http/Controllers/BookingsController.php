<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RoomsController;
use App\Models\RoomType;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Balance;
use Carbon\Carbon;

class BookingsController extends Controller
{
    
    public function computeBooking($quantity, $startdate, $enddate, $roomtype){

        $days = Carbon::parse($startdate)->diff($enddate)->days;

        $room_type = RoomType::find($roomtype);

        $collection = collect([]);

        $collection->put('quantity', $quantity);
        $collection->put('room_type_desc', strtoupper($room_type->desc));
        $collection->put('days', $days);
        $collection->put('cost', ($room_type->rate * $days) * $quantity);

        return $collection->toJson();
        

    }

    public function store($email, $amount, $roomtype, $startdate, $enddate, $quantity, $cost){

        

        if(auth()->user()->isAdmin())
            return redirect()->back();        

        $client = auth()->user()->client;
        $room_type = RoomType::find($roomtype);
        $balance = Balance::find($client->balance->id);        

        $ctrlr = new RoomsController;

        $availableRooms = $ctrlr->availableRooms($startdate, $enddate, $roomtype)->take($quantity);

        $datenow = Carbon::now();

        $balance->amount = $cost;
        $balance->save();

        foreach($availableRooms as $room){

            $booking = new Booking;
            $booking->room_id = $room->id;
            $booking->client_id = $client->id;
            $booking->start_date = $startdate;
            $booking->end_date = $enddate;
            $booking->cost = $cost;
            $booking->status = 1;

            $booking->save();

            $booking->booking_id = $datenow->isoFormat('YY') . sprintf('%04d', $booking->id);

            $booking->save();

        }

        $transaction = new Transaction;

        $transaction->client_id = $client->id;
        $transaction->desc = 'booking payment';
        $transaction->prev_bal = $balance->amount;        

        $balance->amount -= $amount;
        $balance->save();

        $transaction->rem_bal = $balance->amount;
        $transaction->amount = $amount;
        
        $transaction->save();  

        $transaction->trans_id = $datenow->isoFormat('YY') . sprintf('%04d', $transaction->id);

        $transaction->save();        


        return redirect('profile')->with('success', 'You have successfully booked at '. Carbon::parse($startdate)->isoFormat('MMM DD, OY') . ' to ' . Carbon::parse($enddate)->isoFormat('MMM DD, OY'));

        


        // return $email . ' => ' . $amount . ' => ' . $roomtype . ' => ' . $startdate . ' => ' . $enddate . ' => ' . $quantity . ' => ' . $cost;


    }

}
