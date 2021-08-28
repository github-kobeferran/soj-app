<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Table;
use Carbon\Carbon;

class ReservationsController extends Controller
{
    
    public function store(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $reservation = new Reservation;
        $reservation->client_id = auth()->user()->client->id;

        $table = Table::where('status', 0)->get()->last();
        $table->status = 1;
        
        $reservation->save();
        $table->save();

        $transaction = new Transaction;

        $transaction->client_id = auth()->user()->client->id;
        $transaction->desc = 'Reserved a table on the night of ' . Carbon::now()->isoFormat('DD MMM, OY');
        $transaction->prev_bal = auth()->user()->client->balance->amount;
        $transaction->rem_bal = auth()->user()->client->balance->amount;
        $transaction->save();

        $transaction->trans_id = Carbon::now()->isoFormat('YY') . sprintf('%04d', $transaction->id);

        $transaction->save();    

        return redirect('/profile')->with('success', 'Reservation successfully submitted');

    }

}
