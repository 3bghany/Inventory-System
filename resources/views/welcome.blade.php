<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="{{asset('backend/img/icon 2.png')}}" rel="icon">
        <title>Inventory System</title>
        <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('backend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('backend/css/ruang-admin.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"/>
        
    </head>
    <body class="antialiased">    

        <!-- Container Fluid-->
        <div  id="container-wrapper">
        <div id="app"></div>
        </div>

        <!---Container Fluid-->
      
        
        <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
        <script src="{{asset('backend/js/ruang-admin.min.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script> 
        @vite('resources/js/app.js')
    </body>
</html>


