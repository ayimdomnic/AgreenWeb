@extends('layouts.map')
@section('content')

<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body" >
		<div id="map" class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col" style="margin: 0; padding: 0; height: 93.3vh; width: 100%"></div>
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: 45, lng: 4},
					mapTypeId: 'satellite',
					scrollwheel: true,
					zoom: 8
				});
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesZqDS4WItvSK-8xGDStpn7bKuVXZYkE&callback=initMap"
		async defer></script>
	</div>
</div>
@endsection



