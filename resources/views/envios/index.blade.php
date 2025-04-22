@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Envíos</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Tracking</th>
                <th>Cliente</th>
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
                    @if($envio->destino_pais && $envio->destino_estado)
                        <strong>{{ $envio->destino_pais->Nombre }}</strong> - {{ $envio->destino_estado->NomEstado }}
                        <br>{{ $envio->ciudad_destino }}
                        <br><small>{{ $envio->direccion_destino }}</small>
                    @else
                        <span class="text-warning">Destino incompleto</span>
                    @endif
                </td>

                <td>
                    @foreach($envio->paquetes as $paquete)
                        <div class="mb-2">
                            <span class="badge bg-secondary">{{ $paquete->descripcion }}</span>
                            <div class="small">
                                Peso: {{ $paquete->peso }}g<br>
                                Valor: ${{ number_format($paquete->valor_declarado, 2) }}
                            </div>
                        </div>
                    @endforeach
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
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
@endpush
