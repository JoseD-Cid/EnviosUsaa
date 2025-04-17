<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
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

        <main class="content">
            <h1>¡Bienvenido a mi increíble página!</h1>
            <p>Esta es la página de inicio de tu aplicación Laravel.</p>
            <section class="info-section">
                <h2>Información General</h2>
                <ul>
                    <li>Laravel es un framework PHP para artesanos web.</li>
                    <li>Facilita el desarrollo de aplicaciones robustas y escalables.</li>
                    <li>¡Explora las funcionalidades!</li>
                </ul>
            </section>

            <section class="quick-actions">
                <h2>Acciones Rápidas</h2>
                <p>¿Qué deseas hacer hoy?</p>
                <ul>
                    <li><a href="{{ route('clientes.crear') }}">Ir a la página de creación de clientes.</a></li>
                    <li><a href="{{ route('clientes.ver') }}">Ver la lista de clientes existentes.</a></li>
                    <li>... otras acciones ...</li>
                </ul>
            </section>
        </main>

        <footer class="main-footer">
            <p>&copy; {{ date('Y') }} Mi Aplicación</p>
        </footer>
    </div>
</body>
</html>