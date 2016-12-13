<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use App\Parcel;
use App\ParcelGps;
use App\PointLocation;
use App\ProcessedEvents;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use DateTime;

class EventController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $this->middleware('auth');
     return view('app.event.index');
   }

   public function showEventsUser()
   {
     $this->middleware('auth');

     $events = Event::take(100)
     ->get();
     $users = User::all();
     return view('app.event.user')
     ->with('events', $events)
     ->with('users', $users);
   }

   public function showEventsUserForm(Request $request){

     $this->middleware('auth');
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
     $this->middleware('auth');

     $pointLocation = new PointLocation();
     $events = Event::take(1000)
     ->orderBy('dateGps', 'ASC')
     ->get();


     foreach ($events as $key => $value) {

      $latLonEvent = $value->lat . ",".$value->lon;
      $event = $value;

      $parcels = Parcel::orderByRaw('lat - '. $value->lat . '', 'ASC')
      ->take(20)
      ->get();

      foreach ($parcels as $key => $value) {

        $isPointInside = 0;

        $parcelsGps = ParcelGps::where('idparcel', $value->id)
        ->orderBy('number', 'ASC')
        ->get();

        $polygon = array();
        foreach ($parcelsGps as $key => $value) {
          $latlng = "" . $value->lat . ", ". $value->long . "";
          $idparcelEvent = $value->idparcel;
          array_push($polygon, $latlng);
        }

        $isPointInside = $pointLocation->pointInPolygon($latLonEvent, $polygon, $event, $idparcelEvent);

        if ($isPointInside == 1) {

          $event = Event::find($event->id);
          $event->isSync = 1;
          $event->isInside = 1;
          $event->idParcelle = $idparcelEvent;
          $event->save();

          $eventprocessed = new ProcessedEvents;
          $eventprocessed->idApp =  $event->idApp;
          $eventprocessed->idUser =  $event->idUser;
          $eventprocessed->name =  $event->name;
          $eventprocessed->lon =  $event->lon;
          $eventprocessed->lat =  $event->lat;
          $eventprocessed->dateGps =  $event->dateGps;
          $eventprocessed->timeDate =  $event->timeDate;
          $eventprocessed->isInside =  $event->isInside;
          $eventprocessed->idParcelle =  $event->idParcelle;
          $eventprocessed->altitude =  $event->altitude;
          $eventprocessed->isSync =  $event->isSync;
          $eventprocessed->save();
          break;
        }
        if ($isPointInside == 0) {
          $event = Event::find($event->id);
          $event->isSync = 1;
          $event->isInside = 0;
          $event->idParcelle = 0;
          $event->save();
        }
      }
    }
  }

  public function receiveEventsRaspberry(Request $request){
    $data = json_decode(file_get_contents('php://input'), true);

    $fix_date = $result["3"];
    $fix_time = $result["4"];
    $fix_date_day = substr($fix_date, -6, 2);
    $fix_date_month = substr($fix_date, -4, 2);
    $fix_date_year = substr($fix_date, -2, 2);
    $dateTimeGPS = "20" . $fix_date_year . "-" . $fix_date_month .  "-" . $fix_date_day;
    $fix_time_hours = substr($fix_time, -10, 2);
    $fix_time_minutes = substr($fix_time, -8, 2);
    $fix_time_seconds = substr($fix_time, -6, 2);
    $heureGps = "" . $fix_time_hours . ":" . $fix_time_minutes .  ":" . $fix_time_seconds;
    $dateGPS = $dateTimeGPS . " " . $heureGps;
    
    foreach ($data as $value) {
      $event = new Event;
      $event->idApp = $result["0"];
      $event->idUser = $result["7"];
      $event->name = $result["6"];
      $event->lon = $result["2"];
      $event->lat = $result["1"];
      $event->dateGps = $dateGPS;
      $event->isInside = 0;
      $event->idParcelle = 0;
      $event->altitude = 0;
      $event->isSync = 0;
      $event->save();
    }
  }
}