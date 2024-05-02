<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <title>How To Create a Laravel 9 Blade Layout Templating</title>

  @include('partials.styles')
</head>
<body>

@include('admin_partials.header')

<main class="container mt-5">
    @yield('content')
</main>

@include('admin_partials.footer')

@include('admin_partials.scripts')

</body>
</html>
