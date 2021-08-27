<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Client;
use App\Models\Balance;
use App\Models\Transaction;
use Carbon\Carbon;

class ClientsController extends Controller
{

    public function view(){

        return view('client.view');

    }
    
    public function show($email = null){

        $user = auth()->user();

        if(!is_null($email)){

            if(User::where('email', $email)->doesntExist())
                return redirect()->back();

            $user_client = User::where('email', $email)->first();
            

            if(!$user->isAdmin())
                if($user->email != $client->email)
                    return redirect()->back();            
            
            return view('client.profile')->with('user_client', $user_client);
            
        } else {

            if($user->isAdmin())
                return redirect('/admin');

            if(User::where('email', $user->email)->doesntExist())
                return redirect()->back();

            $user_client = User::where('email', $user->email)->first();
                
   
            return view('client.profile')->with('user_client', $user_client);

        }        
    }

    public function update(Request $request){

        $before_date = Carbon::now()->subYears(8); 
        $after_date = new Carbon('1941-01-01'); 

        if($request->method() != 'POST')
            return redirect()->back();

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',                                                          
            'dob' => 'date|before:'. $before_date->toDateString() . '|after:' . $after_date,            
            'contact' => 'digits_between:8,15',            
            'address' => 'max:100',            
        ]);
    
        if ($validator->fails())
            return redirect('/profile')->withErrors($validator)->withInput();   
 

        if($request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'image|max:10000',  
            ]);

            if ($validator->fails())
                return redirect('/profile')->withErrors($validator)->withInput();                         

            $filenameWithExt = $request->file('image')->getClientOriginalName();        
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);        
            $extension = $request->file('image')->getClientOriginalExtension();        
            $fileNameToStore = $filename.'_'.time().'.'.$extension;        
            $path = $request->file('image')->storeAs('public/images/client/', $fileNameToStore);            
        }                           
                
        $user = auth()->user();
        $client = Client::find($user->client->id);

        $user->name = $request->input('name');                

        if($request->hasFile('image')){

            if(!empty($client->image))
                Storage::disk('public')->delete('images/client/' . $client->image);

            $client->image = $fileNameToStore;            

        }
        
        $client->dob = $request->input('dob');
        $client->sex = $request->input('sex');
        $client->nationality = $request->input('nationality');
        $client->contact = $request->input('contact');
        $client->address = $request->input('address');

        $user->save();
        $client->save();

        return redirect('/profile')->with('success', 'Personal Information is Updated');

        
    }

    public function payBalance(){

        $balance = Balance::find(auth()->user()->client->balance->id);  
        
        $prev_bal = $balance->amount;

        $balance->amount = 0;

        $balance->save();

        $transaction = new Transaction;
        $transaction->client_id = auth()->user()->client->id;
        $transaction->desc = 'Balance Payment';
        $transaction->prev_bal = $prev_bal;
        $transaction->rem_bal = 0;
        $transaction->amount = $prev_bal;
        $transaction->save();        

        $transaction->trans_id = Carbon::now()->isoFormat('YY') . sprintf('%04d', $transaction->id);

        $transaction->save();  

        return redirect('/profile')->with('info', 'Balance paid. Thank you');

    }

    

}
