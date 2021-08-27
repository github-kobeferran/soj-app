<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Feature;
use App\Models\RoomType;

class FeaturesController extends Controller
{

    public function store(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Feature::where('desc', $request->input('desc'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a feature called ' . ucfirst($request->input('desc')));

        $validator = Validator::make($request->all(), [
            'desc' => 'required|regex:/^[a-zA-Z0-9\s]+$/|max:50|min:3', 
        ]);
    
        if ($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();  
        
        $feature = new Feature;

        $feature->desc = $request->input('desc');
        $feature->standard = $request->input('standard');

        $feature->save();

        return redirect('/rooms')->with('success', 'Feature "'. ucfirst($feature->desc) .'" successfully added!');  
        
    }

    public function update(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Feature::where('desc', $request->input('desc'))->where('id', '!=', $request->input('id'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a feature called ' . ucfirst($request->input('desc')));

        $validator = Validator::make($request->all(), [
            'desc' => 'required|regex:/^[a-zA-Z0-9\s]+$/|max:50|min:3', 
        ]);
    
        if ($validator->fails())
            return redirect('/rooms')->withErrors($validator)->withInput();  
        
        $feature = Feature::find($request->input('id'));
        
        $oldname = $feature->desc; 
        $feature->desc = $request->input('desc');
        $feature->standard = $request->input('standard');

        $feature->save();

        return redirect('/rooms')->with('info', 'Feature "'. ucfirst($oldname) .'" successfully updated!');  

    }

    public function delete(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $feature = Feature::find($request->input('id'));

        DB::table('room_features')->where('feature_id', $feature->id)->delete();

        $oldname = $feature->desc;
        $feature->delete();
        return redirect('/rooms')->with('info', 'Feature "'. ucfirst($oldname) .'" successfully deleted');

    }

}
