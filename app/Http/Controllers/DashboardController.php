<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\osclasses\daController;

class DashboardController extends Controller
{
  /*public function DashView(){
      return View::make('orderdata');
  }*/

  public function index()
  { // This is the function which I want to call from ajax
      //do something awesome with that post data
          return view('dashboard.index');
  }

  public function showPackets()
  { // This is the function which I want to call from ajax
      //do something awesome with that post data
          return view('dashboard.packets');
  }
}
