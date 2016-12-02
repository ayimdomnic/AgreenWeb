<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BleSession;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use DateTime;

class BleSessionController extends Controller
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
    	$blesessions = BleSession::where('isSync', 0)
    	->orderBy('startDate', 'ASC')
    	->take(500)
    	->get();

    	return View::make('app.session.index')
    	->with('blesessions', $blesessions);   
    }
}
