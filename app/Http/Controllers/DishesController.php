<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Dish;

class DishesController extends Controller
{
    
    public function clientView(){

        return view('restaurant');

    }

    public function view(){

        return view('dishes.view');

    }

    public function store(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Dish::where('name', $request->input('name'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a dish named' . $request->input('name'));

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:50|min:2',
            'desc' => 'required|max:255|min:2',
            'price' => 'required|numeric|gte:50|lte:10000',                        
            'image' => 'required|image|max:10000',                        
        ]);
    
        if ($validator->fails())
            return redirect('/dishes')->withErrors($validator)->withInput();                      
        
        $filenameWithExt = $request->file('image')->getClientOriginalName();        
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);        
        $extension = $request->file('image')->getClientOriginalExtension();        
        $fileNameToStore = $filename.'_'.time().'.'.$extension;        
        $path = $request->file('image')->storeAs('public/images/dishes/', $fileNameToStore);   
        
        
        $dish = new Dish;

        $dish->name = $request->input('name');
        $dish->desc = $request->input('desc');
        $dish->image = $fileNameToStore;            
        $dish->price = $request->input('price');

        $dish->save();

        return redirect('/dishes')->with('success', 'Dish successfully added!');  
        
    }

    public function update(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        if(Dish::where('name', $request->input('name'))->where('id', '!=' , $request->input('id'))->exists())
            return redirect()->back()->with('warning', 'Submission Failed. There\'s already a dish named' . $request->input('name'));

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:50|min:2',
            'desc' => 'required|max:255|min:2',
            'price' => 'required|numeric|gte:50|lte:10000',                        
        ]);

        if ($validator->fails())
            return redirect('/dishes')->withErrors($validator)->withInput();   
            
        if($request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'image|max:10000',  
            ]);

        if ($validator->fails())
            return redirect('/dishes')->withErrors($validator)->withInput();                         

            $filenameWithExt = $request->file('image')->getClientOriginalName();        
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);        
            $extension = $request->file('image')->getClientOriginalExtension();        
            $fileNameToStore = $filename.'_'.time().'.'.$extension;        
            $path = $request->file('image')->storeAs('public/images/dishes/', $fileNameToStore);            
        } 

        $dish = Dish::find($request->input('id'));

        $dish->name = $request->input('name');
        $dish->desc = $request->input('desc');

        if($request->hasFile('image')){

            if(!empty($dish->image))
                Storage::disk('public')->delete('images/dishes/' . $dish->image);

                $dish->image = $fileNameToStore;            

        }

        $dish->price = $request->input('price');

        $dish->save();

        return redirect('/dishes')->with('info', 'Dish successfully updated!');  

    }

    public function delete(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $dish = Dish::find($request->input('id'));
        $oldname = ucfirst($dish->name);
        Storage::disk('public')->delete('images/dishes/' . $dish->image);

        $dish->delete();

        return redirect('/dishes')->with('info', 'Dish ' . $oldname . ' successfully deleted!');  

    }

    public function avail(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();

        $dish = Dishes::find($request->input('id'));

        $dish->status = 0;
        $dish->save();
        
        return redirect('/dishes')->with('info', 'Dish set to Available!');  
        
    }

    public function unavail(Request $request){


        if($request->method() != 'POST')
            return redirect()->back();

        $dish = Dish::find($request->input('id'));

        $dish->status = 1;
        $dish->save();
        
        return redirect('/dishes')->with('info', 'Dish set to Unvailable!');  

    }

}
