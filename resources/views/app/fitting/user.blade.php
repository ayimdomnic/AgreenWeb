@extends('layouts.map')
@section('content')
{{ Html::style('css/timeline.css') }}
{{ Html::script('js/timeline.js') }}
<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body" >
		<?php
		
		?>
		<!-- <div id="visualization" class="mdl-cell mdl-cell--12-col mdl-color--white mdl-shadow--2dp" style="margin-top: 12.5%"></div>
		<script type="text/javascript">
			var container = document.getElementById('visualization');
			var items = new vis.DataSet([
				@foreach($fittings as $key => $value)
				 <?php
				 // echo "{id:" ;
				// echo  $value->id  ;
				// echo ", content:'";
				// echo  $value->Mac;
				// echo "', start: '";
				// echo $value->timesFitting;
				// echo "'},"; 
				?>
				@endforeach
				]);
			var options = {
				width: '100%',
				height: '50vh',
			};
			var timeline = new vis.Timeline(container, items, options);
		</script> -->
	</div>
</div>
@endsection



