@extends('layouts.home')

@section('content')
<div class="demo-container mdl-grid">
	<div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
	<div class="demo-content content mdl-color-text--grey-800 mdl-cell mdl-cell--4-col content">
		<h1 class="title">Discover Percel,</h1>
		<h2 class="subtitle">the revolution is here</h1>
		</div>
		<div class="demo-content content mdl-color-text--grey-800 mdl-cell mdl-cell--4-col login">
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<input type="email" id="email" value="{{ old('email') }}"   name="email" placeholder="email address" required autofocus>
				</div>
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<input type="password" id="password" value="{{ old('password') }}"   name="password" placeholder="password" required>
				</div>
				<div>
					<button  type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
						Log In
					</button>
				</div>
				<div>
					<input type="hidden" id="checkbox-1" name="remember" class="mdl-checkbox__input" checked>
					<a href="{{ url('/password/reset') }}">
						<button class="mdl-button mdl-js-button mdl-js-ripple-effect">
							Forgot Your Password?
						</button>
					</a>
				</div>
			</form>
		</div>
	</div>
	@endsection
