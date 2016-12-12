@extends('layouts.map')
@section('content')

<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body"  style="padding: 0;">
		<div id="map" class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col" style="margin: 0; padding: 0; height: 93.3vh; width: 100%"></div>
		<script>
			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: 45, lng: 4},
					mapTypeId: 'hybrid',
					scrollwheel: true,
					zoom: 9
				});

				var triangleCoords = [
				{lat: 25.774, lng: -80.190},
				{lat: 18.466, lng: -66.118},
				{lat: 32.321, lng: -64.757},
				{lat: 25.774, lng: -80.190}
				];

  // Construct the polygon.
  var bermudaTriangle = new google.maps.Polygon({
  	paths: triangleCoords,
  	strokeColor: '#FF0000',
  	strokeOpacity: 0.8,
  	strokeWeight: 2,
  	fillColor: '#FF0000',
  	fillOpacity: 0.35
  });
  bermudaTriangle.setMap(map);

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesZqDS4WItvSK-8xGDStpn7bKuVXZYkE&callback=initMap"
async defer></script>
</div>
</div>
@endsection
<div>
</div>