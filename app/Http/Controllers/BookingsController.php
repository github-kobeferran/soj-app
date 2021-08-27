<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RoomsController;
use App\Models\RoomType;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Balance;
use App\Models\Client;
use App\Models\Room;
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

        $balance->amount+= $cost;
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
        $transaction->desc = 'Booking #' . $booking->booking_id . ' Payment';
        $transaction->prev_bal = $balance->amount;        

        $balance->amount -= $amount;
        $balance->save();

        $transaction->rem_bal = $balance->amount;
        $transaction->amount = $amount;
        
        $transaction->save();  

        $transaction->trans_id = $datenow->isoFormat('YY') . sprintf('%04d', $transaction->id);

        $transaction->save();        


        return redirect('profile')->with('success', 'You have successfully booked at '. Carbon::parse($startdate)->isoFormat('MMM DD, OY') . ' to ' . Carbon::parse($enddate)->isoFormat('MMM DD, OY'));                

    }

    public function checkIn(Request $request){        

        if($request->method() != 'POST')
            return redirect()->back();
        
        $booking = Booking::find($request->input('id'));
        $booking->status = 2;     

        $room = Room::find($booking->room_id);
        $room->status = 1;

        $client = Client::find($booking->client->id);
        $client->checked_in = 1;
        $client->last_checked_in = Carbon::now();

        $room->save(); 
        $booking->save(); 
        $client->save();
        
        return redirect('/admin')->with('info', 'Client ' . $booking->client->user->name . ' is Checked in');

    }

    public function done(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();
        
        $booking = Booking::find($request->input('id'));
        $booking->status = 3;   

        $room = Room::find($booking->room_id);
        $room->status = 0;

        $client = Client::find($booking->client->id);
        $client->checked_in = 0;

        $room->save(); 
        $booking->save(); 
        $client->save();
        
        return redirect('/admin')->with('info', 'Client ' . $booking->client->user->name . ' is Checked out');

    }

    public function cancel(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $booking = Booking::find($request->input('id'));
        
        $booking->status = 4;
        $booking->save();

        $transaction = new Transaction;

        $transaction->client_id = auth()->user()->client->id;
        $transaction->desc = 'Cancellation of BOOKING #' . $booking->booking_id;
        $transaction->prev_bal = auth()->user()->client->balance->amount;
        $transaction->rem_bal = auth()->user()->client->balance->amount;
        
        $transaction->trans_id = Carbon::now()->isoFormat('YY') . sprintf('%04d', $transaction->id);

        $transaction->save();  

        return redirect('/profile')->with('info', "BOOKING #" . $booking->booking_id ." has been cancelled.");


    }

}
