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
    .card-section h4 {
        color: #003087;
        border-bottom: 2px solid #003087;
        padding-bottom: 5px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .card-section h4 i {
        margin-right: 10px;
    }
    .form-label {
        font-weight: 600;
        color: #333;
    }
    .form-control, .form-select {
        border-radius: 5px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #003087;
        box-shadow: 0 0 5px rgba(0, 48, 135, 0.3);
    }
    .btn-primary {
        background-color: #003087;
        border-color: #003087;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #00205b;
        border-color: #00205b;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }
    .paquete {
        background-color: #f1f3f5;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
    .text-danger {
        font-size: 0.875em;
    }
</style>

<div class="container shipment-form">
    <h2 class="text-center mb-4">Registrar Nuevo Envío</h2>
    <form action="{{ route('envios.store') }}" method="POST">
        @csrf

        <!-- Datos del Cliente Remitente -->
        <div class="card-section">
            <h4><i class="bi bi-person"></i> Cliente Remitente</h4>
            <div class="mb-3">
                <label for="cliente_dni" class="form-label">Cliente</label>
                <select name="cliente_dni" id="cliente_dni" class="form-select" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->Dni }}">{{ $cliente->Dni }} - {{ $cliente->Nombres }} {{ $cliente->Apellidos }}</option>
                    @endforeach
                </select>
                @error('cliente_dni')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Datos del Cliente Destinatario -->
        <div class="card-section">
            <h4><i class="bi bi-person-add"></i> Cliente Destinatario</h4>
            <div class="mb-3">
                <label for="cliente_destino_option" class="form-label">Seleccione una opción</label>
                <select name="cliente_destino_option" id="cliente_destino_option" class="form-select">
                    <option value="existing">Seleccionar cliente existente</option>
                    <option value="new">Crear nuevo cliente</option>
                </select>
            </div>

            <!-- Cliente Destinatario Existente -->
            <div id="existing-cliente-destino" class="mb-3">
                <label for="cliente_destino_dni" class="form-label">Cliente Destinatario</label>
                <select name="cliente_destino_dni" id="cliente_destino_dni" class="form-select">
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes_destino as $cliente)
                        <option value="{{ $cliente->Dni }}">{{ $cliente->Dni }} - {{ $cliente->Nombres }} {{ $cliente->Apellidos }}</option>
                    @endforeach
                </select>
                @error('cliente_destino_dni')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Crear Nuevo Cliente Destinatario -->
            <div id="new-cliente-destino" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nuevo_destino_dni" class="form-label">DNI</label>
                        <input type="text" name="nuevo_destino_dni" id="nuevo_destino_dni" class="form-control" value="{{ old('nuevo_destino_dni') }}">
                        @error('nuevo_destino_dni')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nuevo_destino_nombres" class="form-label">Nombres</label>
                        <input type="text" name="nuevo_destino_nombres" id="nuevo_destino_nombres" class="form-control" value="{{ old('nuevo_destino_nombres') }}">
                        @error('nuevo_destino_nombres')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nuevo_destino_apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="nuevo_destino_apellidos" id="nuevo_destino_apellidos" class="form-control" value="{{ old('nuevo_destino_apellidos') }}">
                        @error('nuevo_destino_apellidos')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nuevo_destino_telefono" class="form-label">Teléfono</label>
                        <input type="text" name="nuevo_destino_telefono" id="nuevo_destino_telefono" class="form-control" value="{{ old('nuevo_destino_telefono') }}">
                        @error('nuevo_destino_telefono')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nuevo_destino_email" class="form-label">Email</label>
                    <input type="email" name="nuevo_destino_email" id="nuevo_destino_email" class="form-control" value="{{ old('nuevo_destino_email') }}">
                    @error('nuevo_destino_email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Dirección del Cliente Destinatario -->
        <div class="card-section">
            <h4><i class="bi bi-geo-alt"></i> Dirección de Destino</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="destino_pais_id" class="form-label">País</label>
                    <select name="destino_pais_id" id="destino_pais_id" class="form-select" required>
                        <option value="">Seleccione un país</option>
                        @foreach($paises as $pais)
                            <option value="{{ $pais->CodPais }}">{{ $pais->Nombre }}</option>
                        @endforeach
                    </select>
                    @error('destino_pais_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="destino_estado_id" class="form-label">Estado/Depto</label>
                    <select name="destino_estado_id" id="destino_estado_id" class="form-select" required>
                        <option value="">Seleccione un estado</option>
                    </select>
                    @error('destino_estado_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ciudad_destino" class="form-label">Ciudad</label>
                    <input type="text" name="ciudad_destino" class="form-control" value="{{ old('ciudad_destino') }}" required>
                    @error('ciudad_destino')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="direccion_destino" class="form-label">Dirección</label>
                    <input type="text" name="direccion_destino" class="form-control" value="{{ old('direccion_destino') }}" required>
                    @error('direccion_destino')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Datos del Envío -->
        <div class="card-section">
            <h4><i class="bi bi-truck"></i> Datos del Envío</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_envio" class="form-label">Fecha de Envío</label>
                    <input type="date" name="fecha_envio" class="form-control" value="{{ old('fecha_envio') }}" required>
                    @error('fecha_envio')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estatus_envio" class="form-label">Estatus</label>
                    <select name="estatus_envio" class="form-select" required>
                        <option value="pendiente" {{ old('estatus_envio') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en tránsito" {{ old('estatus_envio') == 'en tránsito' ? 'selected' : '' }}>En tránsito</option>
                        <option value="entregado" {{ old('estatus_envio') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    @error('estatus_envio')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Paquetes -->
        <div class="card-section">
            <h4><i class="bi bi-box-seam"></i> Paquetes</h4>
            <div id="paquetes">
                <div class="paquete mb-3">
                    <div class="mb-3">
                        <label for="paquete_id" class="form-label">Seleccione un paquete</label>
                        <select name="paquetes[0][paquete_id]" class="form-select paquete-select" required>
                            <option value="">Seleccione un paquete</option>
                            @foreach($paquetes as $paquete)
                                <option value="{{ $paquete->PaqueteId }}" 
                                        data-dimension="{{ $paquete->dimension }}" 
                                        data-precio="{{ $paquete->precio }}">
                                    {{ $paquete->NombrePaquete }} ({{ $paquete->dimension }}) - ${{ $paquete->precio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dimensiones</label>
                            <input type="text" class="form-control dimension-display" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Precio</label>
                            <input type="text" class="form-control precio-display" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del contenido</label>
                        <textarea name="paquetes[0][descripcion]" class="form-control" required></textarea>
                    </div>
                </div>
            </div>
            <button type="button" onclick="agregarPaquete()" class="btn btn-secondary mb-3"><i class="bi bi-plus-circle"></i> Añadir Paquete</button>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Envío</button>
        </div>
    </form>
</div>

<script>
    // Toggle between existing and new destination client
    document.getElementById('cliente_destino_option').addEventListener('change', function() {
        const existingSection = document.getElementById('existing-cliente-destino');
        const newSection = document.getElementById('new-cliente-destino');
        const clienteDestinoDni = document.getElementById('cliente_destino_dni');
        const nuevoDestinoDni = document.getElementById('nuevo_destino_dni');
        const nuevoDestinoNombres = document.getElementById('nuevo_destino_nombres');
        const nuevoDestinoApellidos = document.getElementById('nuevo_destino_apellidos');

        if (this.value === 'existing') {
            existingSection.style.display = 'block';
            newSection.style.display = 'none';
            clienteDestinoDni.setAttribute('required', 'required');
            clienteDestinoDni.disabled = false; // Enable the field
            nuevoDestinoDni.removeAttribute('required');
            nuevoDestinoNombres.removeAttribute('required');
            nuevoDestinoApellidos.removeAttribute('required');
        } else {
            existingSection.style.display = 'none';
            newSection.style.display = 'block';
            clienteDestinoDni.removeAttribute('required');
            clienteDestinoDni.value = ''; // Clear the value
            clienteDestinoDni.disabled = true; // Disable the field to prevent submission
            nuevoDestinoDni.setAttribute('required', 'required');
            nuevoDestinoNombres.setAttribute('required', 'required');
            nuevoDestinoApellidos.setAttribute('required', 'required');
        }
    });

    // Cargar estados según el país seleccionado
    document.getElementById('destino_pais_id').addEventListener('change', function() {
        const paisId = this.value;
        const estadoSelect = document.getElementById('destino_estado_id');
        estadoSelect.innerHTML = '<option value="">Cargando...</option>';

        fetch(`/estados-por-pais/${paisId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            estadoSelect.innerHTML = '<option value="">Seleccione un estado</option>';
            data.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.CodEstado;
                option.textContent = estado.NomEstado;
                estadoSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar estados:', error);
            estadoSelect.innerHTML = '<option value="">Error al cargar</option>';
        });
    });

    // Mostrar dimensiones y precio del paquete
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('paquete-select')) {
            const selected = e.target.selectedOptions[0];
            const dimension = selected.dataset.dimension || '';
            const precio = selected.dataset.precio || '';
            const parent = e.target.closest('.paquete');
            parent.querySelector('.dimension-display').value = dimension;
            parent.querySelector('.precio-display').value = precio;
        }
    });

    // Agregar nuevo paquete dinámicamente
    let paqueteIndex = 1;
    function agregarPaquete() {
        const paqueteHTML = `
        <div class="paquete mb-3">
            <div class="mb-3">
                <label for="paquete_id" class="form-label">Seleccione un paquete</label>
                <select name="paquetes[${paqueteIndex}][paquete_id]" class="form-select paquete-select" required>
                    <option value="">Seleccione un paquete</option>
                    @foreach($paquetes as $paquete)
                        <option value="{{ $paquete->PaqueteId }}" 
                                data-dimension="{{ $paquete->dimension }}" 
                                data-precio="{{ $paquete->precio }}">
                            {{ $paquete->NombrePaquete }} ({{ $paquete->dimension }}) - ${{ $paquete->precio }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dimensiones</label>
                    <input type="text" class="form-control dimension-display" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio</label>
                    <input type="text" class="form-control precio-display" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción del contenido</label>
                <textarea name="paquetes[${paqueteIndex}][descripcion]" class="form-control" required></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm eliminar-paquete">Eliminar</button>
        </div>`;
        document.getElementById('paquetes').insertAdjacentHTML('beforeend', paqueteHTML);
        
        // Agregar event listener al botón eliminar
        document.querySelectorAll('.eliminar-paquete').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.paquete').remove();
            });
        });
        
        paqueteIndex++;
    }
</script>
@endsection