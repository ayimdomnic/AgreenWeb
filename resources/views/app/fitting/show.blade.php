@extends('layouts.app')
@section('content')
<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--3-offset mdl-cell--6-col mdl-grid">
    <div class="bar">
     <h2 class="mdl-card__title-text">{{ $parcel->name }}</h2>
 </div>
 <div class="jumbotron text-center">
    <p>
        <strong>Id:</strong> {{ $parcel->id }}<br>
        <strong>Type:</strong> {{ $parcel->type }}<br>
        <strong>Description:</strong> {{ $parcel->desc }}<br>
        <strong>Surface:</strong> {{ $parcel->area }}<br>
        <strong>Statut:</strong> {{ $parcel->statut }}<br>
    </p>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
