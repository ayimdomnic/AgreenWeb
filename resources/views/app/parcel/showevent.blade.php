@extends('layouts.map')
@section('header')
{{ Form::open(array('url' => 'showParcelsEventsForm', 'class' => 'mdl-grid mdl-cell--12-col')) }}
<div class="demo-charts  mdl-cell mdl-cell--3-offset mdl-cell--2-col">
	<select class="mdl-select__input mdl-color--white mdl-shadow--2dp" id="professsion" name="user" style="padding: 8px 0px">
		@foreach($users as $key => $value)
		<?php echo "<option value='" . $value->idUser . "'>". $value->firstname . " " .$value->name. " - " .$value->idUser."</option>"; ?>
		@endforeach
	</select>
</div>
<div class="demo-charts mdl-cell mdl-cell--3-col">
	{{ Form::text('daterange', Input::old('name'), array('class' => 'mdl-textfield__input mdl-color--white mdl-shadow--2dp', 'id' => 'demo', 'style' => 'padding: 7px 11px')) }}
</div>
<div class="demo-charts mdl-cell  mdl-cell--1-col">
	{{ Form::submit('Valider', array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent', 'style' => 'width: 100%')) }}
</div>
<input type="hidden" name="dateStart" id="dateStart">
<input type="hidden" name="dateEnd" id="dateEnd">
{{ Form::close() }}
@endsection
@section('content')

<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body"  style="padding: 0;">
		<div id="map" class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col" style="margin: 0; padding: 0; height: 93.3vh; width: 100%"></div>
		<script>

			function getRandomColor() {
				var letters = '0123456789ABCDEF';
				var color = '#';
				for (var i = 0; i < 6; i++ ) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}

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
				
				<?php $count = 0;?>
				@foreach($parcels as $key => $value)
				<?php
				$count ++;
				echo "var parcelCoords". $count. " = [";
				foreach ($value as $key => $value) {
					echo "{lat:";
					echo $value->lat;
					echo ", lng: ";
					echo $value->long;
					echo "},"; 
				}
				echo "];"; 
				echo "var parcel". $count. " = new google.maps.Polygon({";
				echo "paths: parcelCoords" . $count .",";
				echo "strokeColor: 'red',";
				echo "strokeOpacity: 0.8,";
				echo "strokeWeight: 0.3,";
				echo "fillColor: getRandomColor(),";
				echo "fillOpacity: 0.5});";
				echo "parcel". $count. ".setMap(map);";
				?>
				@endforeach

			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesZqDS4WItvSK-8xGDStpn7bKuVXZYkE&callback=initMap"
		async defer></script>
	</div>
</div>
@endsection
<div>
</div>