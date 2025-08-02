<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Fertilizer_Distribution') }}</title>
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


      <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/all.css') }}" rel="stylesheet">





      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <style>
    @font-face {
        font-family: 'Montserrat';
        src: url('{{ asset('font/Montserrat-Regular.ttf') }}') format('truetype');
        font-weight: 400;
        font-style: normal;
    }

    @font-face {
        font-family: 'Montserrat';
        src: url('{{ asset('font/Montserrat-Bold.ttf') }}') format('truetype');
        font-weight: 700;
        font-style: normal;
    }

    body {
        font-family: 'Montserrat', sans-serif;
    }
</style>

   </head>
   <body class="antialiased">
      <div class="min-h-screen  cover-img">
         @include('layouts.navigation')

         <main>

        @yield('content')
         </main>


      </div>
   </body>

 <script src="{{ asset('js/jquery.min.js') }}"></script>
 <script src="{{ asset('js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('js/datatables.min.js') }}"></script>

 <script src="{{ asset('js/dataTables.min.js') }}"></script>
 <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/jszip.min.js') }}"></script>
 


<script>
      // Auto-fade success alert
    setTimeout(function() {
        let alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500); // Remove from DOM after fade
        }
    }, 3000); // 3 seconds

    // Auto-fade error alert
    setTimeout(function() {
        let alert = document.getElementById('error-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
  </html>
