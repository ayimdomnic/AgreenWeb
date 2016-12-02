@extends('layouts.map')
@section('content')
{{ Html::style('css/timeline.css') }}
{{ Html::script('js/timeline.js') }}
<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body" >
		{{$message}}
	</div>
</div>
@endsection



