<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envios USA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .hero {
            background-image: url("{{ asset('img/puerto-fondo.png') }}");
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 1px 1px 4px black;
        }
        .banderas img {
            width: 50px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">Envios USA</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="login">Login</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#seguimiento">Seguimiento</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contacto">Contacto</a></li>
                    <!-- Si el usuario está logueado, mostrar estos enlaces -->
                    @auth
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('clientes.crear') }}">Crear Cliente</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('clientes.ver') }}">Ver Cliente</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero text-center py-5">
            <div class="container">
                <h2 class="display-5 fw-bold">Envíos rápidos y seguros</h2>
                <p class="lead">Soluciones logísticas desde USA a Centroamérica</p>
                <div class="banderas d-flex justify-content-center mt-4">
                    <img src="{{ asset('img/mexico.png') }}" alt="México">
                    <img src="{{ asset('img/guatemala.png') }}" alt="Guatemala">
                    <img src="{{ asset('img/elsalvador.png') }}" alt="El Salvador">
                    <img src="{{ asset('img/honduras.png') }}" alt="Honduras">
                </div>
            </div>
        </section>

        <section id="servicios" class="container py-5">
            <h3 class="text-center mb-4">Nuestros Servicios</h3>
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="bi bi-globe-americas fs-1 text-primary"></i>
                    <h5>Transporte Internacional</h5>
                    <p>Rápido y eficiente desde USA hacia México, Guatemala, El Salvador y Honduras.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-box-seam fs-1 text-primary"></i>
                    <h5>Empaque Seguro</h5>
                    <p>Protección garantizada para tus paquetes delicados o voluminosos.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-truck fs-1 text-primary"></i>
                    <h5>Rastreo en Tiempo Real</h5>
                    <p>Sigue tu envío desde el origen hasta su destino final.</p>
                </div>
            </div>
        </section>

     

        <section id="seguimiento" class="bg-light py-5">
        {{-- Dentro del container --}}
<div class="row mb-4">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('seguimiento') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="tracking_number" 
                               class="form-control" 
                               placeholder="Buscar envío por tracking">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        </section>

        <section id="contacto" class="container py-5">
            <h3 class="text-center mb-4">Contáctanos</h3>
            <p class="text-center">¿Tienes preguntas? Estamos para ayudarte con tu envío.</p>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2025 Envios USA. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
