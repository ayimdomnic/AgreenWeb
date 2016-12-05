@extends('layouts.map')
@section('content')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body" >

		<select class="mdl-select__input" id="professsion" name="professsion">
			@foreach($users as $key => $value)
			<?php echo "<option value='" . $value->id . "'>". $value->firstname . " " .$value->name. " - " .$value->idUser."</option>"; ?>
			@endforeach
		</select>

		<input class="mdl-textfield__input" id="daterange" type="text" name="daterange" value="01/01/2016 - 01/31/2016" />

		<script type="text/javascript">
			$( document ).ready(function() {
				$(function() {
					$('input[name="daterange"]').daterangepicker();
				});
			});
		</script>
		<div id="map" class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col" style="margin: 0; padding: 0; height: 93.3vh; width: 100%"></div>
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: 45, lng: 4},
					mapTypeId: 'hybrid',
					scrollwheel: true,
					zoom: 9
				});
				@foreach($events as $key => $value)
				<?php
				echo "var myLatLng = {lat:";
				echo $value->lat;
				echo ", lng: ";
				echo $value->lon;
				echo "};"; ?>
				<?php echo "var marker = new google.maps.Marker({position: myLatLng,map: map,title: 'Hello World!'});"; ?>
				@endforeach
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesZqDS4WItvSK-8xGDStpn7bKuVXZYkE&callback=initMap"
		async defer></script>
	</div>
</div>
@endsection