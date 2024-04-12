<!DOCTYPE html>
<html lang="en">

  <head>
    
    <!-- carachters and viewport tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <meta content="{{ csrf_token() }}" name="csrf-token">

    <!-- SEO tags -->
    {{-- <meta name="author" content="{{ env('APP_AUTHOR') }}" /> --}}
    <meta name="author" content="Serena Malusà" />
    <meta name="description" content="laravel exercise">

    <!-- title and icon -->
    <title>{{ env('APP_NAME') }} @yield('title')</title>
    <link rel="icon" href="{{ url('/logo-small.ico') }}">

    <!-- css -->
    @vite('resources/js/app.js')
    

    @vite('resources/js/app.js')

    @yield('css')
  </head>

  <body>
    <div class="wrapper">
      @include('layouts.partials.header')

      <main>
        @yield('content')
      </main>

      @include('layouts.partials.footer')
    </div>

    @auth
      <script>
        const logoutLink = document.getElementById('logout-link');
        const logoutForm = document.getElementById('logout-form');

        logoutLink.addEventListener('click', (e) => {
          e.preventDefault();
          logoutForm.submit();
        });
      </script>
    @endauth

    @yield('modals')

    @yield('js')
  </body>

</html>
