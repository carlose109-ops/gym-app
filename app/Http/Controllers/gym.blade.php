<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IronGym - UAEMéx</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #1a1a1a; }
        .hero-section { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000') no-repeat center center/cover; color: white; padding: 100px 0; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="{{ url('/') }}">IRON GYM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('membresias.index') }}">Membresías</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Tienda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('carrito.index') }}">Carrito 🛒</a></li>
                
                @auth
                    @if(in_array(Auth::user()->email, ['carloseduardot109@gmail.com', 'gabyrebal23@gmail.com']))
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold" href="{{ route('admin.index') }}">Panel Administrador ⚙️</a>
                        </li>
                    @endif
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-warning btn-sm ms-2 text-white" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-warning btn-sm ms-2 text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid p-0">
    @if(session('error'))
        <div class="alert alert-danger text-center fw-bold m-0 rounded-0 border-0 shadow-sm" style="background-color: #dc3545; color: white;">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; 2026 IronGym - Ingeniería en Software UAEMéx</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>