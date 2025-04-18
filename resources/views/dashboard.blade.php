<x-app-layout>
    @section('content')
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold" href="#">Envios USA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDashboard" aria-controls="navbarDashboard" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarDashboard">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.crear') }}">Crear Cliente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.ver') }}">Ver Clientes</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
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
                    <h3 class="fw-bold">Bienvenido, {{ Auth::user()->name }} </h3>
                    <p class="text-muted">Desde aquí puedes gestionar tus clientes y más.</p>
                </div>

                <div class="row justify-content-center">
                    {{-- Tarjeta: Crear Cliente --}}
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-person-plus fs-1 text-success mb-3"></i>
                                <h5 class="card-title">Crear Cliente</h5>
                                <p class="card-text">Agrega un nuevo cliente al sistema de manera sencilla.</p>
                                <a href="{{ route('clientes.crear') }}" class="btn btn-success w-100">Ir a Crear</a>
                            </div>
                        </div>
                    </div>

                    {{-- Tarjeta: Ver Clientes --}}
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                                <h5 class="card-title">Ver Clientes</h5>
                                <p class="card-text">Consulta y administra la lista completa de tus clientes.</p>
                                <a href="{{ route('clientes.ver') }}" class="btn btn-primary w-100">Ver Clientes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
