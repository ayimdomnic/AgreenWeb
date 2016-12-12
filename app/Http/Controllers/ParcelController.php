<?php

namespace App\Http\Controllers;

use App\Parcel;
use App\ParcelGps;
use App\User;
use App\Event;
use View;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
 public function __construct()
 {
    $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get all the parcels
    	$parcels = Parcel::all();

        // load the view and pass the parcels
    	return View::make('app.parcel.index')
    	->with('parcels', $parcels);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('app.parcel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name'       => 'required',
            );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('parcel/create')
            ->withErrors($validator);
        } else {
            // store
            $parcel = new Parcel;
            $parcel->name =  $request->name;
            $parcel->type =  $request->type;
            $parcel->desc =  $request->desc;
            $parcel->area =  $request->area;
            $parcel->statut =  $request->statut;
            $parcel->save();

            // redirect
            Session::flash('message', 'Successfully created parcel!');
            return Redirect::to('parcel');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
         // get the parcel
        $parcel = Parcel::find($id);
        // show the view and pass the parcel to it
        return View::make('app.parcel.show')
        ->with('parcel', $parcel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $parcel = Parcel::find($id);
        // show the edit form and pass the parcel
        return View::make('app.parcel.edit')
        ->with('parcel', $parcel);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required'
            );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('parcel/' . $id . '/edit')
            ->withErrors($validator);
        } else {
            // store
            $parcel = Parcel::find($id);
            $parcel->name = $request->name;
            $parcel->type = $request->type;
            $parcel->desc = $request->desc;
            $parcel->area = $request->area;
            $parcel->statut = $request->statut;
            $parcel->desc = $request->desc;
            $parcel->save();

            // redirect
            Session::flash('message', 'Successfully updated parcel!');
            return Redirect::to('parcel');
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
       $parcel = Parcel::find($id);
       $parcel->delete();

        // redirect
       Session::flash('message', 'Successfully deleted the parcel!');
       return Redirect::to('parcel');
   }

   public function showParcels(){
    $parcels = Parcel::all();

    $parcelsGpsArray = [];
    foreach ($parcels as $key => $value) {
        $parcelsGps = ParcelGps::where('idparcel', $value->id)
        ->orderBy('number')
        ->select('lat', 'long')
        ->get();    
        array_push($parcelsGpsArray , $parcelsGps);
    }
        // load the view and pass the parcels
    return View::make('app.parcel.show')
    ->with('parcels', $parcelsGpsArray);   
}


public function showParcelsEvents(){

    $events = Event::take(100)
    ->get();
    $users = User::all();

    $parcels = Parcel::all();

    $parcelsGpsArray = [];
    foreach ($parcels as $key => $value) {
        $parcelsGps = ParcelGps::where('idparcel', $value->id)
        ->orderBy('number')
        ->select('lat', 'long')
        ->get();    
        array_push($parcelsGpsArray , $parcelsGps);
    }
        // load the view and pass the parcels
    return View::make('app.parcel.showevent')
    ->with('parcels', $parcelsGpsArray)
    ->with('events', $events)
    ->with('users', $users); 
}


public function showParcelsEventsForm(Request $request){

 $user = $request->user;
 $daterange =  $request->daterange;
 $dateStart =  $request->dateStart;
 $dateEnd =  $request->dateEnd;

 $events = Event::where('idUser', $user)
 ->where('idUser', $user)
 ->whereBetween('dateGps', [$dateStart, $dateEnd])
 ->get();
 $users = User::all();

 $parcels = Parcel::all();

 $parcelsGpsArray = [];
 foreach ($parcels as $key => $value) {
    $parcelsGps = ParcelGps::where('idparcel', $value->id)
    ->orderBy('number')
    ->select('lat', 'long')
    ->get();    
    array_push($parcelsGpsArray , $parcelsGps);
}
        // load the view and pass the parcels
return View::make('app.parcel.showevent')
->with('parcels', $parcelsGpsArray)
->with('events', $events)
->with('users', $users)
->with('user', $user); 
}

}