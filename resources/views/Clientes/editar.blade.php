@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <h1>Editar Cliente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.actualizar', $cliente->Dni) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="Dni">DNI:</label>
            <input type="text" id="Dni" name="Dni" value="{{ old('Dni', $cliente->Dni) }}" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="Nombres">Nombres:</label>
            <input type="text" id="Nombres" name="Nombres" value="{{ old('Nombres', $cliente->Nombres) }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="Apellidos">Apellidos:</label>
            <input type="text" id="Apellidos" name="Apellidos" value="{{ old('Apellidos', $cliente->Apellidos) }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="PrimerTelefono">Primer Teléfono:</label>
            <input type="text" id="PrimerTelefono" name="PrimerTelefono" value="{{ old('PrimerTelefono', $cliente->PrimerTelefono) }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="SegundoTelefono">Segundo Teléfono (Opcional):</label>
            <input type="text" id="SegundoTelefono" name="SegundoTelefono" value="{{ old('SegundoTelefono', $cliente->SegundoTelefono) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="PaisID">País:</label>
            <select id="PaisID" name="PaisID" class="form-control" required>
                <option value="">Seleccionar País</option>
                @foreach ($paises as $pais)
                    <option value="{{ $pais->CodPais }}" {{ old('PaisID', $cliente->estado ? $cliente->estado->CodPais : '') == $pais->CodPais ? 'selected' : '' }}>{{ $pais->Nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="EstadoID">Estado/Departamento:</label>
            <select id="EstadoID" name="EstadoID" class="form-control" required>
                <option value="">Seleccionar Estado/Departamento</option>
                @if (old('PaisID', $cliente->estado ? $cliente->estado->CodPais : ''))
                    @foreach ($estados->where('CodPais', old('PaisID', $cliente->estado ? $cliente->estado->CodPais : '')) as $estado)
                        <option value="{{ $estado->CodEstado }}" {{ old('EstadoID', $cliente->EstadoID) == $estado->CodEstado ? 'selected' : '' }}>{{ $estado->NomEstado }}</option>
                    @endforeach
                @elseif ($cliente->EstadoID)
                    @foreach ($estados->where('CodPais', $cliente->estado->CodPais) as $estado)
                        <option value="{{ $estado->CodEstado }}" {{ $cliente->EstadoID == $estado->CodEstado ? 'selected' : '' }}>{{ $estado->NomEstado }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="Municipio">Municipio/Ciudad:</label>
            <input type="text" id="Municipio" name="Municipio" value="{{ old('Municipio', $cliente->Municipio) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Direccion">Dirección:</label>
            <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion', $cliente->Direccion) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        <a href="{{ route('clientes.ver') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paisSelect = document.getElementById('PaisID');
            const estadoSelect = document.getElementById('EstadoID');

            function loadEstados(paisId, selectedEstadoId = null) {
                estadoSelect.innerHTML = '<option value="">Seleccionar Estado/Departamento</option>';
                if (paisId) {
                    fetch(`/paises/${paisId}/estados`)
                        .then(response => response.json())
                        .then(estados => {
                            estados.forEach(estado => {
                                const option = document.createElement('option');
                                option.value = estado.CodEstado;
                                option.textContent = estado.NomEstado;
                                if (selectedEstadoId === estado.CodEstado) {
                                    option.selected = true;
                                }
                                estadoSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error al cargar estados:', error));
                }
            }

            paisSelect.addEventListener('change', function () {
                const paisId = this.value;
                loadEstados(paisId);
            });

            // Cargar estados iniciales al cargar la página (si hay un país seleccionado)
            const initialPaisId = paisSelect.value;
            const initialEstadoId = "{{ old('EstadoID', $cliente->EstadoID) }}";
            if (initialPaisId) {
                loadEstados(initialPaisId, initialEstadoId);
            }
        });
    </script>
@endsection