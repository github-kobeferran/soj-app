<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Feature;
use App\Models\RoomFeatures;
use App\Models\Bed;
use App\Models\RoomBeds;
use Carbon\Carbon;

class RoomTypesController extends Controller
{
    
    public function clientView(){

        return view('hotel');

    }

    public function store(Request $request){                  
        
        if($request->method() != 'POST')
            return redirect()->back();

        if(RoomType::where('desc', $request->input('desc'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a room type named ' . ucfirst($request->input('desc')));

        $beds = $request->input('beds');

        if(count($beds) > 7)
            return redirect()->back()->with('warning', 'Submission Failed. Beds are max counts are 7');

        $validator = Validator::make($request->all(), [
            'desc' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'rate' => 'required|numeric|gte:300|lte:20000',                        
        ]);
    
        if ($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();          

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
            $path = $request->file('image')->storeAs('public/images/room_types/', $fileNameToStore);            
        } 
        
        $room_type = new RoomType;

        $room_type->desc = $request->input('desc');
        $room_type->rate = $request->input('rate');                    

        if($request->hasFile('image')){

            if(!empty($room_type->images))
                Storage::disk('public')->delete('images/room_types/' . $room_type->images);

                $room_type->images = $fileNameToStore;            

        }

        $room_type->save();        
                    
        $bed_collect = collect();

        foreach($beds as $id){

            $bed_collect->push(Bed::find($id));

        }  

        foreach($bed_collect as $bed){
            
            if(RoomBeds::where('room_type_id', $room_type->id)->where('bed_id', $bed->id)->doesntExist()){

                $room_bed = new RoomBeds;            
                $room_bed->room_type_id = $room_type->id;
                $room_bed->bed_id = $bed->id;

                $room_bed->save();
            }

        }

        if($request->has('features')){
            $features = $request->input('features');
                    
            $collect = collect();

            foreach($features as $id){

                $collect->push(Feature::find($id));

            }  

            foreach($collect as $feature){
                
                if(RoomFeatures::where('room_type_id', $room_type->id)->where('feature_id', $feature->id)->doesntExist()){
                    $room_feature = new RoomFeatures;            
                    $room_feature->room_type_id = $room_type->id;
                    $room_feature->feature_id = $feature->id;

                    $room_feature->save();
                }

            }
        }

        return redirect('/rooms')->with('success', 'Room Type successfully added!');  

    }

    public function update(Request $request){        

        if($request->method() != 'POST')
            return redirect()->back();

        if(RoomType::where('desc', $request->input('desc'))->where('id', '!=', $request->input('id'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a room type named ' . ucfirst($request->input('desc')));

        $beds = $request->input('beds');

        if(count($beds) > 7)
            return redirect()->back()->with('warning', 'Submission Failed. Beds are max counts are 7');

        $validator = Validator::make($request->all(), [
            'desc' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'rate' => 'required|numeric|gte:300|lte:20000',                        
        ]);
    
        if ($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();  

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
            $path = $request->file('image')->storeAs('public/images/room_types/', $fileNameToStore);            
        } 

        $room_type = RoomType::find($request->input('id'));

        $room_type->desc = $request->input('desc');
        $room_type->rate = $request->input('rate');

        if($request->hasFile('image')){

            if(!empty($room_type->images))
                Storage::disk('public')->delete('images/room_types/' . $room_type->images);

                $room_type->images = $fileNameToStore;            

        }

        $room_type->save();

        $bed_collect = collect();

        foreach($beds as $id){

            $bed_collect->push(Bed::find($id));

        }  

        foreach($bed_collect as $bed){
            
            if(RoomBeds::where('room_type_id', $room_type->id)->where('bed_id', $bed->id)->doesntExist()){

                $room_bed = new RoomBeds;            
                $room_bed->room_type_id = $room_type->id;
                $room_bed->bed_id = $bed->id;

                $room_bed->save();
            }

        }

        if(!empty($request->input('features'))){

            DB::table('room_features')->where('room_type_id', $room_type->id)->delete();

            $features = $request->input('features');                
    
            $collect = collect();
    
            foreach($features as $id){
    
                $collect->push(Feature::find($id));
    
            }  
    
            foreach($collect as $feature){
                            
                $room_feature = new RoomFeatures;            
                $room_feature->room_type_id = $room_type->id;
                $room_feature->feature_id = $feature->id;
                $room_feature->save();
    
            }

        } else {
            DB::table('room_features')->where('room_type_id', $room_type->id)->delete();
        }

       

        return redirect('/rooms')->with('info', 'Room Type successfully updated');

    }

    public function delete(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $room_type = RoomType::find($request->input('id'));

        $oldname = $room_type->desc;

        $pendingBookings = Booking::where(function($query){
                                        $query->where('status', 1)                                 
                                              ->orWhere('status', 2);
                                    })->get();                                                   
        
        foreach($pendingBookings as $pending){

            if(Room::find($pending->room_id)->room_type_id == $request->input('id'))
                return redirect()->back()->with('warning', 'Deletion Failed. There\'s pending/checked in room registered to ' . ucfirst($oldname) );                

        }        

      
        Storage::disk('public')->delete('images/room_types/' . $room_type->images);
        DB::table('room_features')->where('room_type_id', $room_type->id)->delete();
        $room_type->delete();
        

        return redirect('/rooms')->with('info', 'Room Type "'. ucfirst($oldname) .'" deleted');

    }

}
