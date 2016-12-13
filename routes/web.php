<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('home');
});

Auth::routes();

Route::resource('parcel', 'ParcelController');

Route::resource('parcelgps', 'ParcelGpsController');

Route::resource('event', 'EventController');

Route::resource('fitting', 'FittingController');

Route::resource('blesession', 'BleSessionController');

Route::resource('processedevents', 'ProcessedEventsController');

Route::get('/home', 'HomeController@index');

Route::get('/app', 'AppController@index');

Route::get('/showEventsUser', 'EventController@showEventsUser');

Route::get('/showFittingsUser', 'FittingController@showFittingsUser');

Route::get('/showParcels', 'ParcelController@showParcels');

Route::get('/generateBleSessions', 'FittingController@generateSessions');

Route::get('/scanIsInsideParcel', 'EventController@scanIsInsideParcel');

Route::post('showEventUserForm', 'EventController@showEventsUserForm');

Route::post('showFittingsUserForm', 'FittingController@showFittingsUserForm');

Route::get('showParcelsEvents', 'ParcelController@showParcelsEvents');

Route::post('showParcelsEventsForm', 'ParcelController@showParcelsEventsForm');

Route::post('receiveEventsRaspberry', 'EventController@receiveEventsRaspberry');

Route::post('receiveBleRapsberry', 'FittingController@receiveFittingsRaspberry');