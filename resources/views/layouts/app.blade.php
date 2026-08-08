<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Heladería')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-pink-100 via-yellow-100 to-blue-100">
        <!-- SOLO UNA VEZ: Incluir la navegación -->
        @include('layouts.navigation')

        <!-- Contenido principal -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-sm py-4 mt-8">
            <p>© {{ date('Y') }} Heladería - El sabor que te refresca</p>
        </footer>
    </div>
</body>
</html>