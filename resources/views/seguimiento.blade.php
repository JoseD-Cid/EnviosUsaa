@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <!-- Encabezado -->
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Seguimiento de Envío</h4>
        </div>

        <!-- Contenido -->
        <div class="card-body">
            <!-- Búsqueda -->
            <form method="GET" class="mb-5">
                <div class="input-group">
                    <input type="text" name="tracking_number" 
                           class="form-control" 
                           placeholder="Ingresa tu código de tracking"
                           value="{{ $trackingNumber ?? '' }}"
                           required>
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>

            <!-- Resultados -->
            @if($envio)

                <!-- Estado Actual -->
                <div class="alert alert-{{ $envio->estatus_envio == 'entregado' ? 'success' : 'primary' }}">
                    <h5>Estado Actual: {{ ucfirst(str_replace('_', ' ', $envio->estatus_envio)) }}</h5>
                </div>

                <!-- Línea de Tiempo -->
                @php
                    function getEstadoColor($estado) {
                        return match($estado) {
                            'pendiente' => 'warning',
                            'en_transito' => 'primary',
                            'en_aduana' => 'info',
                            'entregado' => 'success',
                            default => 'secondary'
                        };
                    }

                    function getEstadoIcon($estado) {
                        return match($estado) {
                            'pendiente' => '⏳',
                            'en_transito' => '🚚',
                            'en_aduana' => '📦',
                            'entregado' => '✅',
                            default => '🔘'
                        };
                    }
                @endphp

                <div class="timeline">
                    @foreach($envio->trackingHistory as $historial)
                        @php
                            $color = getEstadoColor($historial->estado);
                            $icon = getEstadoIcon($historial->estado);
                        @endphp
                        <div class="timeline-item">
                            <div class="timeline-marker bg-{{ $color }}">{{ $icon }}</div>
                            <div class="timeline-content">
                                <h6 class="mb-1">
                                    <strong>{{ $historial->created_at->format('h:i A') }}</strong> - 
                                    {{ ucfirst(str_replace('_', ' ', $historial->estado)) }}
                                </h6>
                                <p class="mb-1">{{ $historial->descripcion }}</p>
                                <p class="text-muted mb-0">{{ $historial->ubicacion }}</p>
                                <small class="text-muted">{{ $historial->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mensaje especial si ya fue entregado -->
                @if($envio->estatus_envio == 'entregado')
                    <div class="alert alert-success text-center mt-4">
                        <h5 class="mb-0">🎉 ¡Tu paquete ha sido entregado con éxito!</h5>
                        <p class="mb-0">Gracias por confiar en nosotros. 📦✨</p>
                    </div>
                @endif

            @elseif($trackingNumber)
                <div class="alert alert-danger">
                    No se encontró el envío: <strong>{{ $trackingNumber }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Estilos para la línea de tiempo -->
<style>
.timeline {
    position: relative;
    padding-left: 30px;
    border-left: 2px solid #007bff;
    margin-top: 20px;
}
.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 20px;
}
.timeline-marker {
    position: absolute;
    left: -18px;
    top: 0;
    width: 30px;
    height: 30px;
    font-size: 16px;
    background-color: #ccc;
    border-radius: 50%;
    color: white;
    text-align: center;
    line-height: 30px;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #ccc;
}

/* Colores personalizados */
.timeline-marker.bg-warning { background-color: #ffc107; box-shadow: 0 0 0 2px #ffc107; }
.timeline-marker.bg-primary { background-color: #007bff; box-shadow: 0 0 0 2px #007bff; }
.timeline-marker.bg-info    { background-color: #17a2b8; box-shadow: 0 0 0 2px #17a2b8; }
.timeline-marker.bg-success { background-color: #28a745; box-shadow: 0 0 0 2px #28a745; }
.timeline-marker.bg-secondary { background-color: #6c757d; box-shadow: 0 0 0 2px #6c757d; }

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
</style>
@endsection
