<x-app-layout>
    @section('content')
        {{-- Navbar  --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm" style="background-color:rgb(2, 33, 92) !important;">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                    <img src="{{ asset('img/LOGODALLAS.png') }}" alt="Dallas Express Envios Logo" style="height: 40px; margin-right: 10px;">
                    Dallas Express Envíos
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDashboard" aria-controls="navbarDashboard" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarDashboard">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">   
                            <a class="nav-link active fw-semibold" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        @can('crear clientes')
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('seguimiento') }}">
                                <i class="bi bi-upc-scan"></i> Seguimiento
                            </a>
                        </li>
                        @endcan
                        @can('ver clientes')
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('clientes.ver') }}">Ver Clientes</a>
                        </li>
                        @endcan
                        @hasrole('admin')
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('roles.index') }}">Roles y Permisos</a>
                        </li>
                        @endhasrole
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarUserDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Contenido del dashboard --}}
        <div class="py-5 bg-light min-vh-100">
            <div class="container">
                <div class="text-center mb-5">
                    <h3 class="fw-bold text-dark">Bienvenido, {{ Auth::user()->name }}</h3>
                    <p class="text-muted">Desde aquí puedes gestionar tus clientes, envíos y más.</p>
                    <a href="/" class="btn btn-outline-primary mt-3">Volver al Inicio</a>
                </div>

                <div class="row justify-content-center">
                    @can('crear clientes')
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow h-100 border-0 transform-hover">
                            <div class="card-body text-center">
                                <i class="bi bi-person-plus fs-1 text-success mb-3"></i>
                                <h5 class="card-title text-success">Crear Cliente</h5>
                                <p class="card-text text-muted">Agrega un nuevo cliente al sistema de manera sencilla.</p>
                                <a href="{{ route('clientes.crear') }}" class="btn btn-outline-success w-100">Ir a Crear</a>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('ver clientes')
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow h-100 border-0 transform-hover">
                            <div class="card-body text-center">
                                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                                <h5 class="card-title text-primary">Ver Clientes</h5>
                                <p class="card-text text-muted">Consulta y administra la lista completa de tus clientes.</p>
                                <a href="{{ route('clientes.ver') }}" class="btn btn-outline-primary w-100">Ver Clientes</a>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('crear envios')
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow h-100 border-0 transform-hover">
                            <div class="card-body text-center">
                                <i class="bi bi-box-seam fs-1 text-warning mb-3"></i>
                                <h5 class="card-title text-warning">Crear Envío</h5>
                                <p class="card-text text-muted">Registra un nuevo envío con sus paquetes.</p>
                                <a href="{{ route('envios.create') }}" class="btn btn-outline-warning w-100 text-dark">Nuevo Envío</a>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('ver envios')
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow h-100 border-0 transform-hover">
                            <div class="card-body text-center">
                                <i class="bi bi-truck fs-1 text-dark mb-3"></i>
                                <h5 class="card-title text-dark">Ver Envíos</h5>
                                <p class="card-text text-muted">Consulta los envíos registrados y sus paquetes.</p>
                                <a href="{{ route('envios.index') }}" class="btn btn-outline-dark w-100">Ver Envíos</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta para Gestión de Paquetes -->
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow h-100 border-0 transform-hover">
                            <div class="card-body text-center">
                                <i class="bi bi-box fs-1 text-info mb-3"></i>
                                <h5 class="card-title text-info">Gestión de Paquetes</h5>
                                <p class="card-text text-muted">Administre los tipos de paquetes disponibles para envíos.</p>
                                <a href="{{ route('paquetes.index') }}" class="btn btn-outline-info w-100">Gestionar Paquetes</a>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @hasrole('admin')
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow h-100 border-0 transform-hover">
                            <div class="card-body text-center">
                                <i class="bi bi-shield-lock fs-1 text-danger mb-3"></i>
                                <h5 class="card-title text-danger">Gestión de Roles</h5>
                                <p class="card-text text-muted">Administra roles y permisos de los usuarios del sistema.</p>
                                <a href="{{ route('roles.index') }}" class="btn btn-outline-danger w-100">Gestionar Roles</a>
                            </div>
                        </div>
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>

        {{-- Estilos adicionales --}}
        <style>
            .navbar-dark .nav-link {
                transition: color 0.3s ease;
            }
            .navbar-dark .nav-link:hover {
                color: #ffd700 !important;
            }
            .card.transform-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .card.transform-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            }
            .btn-outline-success:hover, 
            .btn-outline-primary:hover, 
            .btn-outline-warning:hover, 
            .btn-outline-dark:hover, 
            .btn-outline-danger:hover,
            .btn-outline-info:hover {
                color: #fff !important;
            }
        </style>
    @endsection
</x-app-layout>
