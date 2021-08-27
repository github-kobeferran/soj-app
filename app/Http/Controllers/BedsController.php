<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bed;
use App\Models\RoomType;
use App\Models\RoomBeds;

class BedsController extends Controller
{

    public function store(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Bed::where('desc', $request->input('desc'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a bed called ' . ucfirst($request->input('desc')));

        $validator = Validator::make($request->all(), [
            'desc' => 'required|regex:/^[a-zA-Z0-9\s]+$/|max:50|min:3', 
        ]);
    
        if($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();  

        $bed = new Bed;

        $bed->desc = $request->input('desc');
        $bed->persons_fit = $request->input('persons_fit');
        $bed->save();

        return redirect('/rooms')->with('success', 'Bed "'. ucfirst($bed->desc) .'" successfully added!');  

    }

    public function update(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Bed::where('desc', $request->input('desc'))->where('id', '!=', $id)->exists())
            return redirect()->back()->with('warning', 'Update Failed. There\'s already a bed called ' . ucfirst($request->input('desc')));

        $validator = Validator::make($request->all(), [
            'desc' => 'required|regex:/^[a-zA-Z0-9\s]+$/|max:50|min:3', 
        ]);
    
        if($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput(); 

        $bed = Bed::find($request->input('id'));

        $oldname = $bed->desc;
        $bed->desc = $request->input('desc');
        $bed->persons_fit = $request->input('persons_fit');
        $bed->save();

        return redirect('/rooms')->with('info', 'Bed "'. ucfirst($oldname) .'" successfully updated!');  

    }

    public function delete(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $bed = Bed::find($request->input('id'));

        if(RoomBeds::where('bed_id', $bed->id)->exists())
            return redirect()->back()->with('warning', 'Deletion Failed. A '. ucfirst($bed->desc) . ' bed currently belongs to a Room Type ');

        DB::table('room_beds')->where('bed_id', $bed->id)->delete();

        
        $oldname = $bed->desc;
        $bed->delete();

        return redirect('/rooms')->with('info', 'Bed "'. ucfirst($oldname) .'" successfully deleted');  
        
    }

}
