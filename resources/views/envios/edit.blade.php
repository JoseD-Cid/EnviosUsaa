@extends('layouts.app')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    }
    .shipment-container {
        min-height: calc(100vh - 100px);
        padding: 20px;
        margin: 0 auto;
        max-width: 100%;
        box-sizing: border-box;
    }
    .shipment-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .shipment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    .shipment-card h2 {
        color: #003087;
        border-bottom: 3px solid #003087;
        padding-bottom: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        font-weight: 700;
        font-size: 1.75rem;
    }
    .shipment-card h2 i {
        margin-right: 12px;
        font-size: 1.5rem;
        color: #003087;
    }
    .form-label {
        font-weight: 500;
        color: #003087;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #003087;
        box-shadow: 0 0 5px rgba(0, 48, 135, 0.3);
    }
    .btn-primary {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
        background: linear-gradient(90deg, #003087 0%, #0052cc 100%);
        border: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #00205b 0%, #003087 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .btn-secondary {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 4px;
    }
    .is-invalid ~ .invalid-feedback {
        display: block;
    }
    .package-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background: #f9f9f9;
    }
    .remove-package {
        color: #dc3545;
        cursor: pointer;
        font-size: 0.9rem;
    }
    .remove-package:hover {
        text-decoration: underline;
    }
    @media (max-width: 768px) {
        .shipment-card h2 {
            font-size: 1.5rem;
        }
        .form-control, .form-select {
            font-size: 0.9rem;
        }
        .btn-primary {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="shipment-container">
    <div class="shipment-card">
        <h2>
            <i class="bi bi-truck"></i> Editar Envío
        </h2>

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('envios.update', $envio) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Remitente -->
            <div class="mb-4">
                <label class="form-label">Remitente (Cliente):</label>
                <select name="cliente_dni" class="form-select" required>
                    <option value="" disabled>Selecciona un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->Dni }}" {{ $envio->cliente_dni == $cliente->Dni ? 'selected' : '' }}>
                            {{ $cliente->Nombres }} {{ $cliente->Apellidos }} (DNI: {{ $cliente->Dni }})
                        </option>
                    @endforeach
                </select>
                @error('cliente_dni')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Destinatario -->
            <div class="mb-4">
                <label class="form-label">Destinatario:</label>
                <select name="cliente_destino_dni" class="form-select" required>
                    <option value="" disabled>Selecciona un destinatario</option>
                    @foreach($clientes_destino as $clienteDestino)
                        <option value="{{ $clienteDestino->Dni }}" {{ $envio->cliente_destino_dni == $clienteDestino->Dni ? 'selected' : '' }}>
                            {{ $clienteDestino->Nombres }} {{ $clienteDestino->Apellidos }} (DNI: {{ $clienteDestino->Dni }})
                        </option>
                    @endforeach
                </select>
                @error('cliente_destino_dni')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Fecha de Envío -->
            <div class="mb-4">
                <label class="form-label">Fecha de Envío:</label>
                <input type="date" name="fecha_envio" class="form-control" required value="{{ $envio->fecha_envio }}">
                @error('fecha_envio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tracking Number -->
            <div class="mb-4">
                <label class="form-label">Número de Tracking:</label>
                <input type="text" name="tracking_number" class="form-control" required value="{{ $envio->tracking_number }}" placeholder="Ej: TRK12345">
                @error('tracking_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Destino -->
            <div class="mb-4">
                <label class="form-label">País de Destino:</label>
                <select name="destino_pais_id" id="paisSelect" class="form-select" required>
                    <option value="" disabled>Selecciona un país</option>
                    @foreach($paises as $pais)
                        <option value="{{ $pais->CodPais }}" {{ $envio->destino_pais_id == $pais->CodPais ? 'selected' : '' }}>
                            {{ $pais->Nombre }}
                        </option>
                    @endforeach
                </select>
                @error('destino_pais_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Estado de Destino:</label>
                <select name="destino_estado_id" id="estadoSelect" class="form-select" required>
                    <option value="" disabled selected>Selecciona un estado</option>
                </select>
                @error('destino_estado_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Ciudad de Destino:</label>
                <input type="text" name="ciudad_destino" class="form-control" required value="{{ $envio->ciudad_destino }}" placeholder="Ej: San Marcos de Colón">
                @error('ciudad_destino')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Dirección de Destino:</label>
                <input type="text" name="direccion_destino" class="form-control" required value="{{ $envio->direccion_destino }}" placeholder="Ej: Barrio El Centro">
                @error('direccion_destino')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Estado del Envío -->
            <div class="mb-4">
                <label class="form-label">Estado del Envío:</label>
                <select name="estatus_envio" class="form-select" required>
                    <option value="registrado" {{ $envio->estatus_envio == 'registrado' ? 'selected' : '' }}>Registrado</option>
                    <option value="en_transito" {{ $envio->estatus_envio == 'en_transito' ? 'selected' : '' }}>En Tránsito</option>
                    <option value="en_aduanas" {{ $envio->estatus_envio == 'en_aduanas' ? 'selected' : '' }}>En Aduanas</option>
                    <option value="entregado" {{ $envio->estatus_envio == 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
                @error('estatus_envio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Paquetes -->
            <div class="mb-4">
                <label class="form-label">Paquetes:</label>
                <div id="packagesContainer">
                    @foreach($envio->paquetes as $index => $paquete)
                        <div class="package-item mb-3" data-index="{{ $index }}">
                            <div class="mb-2">
                                <label class="form-label">Paquete:</label>
                                <select name="paquetes[]" class="form-select" required>
                                    <option value="" disabled>Selecciona un paquete</option>
                                    @foreach($paquetes as $p)
                                        <option value="{{ $p->PaqueteId }}" {{ $paquete->PaqueteId == $p->PaqueteId ? 'selected' : '' }}>
                                            {{ $p->NombrePaquete }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descripción:</label>
                                <input type="text" name="descriptions[]" class="form-control" value="{{ $paquete->pivot->descripcion }}" placeholder="Ej: Ropa">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Precio:</label>
                                <input type="number" name="prices[]" class="form-control" required value="{{ $paquete->pivot->precio }}" step="0.01" min="0">
                            </div>
                            <div>
                                <span class="remove-package">Eliminar Paquete</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addPackage" class="btn btn-secondary">Agregar Paquete</button>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('envios.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Envío</button>
            </div>
        </form>
    </div>
</div>

<script>
// Preload states into a JavaScript variable
const allStates = @json($estados);
const selectedEstadoId = @json($envio->destino_estado_id);

// Dynamic package addition
document.addEventListener('DOMContentLoaded', function () {
    const addPackageBtn = document.getElementById('addPackage');
    const packagesContainer = document.getElementById('packagesContainer');
    let packageIndex = packagesContainer.querySelectorAll('.package-item').length;

    addPackageBtn.addEventListener('click', function () {
        const packageHtml = `
            <div class="package-item mb-3" data-index="${packageIndex}">
                <div class="mb-2">
                    <label class="form-label">Paquete:</label>
                    <select name="paquetes[]" class="form-select" required>
                        <option value="" disabled selected>Selecciona un paquete</option>
                        @foreach($paquetes as $paquete)
                            <option value="{{ $paquete->PaqueteId }}">{{ $paquete->NombrePaquete }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Descripción:</label>
                    <input type="text" name="descriptions[]" class="form-control" placeholder="Ej: Ropa">
                </div>
                <div class="mb-2">
                    <label class="form-label">Precio:</label>
                    <input type="number" name="prices[]" class="form-control" required step="0.01" min="0">
                </div>
                <div>
                    <span class="remove-package">Eliminar Paquete</span>
                </div>
            </div>
        `;
        packagesContainer.insertAdjacentHTML('beforeend', packageHtml);
        packageIndex++;
    });

    packagesContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-package')) {
            e.target.closest('.package-item').remove();
        }
    });

    // Dynamic state loading based on country
    const paisSelect = document.getElementById('paisSelect');
    const estadoSelect = document.getElementById('estadoSelect');

    function populateStates(paisId) {
        estadoSelect.innerHTML = '<option value="" disabled selected>Selecciona un estado</option>';
        
        if (paisId) {
            const filteredStates = allStates.filter(state => state.CodPais == paisId);
            filteredStates.forEach(state => {
                const option = document.createElement('option');
                option.value = state.CodEstado;
                option.textContent = state.NomEstado;
                if (state.CodEstado == selectedEstadoId) {
                    option.selected = true;
                }
                estadoSelect.appendChild(option);
            });
        }
    }

    paisSelect.addEventListener('change', function () {
        const paisId = this.value;
        populateStates(paisId);
    });

    // Trigger change event on page load to populate states
    const initialPaisId = paisSelect.value;
    if (initialPaisId) {
        populateStates(initialPaisId);
    }
});
</script>
@endsection