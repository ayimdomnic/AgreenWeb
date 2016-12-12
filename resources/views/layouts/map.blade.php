    <!doctype html>
    <html lang="fr">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <meta name="mobile-web-app-capable" content="yes">
      <link rel="icon" sizes="192x192" href="images/android-desktop.png">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="apple-mobile-web-app-title" content="Material Design Lite">
      <link rel="apple-touch-icon-precomposed" href="">
      <meta name="msapplication-TileImage" content="">
      <meta name="msapplication-TileColor" content="#3372DF">
      <link rel="shortcut icon" href="g">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=fr">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      {{ Html::style('css/material.indigo-pink.min.css') }}
      {{ Html::style('css/style.css') }}
      {{ Html::style('css/daterangepicker.css') }}
      {!! HTML::script('js/jquery.js') !!}
      {!! HTML::script('js/material.min.js') !!}
      {!! HTML::script('js/jquery-ui.js') !!}
      {!! HTML::script('js/daterange.js') !!}
      {!! HTML::script('js/js.js') !!}
      {!! HTML::script('js/app.js') !!}
      {!! HTML::script('js/moment.js') !!}
      {!! HTML::script('js/daterangepicker.js') !!}
      <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css"/>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <script>
        window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
          ]); ?>
        </script>
      </head>
      <body>
        <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
          <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
            <div class="mdl-layout__header-row">
             @yield('header')
             <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
             </div>
             <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
              <i class="material-icons">more_vert</i>
            </button>
            <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
              @if(!Auth::guest())
              <li>    <a href="{{ url('/logout') }}" 
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Logout
              </a>
              <form id="logout-form" 
              action="{{ url('/logout') }}" 
              method="POST" 
              style="display: none;">
              {{ csrf_field() }}
            </form></li>                           
            @endif
          </ul>
        </div>
      </header>
      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
          <h5>{{ config('app.name', 'Laravel') }}</h5> 
          <div class="demo-avatar-dropdown">
            <div class="mdl-layout-spacer"></div>
          </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
         <a class="mdl-navigation__link" href="{{ URL::to('app') }}"><i class="mdl-color-text--white-grey-400 material-icons" role="presentation">home</i>Accueil</a>
         <li class="dropdown">
          <a href="#" data-toggle="dropdown" class="mdl-navigation__link"><i
            class="mdl-color-text--blue-grey-400 material-icons">directions_car</i>Captures</a><input type="checkbox"/>
            <ul class="dropdown-menu-agreen">
              <li><a class="mdl-navigation__link black" href="{{ URL::to('event') }}">Events</a>
              </li>
              <li><a class="mdl-navigation__link black" href="{{ URL::to('showEventsUser') }}">events by user</a>
              </li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="mdl-navigation__link"><i
              class="mdl-color-text--blue-grey-400 material-icons">bluetooth_connected</i>Fitting</a><input type="checkbox"/>
              <ul class="dropdown-menu-agreen">
                <li><a class="mdl-navigation__link black" href="{{ URL::to('fitting') }}">Fitting</a>
                </li>
                <li><a class="mdl-navigation__link black" href="{{ URL::to('showFittingsUser') }}">fittings by user</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="mdl-navigation__link"><i
                class="mdl-color-text--blue-grey-400 material-icons">access_time
              </i>Sessions</a><input type="checkbox"/>
              <ul class="dropdown-menu-agreen">
                <li><a class="mdl-navigation__link black" href="{{ URL::to('blesession') }}">Sessions</a>
                </li>
                <li><a class="mdl-navigation__link black" href="{{ URL::to('generateSessions') }}">generateSessions</a>
                </li>
              </ul>
            </li>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--white-grey-400 material-icons" role="presentation">computer</i>GIE</a>

            <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="mdl-navigation__link"><i
                class="mdl-color-text--blue-grey-400 material-icons">inbox</i>Parcelles</a><input type="checkbox"/>
                <ul class="dropdown-menu-agreen">
                 <li><a class="mdl-navigation__link black" href="{{ URL::to('parcel') }}">Parcelles</a>
                 </li>
                 <li><a class="mdl-navigation__link black" href="{{ URL::to('showParcels') }}">ParcellesMap</a>
                 </li>
                 <li><a class="mdl-navigation__link black" href="{{ URL::to('showParcelsEvents') }}">Parcelles and events</a>
                 </li>
               </ul>
             </li>
           </nav>
         </div>
         <main class="mdl-layout__content mdl-color--grey-100">
          <div class="mdl-grid" style="padding: 0;">
            @yield('content')
          </div>
        </div>
      </body>
      </html>
