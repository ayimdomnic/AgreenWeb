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
      $users = User::all();

      return View::make('app.fitting.user')
      ->with('users', $users)   
      ->with('fittings', $fittings);   

      // get all the parcels
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
      if (!empty($user)){
        $fittings = Fitting::where('isSync', 0)
        ->where('idUser', $user->idUser)
        ->orderBy('timesFitting', 'asc')
        ->take(1000)
        ->get();
      }else{
        $fittings = null;
      }
      return View::make('app.fitting.user')
      ->with('user', $user)
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

    if (!empty($row)){
      $fittings = Fitting::where('isSync', 0)
      ->where('idUser', $row->idUser)
      ->orderBy('timesFitting', 'asc')
      ->take(1000)
      ->get();
    }

    if (!empty($fittings) && isset($fittings)){
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

  public function receiveFittingsRaspberry(Request $request){
    $data = json_decode(file_get_contents('php://input'), true);

    foreach ($data as $result) {
      $fitting = new Fitting;
      $fitting->Mac = $result["1"];
      $fitting->idUser = $result["2"];
      $fitting->type = 1
      $fitting->timesFitting = $result["3"];
      $fitting->isSync = 0;
      $fitting->save();
    }

  }
}
