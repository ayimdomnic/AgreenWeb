<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
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
     $users = User::all();
     return view('app.event.user')
     ->with('events', $events)
     ->with('users', $users);
   }

   public function showEventsUserForm(Request $request){
     $user = $request->user;
     $daterange =  $request->daterange;
     $dateStart =  $request->dateStart;
     $dateEnd =  $request->dateEnd;

     $events = Event::where('idUser', $user)
     ->get();
     $users = User::all();

     return view('app.event.user')
     ->with('user', $user)
     ->with('daterange', $daterange) 
     ->with('events', $events)
     ->with('users', $users);
   }
 }
