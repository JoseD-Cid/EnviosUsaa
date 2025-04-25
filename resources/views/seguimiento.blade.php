@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5 text-primary"> Rastrea tu Envío</h1>
        <p class="text-muted">Consulta el estado y la ubicación de tu paquete en tiempo real</p>
        <div id="hora-actual" class="text-end text-secondary small"></div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Formulario -->
            <form method="GET" class="card p-4 shadow-lg border-0">
                <div class="mb-3">
                    <label for="tracking_number" class="form-label fw-semibold">Código de seguimiento</label>
                    <div class="input-group input-group-lg">
                        <input type="text" name="tracking_number" id="tracking_number"
                            class="form-control border-primary"
                            placeholder="Ej: 123456ABC"
                            value="{{ $trackingNumber ?? '' }}"
                            required>
                        <button class="btn btn-primary" type="submit">🔍 Rastrear</button>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">⬅️ Volver al inicio</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    @if($envio)
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="alert alert-{{ $envio->estatus_envio == 'entregado' ? 'success' : 'info' }} shadow-sm">
                    <h4 class="mb-0">Estado: {{ ucfirst(str_replace('_', ' ', $envio->estatus_envio)) }}</h4>
                </div>

                <!-- Línea de tiempo -->
                <div class="timeline mt-4">
                    @foreach($envio->trackingHistory as $historial)
                        @php
                            $estado = $historial->estado;
                            $icon = match($estado) {
                                'pendiente' => '⏳',
                                'en_transito' => '🚛',
                                'en_aduana' => '📦',
                                'entregado' => '✅',
                                default => '🔘'
                            };
                            $color = match($estado) {
                                'pendiente' => 'warning',
                                'en_transito' => 'primary',
                                'en_aduana' => 'info',
                                'entregado' => 'success',
                                default => 'secondary'
                            };
                        @endphp
                        <div class="card mb-3 shadow-sm border-start border-4 border-{{ $color }}">
                            <div class="card-body">
                                <h5 class="card-title text-{{ $color }}">
                                    {{ $icon }} {{ ucfirst(str_replace('_', ' ', $estado)) }}
                                </h5>
                                <p class="card-text mb-1">{{ $historial->descripcion }}</p>
                                <p class="text-muted mb-0">📍 {{ $historial->ubicacion }}</p>
                                <small class="text-muted">{{ $historial->created_at->format('d/m/Y - h:i A') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mapa -->
                @php
                    $ultimaUbicacion = $envio->trackingHistory->last()?->ubicacion ?? 'Tegucigalpa, Honduras';
                @endphp
                <div class="my-5">
                    <h5 class="fw-bold mb-3">🌍 Ubicación actual estimada</h5>
                    <div id="map" style="height: 400px; border-radius: 10px;" class="shadow-sm"></div>
                </div>

                @if($envio->estatus_envio == 'entregado')
                    <div class="alert alert-success text-center mt-4 shadow">
                        <h5 class="mb-1">¡Entrega completada!</h5>
                        <p class="mb-0">Gracias por confiar en nuestro servicio. </p>
                    </div>
                @endif
            </div>
        </div>
    @elseif($trackingNumber)
        <div class="alert alert-danger mt-5 text-center fw-bold">
            🚫 No se encontró el envío con código: <strong>{{ $trackingNumber }}</strong>
        </div>
    @endif
</div>

<!-- Estilos personalizados -->
<style>
#map {
    transition: all 0.3s ease-in-out;
}
.card-title {
    font-weight: 600;
}
</style>

<!-- Hora en tiempo real -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const horaEl = document.getElementById("hora-actual");
    const actualizarHora = () => {
        const ahora = new Date();
        horaEl.textContent = `🕒 Hora local: ${ahora.toLocaleTimeString()}`;
    };
    actualizarHora();
    setInterval(actualizarHora, 1000);
});
</script>

<!-- Mapa interactivo con Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([14.0723, -87.1921], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    const buscarCoords = async (lugar) => {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(lugar)}`);
        const datos = await res.json();
        return datos.length > 0 ? [parseFloat(datos[0].lat), parseFloat(datos[0].lon)] : [14.0723, -87.1921];
    };

    (async () => {
        const coords = await buscarCoords(@json($ultimaUbicacion));
        map.setView(coords, 14);
        L.marker(coords).addTo(map).bindPopup("📍 Última ubicación del paquete").openPopup();
    })();
});
</script>
@endsection
