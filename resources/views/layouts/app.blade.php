<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <header class="main-header">
            <nav>
                <ul>
                    <li><a href="{{ route('clientes.crear') }}">Crear Cliente</a></li>
                    <li><a href="{{ route('clientes.ver') }}">Ver Cliente</a></li>
                    </ul>
            </nav>
        </header>

        <main class="main-content">
            @yield('content')  </main>

        <footer class="main-footer">
            <p>&copy; {{ date('Y') }} Mi Aplicación</p>
        </footer>
    </div>
</body>
</html>