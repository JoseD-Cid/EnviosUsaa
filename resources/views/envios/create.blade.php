@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nuevo Envío</h2>
    <form action="{{ route('envios.store') }}" method="POST">
        @csrf

        <!-- Datos del envío -->
        <div class="mb-3">
            <label for="cliente_dni">Cliente</label>
            <select name="cliente_dni" id="cliente_dni" class="form-control" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->Dni }}">{{ $cliente->Dni }} - {{ $cliente->Nombres }} {{ $cliente->Apellidos }}</option>
                @endforeach
            </select>
            @error('cliente_dni')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fecha_envio">Fecha de Envío</label>
            <input type="date" name="fecha_envio" class="form-control" value="{{ old('fecha_envio') }}" required>
            @error('fecha_envio')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="destino_pais_id">País</label>
            <select name="destino_pais_id" id="destino_pais_id" class="form-control" required>
                <option value="">Seleccione un país</option>
                @foreach($paises as $pais)
                    <option value="{{ $pais->CodPais }}">{{ $pais->Nombre }}</option>
                @endforeach
            </select>
            @error('destino_pais_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="destino_estado_id">Estado/Depto</label>
            <select name="destino_estado_id" id="destino_estado_id" class="form-control" required>
                <option value="">Seleccione un estado</option>
            </select>
            @error('destino_estado_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ciudad_destino">Ciudad</label>
            <input type="text" name="ciudad_destino" class="form-control" value="{{ old('ciudad_destino') }}" required>
            @error('ciudad_destino')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="direccion_destino">Dirección</label>
            <input type="text" name="direccion_destino" class="form-control" value="{{ old('direccion_destino') }}" required>
            @error('direccion_destino')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="estatus_envio">Estatus</label>
            <select name="estatus_envio" class="form-control" required>
                <option value="pendiente" {{ old('estatus_envio') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en tránsito" {{ old('estatus_envio') == 'en tránsito' ? 'selected' : '' }}>En tránsito</option>
                <option value="entregado" {{ old('estatus_envio') == 'entregado' ? 'selected' : '' }}>Entregado</option>
            </select>
            @error('estatus_envio')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Paquetes -->
        <h4>Paquetes</h4>
        <div id="paquetes">
            <div class="paquete mb-3 border p-3 rounded">
                <div class="mb-3">
                    <label for="paquete_id">Seleccione un paquete</label>
                    <select name="paquetes[0][paquete_id]" class="form-control paquete-select" required>
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
                    <div class="col-md-6">
                        <label>Dimensiones</label>
                        <input type="text" class="form-control dimension-display" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Precio</label>
                        <input type="text" class="form-control precio-display" readonly>
                    </div>
                </div>
                <div class="mt-2">
                    <label for="descripcion">Descripción del contenido</label>
                    <textarea name="paquetes[0][descripcion]" class="form-control" required></textarea>
                </div>
            </div>
        </div>

        <button type="button" onclick="agregarPaquete()" class="btn btn-secondary mb-3">+ Añadir Paquete</button>

        <button type="submit" class="btn btn-primary">Guardar Envío</button>
    </form>
</div>

<script>
    // Cargar estados según el país seleccionado
    document.getElementById('destino_pais_id').addEventListener('change', function() {
        const paisId = this.value;
        const estadoSelect = document.getElementById('destino_estado_id');

        if (paisId) {
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
            .catch(error => console.error('Error fetching estados:', error));
        } else {
            estadoSelect.innerHTML = '<option value="">Seleccione un estado</option>';
        }
    });

    // Función para mostrar dimensiones y precio cuando se selecciona un paquete
    function actualizarInfoPaquete(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const row = selectElement.closest('.paquete');
        
        if (selectedOption.value) {
            const dimension = selectedOption.getAttribute('data-dimension');
            const precio = selectedOption.getAttribute('data-precio');
            
            row.querySelector('.dimension-display').value = dimension;
            row.querySelector('.precio-display').value = '$' + precio;
        } else {
            row.querySelector('.dimension-display').value = '';
            row.querySelector('.precio-display').value = '';
        }
    }

    // Agregar event listeners a los selects de paquetes
    document.querySelectorAll('.paquete-select').forEach(select => {
        select.addEventListener('change', function() {
            actualizarInfoPaquete(this);
        });
    });

    let contador = 1;
    function agregarPaquete() {
        const container = document.getElementById('paquetes');
        const nuevo = document.createElement('div');
        nuevo.classList.add('paquete', 'mb-3', 'border', 'p-3', 'rounded');
        
        nuevo.innerHTML = `
            <div class="mb-3">
                <label for="paquete_id">Seleccione un paquete</label>
                <select name="paquetes[${contador}][paquete_id]" class="form-control paquete-select" required>
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
                <div class="col-md-6">
                    <label>Dimensiones</label>
                    <input type="text" class="form-control dimension-display" readonly>
                </div>
                <div class="col-md-6">
                    <label>Precio</label>
                    <input type="text" class="form-control precio-display" readonly>
                </div>
            </div>
            <div class="mt-2">
                <label for="descripcion">Descripción del contenido</label>
                <textarea name="paquetes[${contador}][descripcion]" class="form-control" required></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 eliminar-paquete">Eliminar</button>
        `;
        
        container.appendChild(nuevo);
        
        // Agregar event listener al nuevo select
        const nuevoSelect = nuevo.querySelector('.paquete-select');
        nuevoSelect.addEventListener('change', function() {
            actualizarInfoPaquete(this);
        });
        
        // Agregar event listener al botón eliminar
        const eliminarBtn = nuevo.querySelector('.eliminar-paquete');
        eliminarBtn.addEventListener('click', function() {
            container.removeChild(nuevo);
        });
        
        contador++;
    }
</script>
@endsection
