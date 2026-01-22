<!DOCTYPE html>
<html lang='id'>
<head>
    <title>@yield('title', 'Data Wilayah v5.0')</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="author" content="Wilayah Indonesia" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <meta name="keywords" content="php, laravel, mysql, data, administrasi, wilayah, indonesia, kepmendagri" />
    <meta name="description" content="Data wilayah administrasi Indonesia sesuai kepmendagri, dalam bahasa pemrograman PHP Laravel dan database MySQL" />
    <meta name="robots" content="index, follow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/w3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/w3-theme-' . session('theme', 'indigo') . '.css') }}" media="all" id="wil_css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <div class="w3-top">
        <div class="w3-bar w3-theme-d5">
            <span class="w3-bar-item"># Wilayah Indonesia v5.0</span>
            <div class="w3-dropdown-hover">
                <button class="w3-button">Themes</button>
                <div class="w3-dropdown-content w3-white w3-card-4" id="theme">
                    @foreach(['black', 'brown', 'pink', 'orange', 'amber', 'lime', 'green', 'teal', 'purple', 'indigo', 'blue', 'cyan'] as $color)
                        <a href="#" class="w3-bar-item w3-button w3-{{ $color }} color" data-value="{{ $color }}" onclick="changeTheme('{{ $color }}'); return false;"> </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('home') }}" class="w3-bar-item w3-button">Home</a>
            <a href="{{ route('wilayah.islands') }}" class="w3-bar-item w3-button">Pulau</a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="w3-container" style="margin-top: 60px;">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="w3-bottom">
        <div class="w3-bar w3-theme-d4 w3-center w3-padding">
            Wilayah Indonesia v5.0 copyright &copy; 2025
            <br />
            <small>source code : <a href='https://github.com/cahyadsn/wilayah' target="_blank">https://github.com/cahyadsn/wilayah</a></small>
        </div>
    </div>

    @stack('scripts')

    <script>
        function changeTheme(theme) {
            // Change CSS link
            document.getElementById('wil_css').href = '/css/w3-theme-' + theme + '.css';

            // Save preference to session via AJAX
            fetch('/theme/' + theme, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
        }
    </script>
</body>
</html>
