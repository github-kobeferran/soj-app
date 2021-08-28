<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Table;

class TablesController extends Controller
{
    
    public function store(Request $request){

        if($request->method() != 'POST')
            return redirect()->back();
        
        $table = new Table;
        $table->save();

        return redirect('/admin')->with('success', 'Added a table');

    }

    public function delete(Request $request){        
        
        if($request->method() != 'POST')
            return redirect()->back();        

        if(is_null(Table::where('status', 0)->get()->last()))
            return redirect('/admin')->with('warning', 'Deletion failed. Must have a table for reservations');
        else{
            $table =  Table::where('status', 0)->get()->last();
            $table->delete();
            return redirect('/admin')->with('success', 'A table is removed');
        }
        
    }

    public function reserve(Request $request){
        
    }

}
