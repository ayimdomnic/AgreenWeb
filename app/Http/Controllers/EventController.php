<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use App\Parcel;
use App\ParcelGps;
use App\PointLocation;
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

    $pointLocation = new PointLocation();
    $events = Event::take(2000)
    ->orderBy('dateGps', 'ASC')
    ->get();

    foreach ($events as $key => $value) {

        $latLonEvent = $value->lat . ",".$value->lon;
        $event = $value;
        $parcels = Parcel::orderBy('lat', '-', $value->lat, 'ASC')
        ->take(20)
        ->get();

        foreach ($parcels as $key => $value) {
            $parcelsGps = ParcelGps::where('idparcel', $value->id)
            ->orderBy('number', 'ASC')
            ->get();

            $polygon = array();
            foreach ($parcelsGps as $key => $value) {
                $latlng = "" . $value->lat . ", ". $value->long . "";
                $idparcelEvent = $value->idparcel;
                array_push($polygon, $latlng);
            }

            // echo $latLonEvent;
            // var_dump($polygon);
            // echo $event;
            // echo $idparcelEvent;
            // echo "</br>";

            $isPointInside = $pointLocation->pointInPolygon($latLonEvent, $polygon, $event, $idparcelEvent);
            if ($isPointInside == 1) {
                echo $isPointInside;
                echo "</br>";
            }
        }
    }

}
}
