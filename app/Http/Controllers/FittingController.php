<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FittingController extends Controller
{
               /**
     * Create a new controller instance.
     *
     * @return void
     */
               public function __construct()
               {
               	$this->middleware('auth');
               }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('app.fitting.index');
    }

   public function showFittingsUser()
    {
      return view('app.fitting.user');
    }
    

}
