<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Demo Oscar Zambrano') }}</title>

   <!-- Styles -->
   <link href="{{ mix('css/app.css') }}" rel="stylesheet">

   <!-- Scripts -->
   <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), 'demoMode' => env('APP_DEMO')]) !!};</script>
</head>
<body>

<div id="app"></div>

<!-- Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
