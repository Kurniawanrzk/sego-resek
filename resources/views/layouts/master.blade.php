<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <meta name="author" content="Mahasiswa Teknik Informatika Universitas Negeri Malang Angkatan 23">
  <title>SegoResek | Website</title>
  @include('partials.styles')
</head>
<body>

@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')

@include('partials.scripts')

</body>
</html>
