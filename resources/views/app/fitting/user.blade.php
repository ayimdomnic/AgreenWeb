@extends('layouts.map')
@section('header')
{{ Form::open(array('url' => 'showFittingsUserForm', 'class' => 'mdl-grid mdl-cell--12-col')) }}
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
{{ Html::style('css/timeline.css') }}
{{ Html::script('js/timeline.js') }}
<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body" >
		<div id="visualization" class="mdl-cell mdl-cell--12-col mdl-color--white mdl-shadow--2dp" style="margin-top: 12.5%"></div>
		<script type="text/javascript">
			var container = document.getElementById('visualization');
			var items = new vis.DataSet([
				@if(isset($fittings))
				@foreach($fittings as $key => $value)
				<?php
				echo "{id:" ;
				echo  $value->id  ;
				echo ", content:'";
				echo  $value->Mac;
				echo "', start: '";
				echo $value->timesFitting;
				echo "'},"; 
				?>
				@endforeach
				@endif
				]);
			var options = {
				width: '100%',
				height: '50vh',
			};
			var timeline = new vis.Timeline(container, items, options);
		</script> 
	</div>
</div>
@endsection



