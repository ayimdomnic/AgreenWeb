<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fitting;
use App\BleSession;
use App\Parcel;
use App\User;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use DateTime;

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
      $fittings = Fitting::where('isSync', 0)
      ->orderBy('timesFitting', 'ASC')
      ->take(1000)
      ->get();
      return View::make('app.fitting.user')
      ->with('fittings', $fittings);   

      //         // get all the parcels
      // $fittings = Fitting::all();

      //   // load the view and pass the parcels
      // return View::make('app.fitting.index')
      // ->with('fittings', $fittings);   

      // return view('app.fitting.index');
    }

    // $fittings = Fitting::all();
    // return View::make('app.fitting.user')
    // ->with('fittings', $fittings);   

    public function showFittingsUser()
    {
      // change to asc
      $user = Fitting::where('isSync', 0)
      ->orderBy('timesFitting', 'desc')
      ->first();

      $users = User::all();

      $fittings = Fitting::where('isSync', 0)
      ->where('idUser', $user->idUser)
      ->orderBy('timesFitting', 'asc')
      ->take(1000)
      ->get();

      return View::make('app.fitting.user')
      ->with('fittings', $fittings)
      ->with('users', $users);   
    }

    public function showFittingsUserForm(Request $request){
     $user = $request->user;
     $daterange =  $request->daterange;
     $dateStart =  $request->dateStart;
     $dateEnd =  $request->dateEnd;

     $fittings = Fitting::where('isSync', 0)
     ->where('idUser', $user)
     ->whereBetween('timesFitting', [$dateStart, $dateEnd])
     ->get();
     $users = User::all();

     return view('app.fitting.user')
     ->with('user', $user)
     ->with('fittings', $fittings)
     ->with('users', $users);
   }

   public function generateSessions(){
    $startdate = 1;
    $endDate = "00000-00-00 00:00:00";
    $timesFitting = "00000-00-00 00:00:00";

    $row = Fitting::where('isSync', 0)
    ->orderBy('timesFitting', 'asc')
    ->first();

    $fittings = Fitting::where('isSync', 0)
    ->where('idUser', $row->idUser)
    ->orderBy('timesFitting', 'asc')
    ->take(1000)
    ->get();

    if (isset($fittings)){
      foreach ($fittings as $fit) {
        if ($startdate == 1) {
          $startdate =  $fit->timesFitting;
          $timesFitting = $fit->timesFitting;
        }

        $timesFittingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $timesFitting);
        $currentFitDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $fit->timesFitting);
        $diff = $currentFitDateTime->diff($timesFittingDateTime); 

        if ($diff->i > 5) {
          $endDate = $timesFitting; 

          $blesession = new BleSession;
          $blesession->idUser = $row->idUser;
          $blesession->mac = $row->Mac;
          $blesession->startDate = $startdate;
          $blesession->endDate = $endDate;
          $blesession->isSync = 0;
          $blesession->save();

          $timesFitting = $fit->timesFitting;
          $startdate = $fit->timesFitting;
        }else{
          $timesFitting = $fit->timesFitting;
        }
        $fitting = Fitting::find($fit->id);
        $fitting->isSync = 1;
        $fitting->save();
      }
    }
    return View::make('app.fitting.session')
    ->with('message', "Sessions générées");   
  }
}
