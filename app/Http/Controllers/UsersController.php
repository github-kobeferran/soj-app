<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
  
    public function adminView(){
        return view('admin.dashboard');
    }

}
