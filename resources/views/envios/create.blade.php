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
            <label for="tracking_number">Tracking</label>
            <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number') }}" required>
            @error('tracking_number')
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
                <input type="text" name="paquetes[0][descripcion]" placeholder="Descripción" class="form-control mb-2" value="{{ old('paquetes.0.descripcion') }}" required>
                <input type="number" name="paquetes[0][peso]" placeholder="Peso (g)" class="form-control mb-2" value="{{ old('paquetes.0.peso') }}" required>
                <input type="number" name="paquetes[0][valor_declarado]" placeholder="Valor Declarado" class="form-control" value="{{ old('paquetes.0.valor_declarado') }}" required>
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

    let contador = 1;
    function agregarPaquete() {
        const container = document.getElementById('paquetes');
        const nuevo = document.createElement('div');
        nuevo.classList.add('paquete', 'mb-3', 'border', 'p-3', 'rounded');
        nuevo.innerHTML = `
            <input type="text" name="paquetes[${contador}][descripcion]" placeholder="Descripción" class="form-control mb-2" required>
            <input type="number" name="paquetes[${contador}][peso]" placeholder="Peso (g)" class="form-control mb-2" required>
            <input type="number" name="paquetes[${contador}][valor_declarado]" placeholder="Valor Declarado" class="form-control" required>
        `;
        container.appendChild(nuevo);
        contador++;
    }
</script>
@endsection
