<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Perpustakaan' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body
    class="d-flex flex-column justify-content-center align-items-center text-center min-vh-100 py-5 bg-light">
    {{ $slot }}
</body>

</html>
