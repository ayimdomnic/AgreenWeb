@extends('layouts.map')
@section('content')
{{ Html::style('css/timeline.css') }}
{{ Html::script('js/timeline.js') }}
<div class="panel panel-default" style="height: 100%; width: 100%">
	<div class="panel-body" >
		<div id="visualization"></div>
		<script type="text/javascript">
			var container = document.getElementById('visualization');
			var items = new vis.DataSet([
				{id: 1, content: 'item 1', start: '2014-04-20'},
				{id: 2, content: 'item 2', start: '2014-04-14'},
				{id: 3, content: 'item 3', start: '2014-04-18'},
				{id: 4, content: 'item 4', start: '2014-04-16', end: '2014-04-19'},
				{id: 5, content: 'item 5', start: '2014-04-25'},
				{id: 6, content: 'item 6', start: '2014-04-27', type: 'point'}
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



