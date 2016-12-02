@extends('layouts.app')
@section('content')
<div class="panel panel-default">
	<div class="panel-body">
		<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--1-offset mdl-cell--10-col mdl-grid">
			<div class="bar">
				<h2 class="mdl-card__title-text floatleft">Liste des fittings</h2>
				<a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--primary floatright" href="{{ URL::to('fitting/create') }}" ><i class="material-icons">add</i></a>
			</div>
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
				<thead>
					<tr>
						<th style="text-align: center;">Id</th>
						<th style="text-align: center;">Nom</th>
						<th style="text-align: center;">Type</th>
						<th style="text-align: center;">Description</th>
						<th style="text-align: center;">Surface</th>
						<th style="text-align: center;">Statut</th>
						<th style="text-align: center;">Modifier</th>
						<th style="text-align: center;">Supprimer</th>
					</tr>
				</thead>
				<tbody>
					@foreach($fittings as $key => $value)
					<tr>
						<td class="mdl-data-table__cell--non-numeric"><a class="mdl-button mdl-js-button mdl-button--primary" href="{{ URL::to('fitting/' . $value->id) }}">{{ $value->id }}</a></td>
						<td class="mdl-data-table__cell--non-numeric">{{ $value->Mac }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ $value->idUser }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ $value->type }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ $value->timesFitting }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ $value->timeSync }}</td>
						<td class="mdl-data-table__cell--non-numeric">{{ $value->isSync }}</td>
						<td>
							<a class="mdl-button mdl-js-button mdl-button--accent" href="{{ URL::to('fitting/' . $value->id . '/edit') }}"><i class="material-icons">build</i>
							</a>
						</td>
						<td>
							{{ Form::open(array('url' => 'fitting/' . $value->id)) }}
							{{ Form::hidden('_method', 'DELETE') }}
							{{ Form::button('<i class="material-icons">delete</i>', array('type' => 'submit', 'class' => 'mdl-button mdl-js-button mdl-button--accent')) }}
							{{ Form::close() }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
