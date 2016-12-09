<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use App\Parcel;
use App\ParcelGps;
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
       ->where('idUser', $user)
       ->whereBetween('dateGps', [$dateStart, $dateEnd])
       ->get();
       $users = User::all();

       return view('app.event.user')
       ->with('user', $user)
       ->with('events', $events)
       ->with('users', $users);
   }

   public function scanIsInsideParcel(){
     $events = Event::take(1000)
     ->orderBy('dateGps', 'ASC')
     ->get();

     foreach ($events as $key => $value) {
        $parcels = Parcel::orderBy('lat', '-', $value->lat, 'ASC')
         ->take(20)
         ->get();
     }

     foreach ($parcels as $key => $value) {
         $parcelsGps = ParcelGps::
     }
 }
}
