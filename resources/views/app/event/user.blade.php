@extends('layouts.map')
@section('header')

{{ Form::open(array('url' => 'showEventUserForm', 'class' => 'mdl-grid mdl-cell--12-col')) }}
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
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body"  style="padding: 0;">
		<script type="text/javascript">
			$( document ).ready(function() {
				var currentDateFirst = moment().startOf('day').format("YYYY/MM/DD H:m:s");
				var currentDateLast = moment().endOf('day').format("YYYY/MM/DD H:m:s");
				var currentMonthFirst = moment().startOf('month').format("YYYY/MM/DD H:m:s");
				var currentMonthLast = moment().endOf('month').format("YYYY/MM/DD H:m:s");
				var lastWeekFirst = moment().subtract(1, 'weeks').startOf('isoWeek')
				var lastWeekLast = moment().format("YYYY/MM/DD H:m:s");
				var lastMonthFirst = moment().subtract(1, 'month').startOf('month')
				var lastMonthEnd = moment().subtract(1, 'month').endOf('month')
				var last30Days = moment().subtract(30, 'days');
				var last7Days = moment().subtract(7, 'days');
				var yesterdayFirst = moment().subtract(1, 'day').startOf('day');
				var yesterdayLast = moment().subtract(1, 'day').endOf('day');
				$('#demo').daterangepicker({
					"timePicker": true,
					"timePicker24Hour": true,
					"ranges": {
						"Aujourd'hui": [
						currentDateFirst,
						currentDateLast
						],
						"Hier": [
						yesterdayFirst,
						yesterdayLast
						],
						"7 derniers jours": [
						last7Days,
						currentDateLast
						],
						"30 derniers jours": [
						last30Days,
						currentDateLast
						],
						"Ce mois-ci": [
						currentMonthFirst,
						currentMonthLast
						],
						"Le mois dernier": [
						lastMonthFirst,
						lastMonthEnd
						]
					},
					"locale": {
						"format": "YYYY/MM/DD H:m:s",
						"separator": " - ",
						"applyLabel": "Apply",
						"cancelLabel": "Cancel",
						"fromLabel": "From",
						"toLabel": "To",
						"customRangeLabel": "Custom",
						"weekLabel": "W",
						"daysOfWeek": [
						"Su",
						"Mo",
						"Tu",
						"We",
						"Th",
						"Fr",
						"Sa"
						],
						"monthNames": [
						"Janvier",
						"Fevrier",
						"Mars",
						"Avril",
						"Mai",
						"Juin",
						"Juillet",
						"Aout",
						"Septembre",
						"Octobre",
						"Novembre",
						"Decembre"
						],
						"firstDay": 1
					},
				}, function(start, end, label) {
				document.getElementById('dateStart').value = start.format('YYYY-MM-DD H:m:s');
				document.getElementById('dateEnd').value = end.format('YYYY-MM-DD H:m:s');
					console.log("New date range selected: ' + start.format('YYYY-MM-DD H:m:s') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
				});
				
			});
		</script>

<input type="text" name="dateStart" id="dateStart">
<input type="text" name="dateEnd" id="dateEnd">

		@if (isset($daterange))
		{!! $daterange !!}
		@endif

		@if (isset($user))
		{!! $user !!}
		@endif

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

<div>
</div>