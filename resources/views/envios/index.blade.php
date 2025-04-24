@extends('layouts.app')

@section('content')
<style>
    .shipment-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-section {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .card-section h2 {
        color: #003087;
        border-bottom: 2px solid #003087;
        padding-bottom: 5px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .card-section h2 i {
        margin-right: 10px;
    }
    .table thead {
        background-color: #003087;
        color: white;
    }
    .table thead th {
        border: none;
    }
    .table tbody tr:hover {
        background-color: #f1f3f5;
    }
    .btn-primary, .btn-outline-primary {
        background-color: #003087;
        border-color: #003087;
        color: white;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover, .btn-outline-primary:hover {
        background-color: #00205b;
        border-color: #00205b;
        color: white;
    }
    .btn-outline-primary {
        background-color: transparent;
        color: #003087;
    }
    .btn-outline-primary:hover {
        background-color: #00205b;
        color: white;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
    .text-muted, .text-danger, .text-warning {
        font-size: 0.875em;
    }
</style>

<div class="container shipment-form">
    <div class="card-section">
        <h2><i class="bi bi-truck"></i> Listado de Envíos</h2>

        <!-- Mostrar mensaje de éxito si existe -->
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Botón para crear un nuevo envío -->
        <div class="mb-3">
            <a href="{{ route('envios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Registrar Nuevo Envío
            </a>
        </div>

        <!-- Tabla de envíos -->
        @if ($envios->isEmpty())
            <p>No hay envíos registrados.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tracking</th>
                        <th>Remitente</th>
                        <th>Destinatario</th>
                        <th>Destino</th>
                        <th>Paquetes</th>
                        <th>Estatus</th>
                        <th>Fecha Envío</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($envios as $envio)
                        <tr>
                            <td>{{ $envio->tracking_number }}</td>
                            <td>
                                @if($envio->cliente)
                                    {{ $envio->cliente->Nombres }} {{ $envio->cliente->Apellidos }}
                                    <br><small class="text-muted">DNI: {{ $envio->cliente->Dni }}</small>
                                @else
                                    <span class="text-danger">Cliente no encontrado</span>
                                @endif
                            </td>
                            <td>
                                @if($envio->clienteDestino)
                                    {{ $envio->clienteDestino->Nombres }} {{ $envio->clienteDestino->Apellidos }}
                                    <br><small class="text-muted">DNI: {{ $envio->cliente_destino_dni }}</small>
                                @else
                                    <span class="text-danger">Destinatario no encontrado</span>
                                @endif
                            </td>
                            <td>
                                @if($envio->destino_pais && $envio->destino_estado)
                                    <strong>{{ $envio->destino_pais->Nombre }}</strong> - {{ $envio->destino_estado->NomEstado }}
                                    <br>{{ $envio->ciudad_destino }}
                                    <br><small>{{ $envio->direccion_destino }}</small>
                                @else
                                    <span class="text-warning">Destino incompleto</span>
                                @endif
                            </td>
                            <td>
                                @forelse($envio->paquetes as $paquete)
                                    <div class="mb-2">
                                        <span class="badge bg-secondary">{{ $paquete->NombrePaquete }}</span>
                                        <div class="small">
                                            <strong>Descripción:</strong> {{ $paquete->pivot->descripcion }}<br>
                                            <strong>Dimensiones:</strong> {{ $paquete->dimension }}<br>
                                            <strong>Precio histórico:</strong> ${{ number_format($paquete->pivot->precio, 2) }}
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-muted">Sin paquetes</span>
                                @endforelse
                            </td>
                            <td>
                                <span class="badge bg-{{ $envio->estatus_envio == 'entregado' ? 'success' : 'primary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $envio->estatus_envio)) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($envio->fecha_envio)->format('d/m/Y') }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateStatusModal{{ $envio->id }}">
                                    <i class="bi bi-pencil-square"></i> Actualizar
                                </button>
                            </td>
                        </tr>

                        <!-- Modal de Actualización -->
                        <div class="modal fade" id="updateStatusModal{{ $envio->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Actualizar Estado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('envios.actualizar-estado', $envio) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nuevo Estado:</label>
                                                <select name="estado" class="form-select" required>
                                                    <option value="registrado" {{ $envio->estatus_envio == 'registrado' ? 'selected' : '' }}>Registrado</option>
                                                    <option value="en_transito" {{ $envio->estatus_envio == 'en_transito' ? 'selected' : '' }}>En Tránsito</option>
                                                    <option value="en_aduanas" {{ $envio->estatus_envio == 'en_aduanas' ? 'selected' : '' }}>En Aduanas</option>
                                                    <option value="entregado" {{ $envio->estatus_envio == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ubicación Actual:</label>
                                                <input type="text"
                                                       name="ubicacion"
                                                       class="form-control"
                                                       value="{{ $envio->trackingHistory->last()->ubicacion ?? '' }}"
                                                       required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Detalles:</label>
                                                <textarea name="descripcion"
                                                          class="form-control"
                                                          rows="3"
                                                          placeholder="Ej: Salió del centro de distribución">{{ $envio->trackingHistory->last()->descripcion ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection