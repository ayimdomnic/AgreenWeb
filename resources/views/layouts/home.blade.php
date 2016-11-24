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
  <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">
  <meta name="msapplication-TileColor" content="#3372DF">
  <link rel="shortcut icon" href="images/favicon.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=fr">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.teal-blue.min.css" />
  {{ Html::style('css/home.css') }}
</head>
<body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header demo-layout-transparent">
    <header class="mdl-layout__header mdl-layout__header--transparent">
      <div class="mdl-layout__header-row">
        <span class="mdl-layout-title">{{ config('app.name', 'Laravel') }}</span>
        <div class="mdl-layout-spacer"></div>
      </div>
    </header>
    <main class="mdl-layout__content">
      <div class="page-content"> @yield('content')</div>
    </main>
    <footer class="mdl-mini-footer">
      <div class="mdl-mini-footer__left-section">
        <div class="mdl-logo">Title</div>
        <ul class="mdl-mini-footer__link-list">
          <li><a href="#">Help</a></li>
          <li><a href="#">Privacy & Terms</a></li>
        </div>
      </ul>
    </footer>
  </div>
  <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
</body>
</html>
