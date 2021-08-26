<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class RoomsController extends Controller
{
 
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
