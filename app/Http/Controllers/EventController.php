<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use DateTime;

class EventController extends Controller
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
    	return view('app.event.index');
    }

    public function showEventsUser()
    {
       $events = Event::take(100)
       ->get();
       return view('app.event.user')
       ->with('events', $events);
   }
}
