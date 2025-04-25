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
            background-size: 120% 120%; /* Larger background image */
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
            position: relative;
            overflow: hidden;
            transition: background-size 0.5s ease;
        }
        .hero:hover {
            background-size: 150% 150%; /* Zoom effect on hover */
            filter: brightness(1.1); /* Slight brightness increase */
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(4, 192, 206, 0.5);
            z-index: 1;
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }
        .banderas img {
            width: 50px;
            margin: 0 10px;
            transition: transform 0.3s ease;
        }
        .banderas img:hover {
            transform: scale(1.2) rotate(5deg);
        }
        .envios img {
            width: 200px;
            margin: 0 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .envios img:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(0, 48, 135, 0.5);
        }
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .navbar-dark .nav-link {
            transition: color 0.3s ease;
        }
        .navbar-dark .nav-link:hover {
            color: #ffd700 !important;
        }
        .btn-primary {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 48, 135, 0.5);
            background-color: #00205b !important; /* Darker shade on hover */
        }
        .fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }
        .bounce-in {
            animation: bounceIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.8); }
            60% { opacity: 1; transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color:rgb(1, 18, 48) !important;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/LOGODALLAS.png') }}" alt="Dallas Express Envios Logo" style="height: 60px; margin-right: 10px;">
                <span class="fw-bold">Dallas Express Envios</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#seguimiento">Seguimiento</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contacto">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#cotizacion">Cotización</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/login">Iniciar sesión</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <section class="hero text-center py-5 fade-in">
            <div class="container">
                <h2 class="display-5 fw-bold" style="user-select: none; cursor: default;">Envíos rápidos y seguros</h2>
                <p class="lead" style="user-select: none; cursor: default;">Soluciones logísticas desde USA a Centroamérica</p>
                <div class="banderas d-flex justify-content-center mt-4">
                    <img src="{{ asset('img/Usa.png') }}" alt="México">
                    <img src="{{ asset('img/mexico.png') }}" alt="México">
                    <img src="{{ asset('img/guatemala.png') }}" alt="Guatemala">
                    <img src="{{ asset('img/elsalvador.png') }}" alt="El Salvador">
                    <img src="{{ asset('img/honduras.png') }}" alt="Honduras">
                </div>
            </div>
        </section>

        <section id="servicios" class="container py-5">
        <h3 class="text-center mb-4 fw-bold text-dark bounce-in"
        style="user-select: none; cursor: default;">Nuestros Servicios
        </h3>

            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="service-card p-4 rounded shadow-sm bg-white">
                        <i class="bi bi-globe-americas fs-1 text-primary mb-3"></i>
                        <h5 class="text-primary" style="user-select: none; cursor: default;">Transporte Internacional</h5>
                        <p class="text-muted" style="user-select: none; cursor: default;">Rápido y eficiente desde USA hacia México, Guatemala, El Salvador y Honduras.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="service-card p-4 rounded shadow-sm bg-white">
                        <i class="bi bi-box-seam fs-1 text-primary mb-3"></i>
                        <h5 class="text-primary" style="user-select: none; cursor: default;">Empaque Seguro</h5>
                        <p class="text-muted" style="user-select: none; cursor: default;">Protección garantizada para tus paquetes delicados o voluminosos.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="service-card p-4 rounded shadow-sm bg-white">
                        <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                        <h5 class="text-primary" style="user-select: none; cursor: default;">Rastreo en Tiempo Real</h5>
                        <p class="text-muted" style="user-select: none; cursor: default;">Sigue tu envío desde el origen hasta su destino final.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="seguimiento" class="bg-light py-5">
            <div class="container">
                <h3 class="text-center mb-4 fw-bold text-dark bounce-in">Seguimiento de Envíos</h3>
                <div class="row mb-4">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow">
                            <div class="card-body">
                                <form action="{{ route('seguimiento') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="tracking_number" 
                                               class="form-control" 
                                               placeholder="Buscar envío por tracking">
                                        <button class="btn btn-primary" type="submit" style="background-color: #003087; border-color: #003087;">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- Seccion de cotizaciones --}}

        <section id="cotizacion" class="py-5 bg-light">
  <div class="container">
    <h3 class="text-center fw-bold mb-4 bounce-in" style="user-select: none; cursor: default;">
      Cotización de Envíos
    </h3>
    <p class="text-center text-muted mb-5" style="user-select: none; cursor: default;">
      Seleccioná el tamaño de tu caja para ver el precio estimado. Cotizamos por volumen, no por peso.
    </p>

    <div class="row g-4 justify-content-center">
      <!-- Tarjeta 1 -->
      <div class="col-md-3">
        <div class="card text-center p-4 shadow-sm h-100 service-card" onclick="cotizar('28x28x34', '$270')">
          <i class="bi bi-box fs-1 text-primary mb-3"></i>
          <h5 class="fw-bold">28 x 28 x 34</h5>
          <p class="text-muted" style="user-select: none; cursor: default;">Caja Grande</p>
        </div>
      </div>

      <!-- Tarjeta 2 -->
      <div class="col-md-3">
        <div class="card text-center p-4 shadow-sm h-100 service-card" onclick="cotizar('24x24x24', '$180')">
          <i class="bi bi-box-seam fs-1 text-primary mb-3"></i>
          <h5 class="fw-bold">24 x 24 x 24</h5>
          <p class="text-muted" style="user-select: none; cursor: default;">Caja Mediana</p>
        </div>
      </div>

      <!-- Tarjeta 3 -->
      <div class="col-md-3">
        <div class="card text-center p-4 shadow-sm h-100 service-card" onclick="cotizar('20x20x20', '$140')">
          <i class="bi bi-box-fill fs-1 text-primary mb-3"></i>
          <h5 class="fw-bold">20 x 20 x 20</h5>
          <p class="text-muted" style="user-select: none; cursor: default;">Caja Compacta</p>
        </div>
      </div>

      <!-- Tarjeta 4 -->
      <div class="col-md-3">
        <div class="card text-center p-4 shadow-sm h-100 service-card" onclick="cotizar('18x18x18', '$110')">
          <i class="bi bi-box2-heart fs-1 text-primary mb-3"></i>
          <h5 class="fw-bold">18 x 18 x 18</h5>
          <p class="text-muted" style="user-select: none; cursor: default;">Caja Pequeña</p>
        </div>
      </div>
    </div>

    <!-- Resultado -->
    <div class="text-center mt-5">
      <h5 class="fw-bold" style="user-select: none; cursor: default;">Resultado:</h5>
      <div id="resultadoCotizacion" class="text-primary fs-4" style="user-select: none; cursor: default;">Seleccioná una caja para cotizar</div>
      <p class="text-muted small mt-2" style="user-select: none; cursor: default;">Las medidas deben ser exactas. Si se exceden, pueden aplicarse recargos.</p>
    </div>
  </div>
</section>


        <section id="contacto" class="container py-5">
            <h3 class="text-center mb-2 fw-bold text-dark bounce-in" style="user-select: none; cursor: default;">Contáctanos</h3>
            <p class="text-center text-muted" style="user-select: none; cursor: default;">Escanea el código QR para contactarnos vía WhatsApp.</p>
            <div class="envios d-flex justify-content-center mt-2" style="user-select: none; cursor: default;">
                <img src="{{ asset('img/DallasExpressEnvios.png') }}" alt="WhatsApp QR Code">
            </div>
        </section>
    </main>

    <footer class="text-white text-center py-3" style="background-color:rgb(1, 13, 36) !important;">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <img src="{{ asset('img/LOGODALLAS.png') }}" alt="Dallas Express Envios Logo" style="height: 30px; margin-right: 10px;">
                <span>Dallas Express Envios</span>
            </div>
            <p class="mb-0" style="user-select: none; cursor: default;">© 2025 Dallas Express Envios. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function cotizar(medidas, precio) {
        const resultado = document.getElementById('resultadoCotizacion');
        resultado.innerHTML = `<strong>${medidas}</strong> → Precio estimado: <span class="text-success">${precio}</span>`;
    }
    </script>


</body>
</html>