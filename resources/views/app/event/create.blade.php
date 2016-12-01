@extends('layouts.app')
@section('content')
<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--3-offset mdl-cell--6-col mdl-grid">
<div class="bar">
   <h2 class="mdl-card__title-text">Créer une parcelle</h2>
</div>
   {{ Html::ul($errors->all()) }}
   {{ Form::open(array('url' => 'parcel', 'class' => 'mdl-grid mdl-cell--12-col')) }}
   <div class="mdl-cell--12-col ">
       <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label inputsForm">
        {{ Form::label('name', 'Nom', array('class' => 'mdl-textfield__label ', 'for' => 'name')) }}
        {{ Form::text('name', Input::old('name'), array('class' => 'mdl-textfield__input ', 'id' => 'name')) }}
    </div>
</div>
<div class="mdl-cell--12-col">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label inputsForm">
        {{ Form::label('type', 'Type', array('class' => 'mdl-textfield__label', 'for' => 'type')) }}
        {{ Form::text('type', Input::old('type'), array('class' => 'mdl-textfield__input', 'id' => 'type'))}}
    </div>
</div>
<div class="mdl-cell--12-col">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label inputsForm">
        {{ Form::label('desc', 'Description', array('class' => 'mdl-textfield__label', 'for' => 'desc')) }}
        {{ Form::textarea('desc', Input::old('desc'), array('class' => 'mdl-textfield__input', 'id' => 'desc')) }}
    </div>
</div>
<div class="mdl-cell--12-col">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label inputsForm">
        {{ Form::label('area', 'Surface', array('class' => 'mdl-textfield__label', 'for' => 'area')) }}
        {{ Form::text('area', Input::old('area'), array('class' => 'mdl-textfield__input', 'id' => 'area')) }}
    </div>
    <div class="mdl-cell--12-col">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label inputsForm">
            {{ Form::label('statut', 'Statut', array('class' => 'mdl-textfield__label', 'for' => 'statut')) }}
            {{ Form::text('statut', Input::old('statut'), array('class' => 'mdl-textfield__input', 'id' => 'statut')) }}
        </div>
    </div>
    {{ Form::submit('Valider', array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent buttonForm')) }}
    {{ Form::close() }}
</div>
@endsection

