<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Auklet Technology'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="{{ asset('css/estilo-personalizable.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body class="bg-dark text-light">

    <!-- Splash Screen -->
    <div id="splash-screen" class="d-flex flex-column justify-content-center align-items-center vh-100 bg-dark">
        <img src="{{ asset('imagenes/logo.png') }}" alt="Logo Auklet Technology" class="logo-splash mb-3" style="height:80px;">
        <h1 class="text-neon fw-bold">Auklet Technology</h1>
    </div>

    <!-- Contenido principal oculto -->
    <div id="main-content" style="display: none;">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-neon mb-4">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center text-neon fw-bold" href="{{ route('home') }}">
                    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo Auklet Technology" height="40" class="me-2">
                    Auklet Technology
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Menú principal -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active text-neon' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('productos*') ? 'active text-neon' : '' }}" href="{{ route('productos.index') }}">
                                <i class="bi bi-box-seam"></i> Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contacto') ? 'active text-neon' : '' }}" href="{{ route('contacto') }}">
                                <i class="bi bi-envelope"></i> Contacto
                            </a>
                        </li>
                    </ul>
                    <!-- Menú derecho -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-person"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-person-plus"></i> Registro</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenido dinámico -->
        <main class="container">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark border-top border-neon text-center py-4 mt-5">
            <p class="mb-1 text-neon">© {{ date('Y') }} Auklet Technology - Todos los derechos reservados</p>
            <p class="mb-1">Contacto: <a href="mailto:info@auklet.com" class="text-light">info@auklet.com</a></p>
            <div class="mt-2">
                <a href="https://facebook.com" target="_blank" class="text-light me-3"><i class="bi bi-facebook"></i></a>
                <a href="https://twitter.com" target="_blank" class="text-light me-3"><i class="bi bi-twitter"></i></a>
                <a href="https://instagram.com" target="_blank" class="text-light"><i class="bi bi-instagram"></i></a>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Splash -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            const splash = document.getElementById("splash-screen");
            splash.style.transition = "opacity 600ms ease, visibility 600ms";
            splash.style.opacity = "0";
            setTimeout(() => {
                splash.remove();
                const main = document.getElementById("main-content");
                main.style.display = "block";
                main.style.opacity = "0";
                main.style.transition = "opacity 400ms ease";
                setTimeout(() => main.style.opacity = "1", 50);
            }, 700);
        }, 2500);
    });
    </script>
</body>
</html>
