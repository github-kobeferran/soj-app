<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class RoomsController extends Controller
{

    public function view(){

        return view('rooms.view');

    }  

    public function store(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Room::where('name', $request->input('name'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a room named ' . ucfirst($request->input('name')));

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|max:25',            
        ]);
    
        if ($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();

        $room = new Room;

        $room->name = $request->input('name');
        $room->room_type_id = $request->input('room_type_id');
        
        $room->save();

        return redirect('/rooms')->with('success', 'Room successfully added!');  

    }

    public function update(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Room::where('name', $request->input('name'))->where('id', '!=', $request->input('id'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a room named ' . ucfirst($request->input('name')));

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|max:25',                      
        ]);
    
        if ($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();

        $room = Room::find($request->input('id'));

        $room->name = $request->input('name');
        $room->room_type_id = $request->input('room_type_id');
        
        $room->save();

        return redirect('/rooms')->with('info', 'Room successfully Updated!');  


    }

    public function delete(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $room = Room::find($request->input('id'));

        if(Booking::where('room_id', $room->id)
                  ->where(function($query){
                        $query->where('status', 1)                                 
                              ->orWhere('status', 2);
                    })->exists()  
        )
        return redirect()->back()->with('warning', 'Deletion Failed. Room is pending or occupied');

        $oldname = $room->name;
        $room->delete();
        return redirect('/rooms')->with('info', 'Room  "'. ucfirst($oldname) .'" deleted');

    }
    
 
    public function availableRooms($startdate, $enddate, $roomtype){      
        
        if($startdate > $enddate)
            return;

        $notAvailableRooms = Booking::where(function($query) use($startdate, $enddate){
                                    $query->whereBetween('start_date',[$startdate, $enddate])                                 
                                          ->orWhereBetween('end_date',[$startdate, $enddate]);
                                })                                
                                ->where(function($query) {
                                    $query->where('status', 1) // pending or reserved
                                          ->orWhere('status', 2); // currently checked in
                                })
                                ->get();      

        if($notAvailableRooms->isEmpty()){
            
            $rooms = Room::where('room_type_id', $roomtype)->where('status', 0)->get();                        

            foreach($rooms as $room){
                $room->room_type;
            }

            return $rooms;

        } else {
              

            $collection = Room::where('room_type_id', $roomtype)->where('status', 0);

            

            foreach($notAvailableRooms as $notAvail){

                $collection->where('id', '!=', $notAvail->room_id);
                                
            }
            
            $availableRooms = $collection->get();                                              

            foreach($availableRooms as $room){                
                $room->room_type;
            }

            return $availableRooms;
            
        }
        
                                                    

    }  

}
