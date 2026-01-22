<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wilayah Indonesia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold">Wilayah Indonesia</a>
                <div class="space-x-4">
                    <a href="{{ route('home') }}" class="hover:text-blue-200">Provinsi</a>
                    <a href="{{ route('wilayah.islands') }}" class="hover:text-blue-200">Pulau</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6 text-center">
            <p>Data Wilayah Administrasi Pemerintahan Indonesia</p>
            <p class="text-sm text-gray-400 mt-2">Berdasarkan Kepmendagri</p>
        </div>
    </footer>
</body>
</html>
