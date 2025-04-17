@extends('layouts.app') {{-- Asumiendo que tienes un layout llamado app.blade.php --}}

@section('content')
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <h1>Crear Nuevo Cliente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.guardar') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="Dni">DNI:</label>
            <input type="text" id="Dni" name="Dni" value="{{ old('Dni') }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="Nombres">Nombres:</label>
            <input type="text" id="Nombres" name="Nombres" value="{{ old('Nombres') }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="Apellidos">Apellidos:</label>
            <input type="text" id="Apellidos" name="Apellidos" value="{{ old('Apellidos') }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="PrimerTelefono">Primer Teléfono:</label>
            <input type="text" id="PrimerTelefono" name="PrimerTelefono" value="{{ old('PrimerTelefono') }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="SegundoTelefono">Segundo Teléfono (Opcional):</label>
            <input type="text" id="SegundoTelefono" name="SegundoTelefono" value="{{ old('SegundoTelefono') }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="PaisID">País:</label>
            <select id="PaisID" name="PaisID" class="form-control">
                <option value="">Seleccionar País</option>
                @foreach ($paises as $pais)
                    <option value="{{ $pais->CodPais }}">{{ $pais->Nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="EstadoID">Estado/Departamento:</label>
            <select id="EstadoID" name="EstadoID" class="form-control">
                <option value="">Seleccionar Estado/Departamento</option>
            </select>
        </div>

        <div class="form-group">
            <label for="CodMunicipio">Municipio/Ciudad:</label>
            <select id="CodMunicipio" name="CodMunicipio" class="form-control">
                <option value="">Seleccionar Municipio/Ciudad</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Direccion">Dirección:</label>
            <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paisSelect = document.getElementById('PaisID');
            const estadoSelect = document.getElementById('EstadoID');
            const municipioSelect = document.getElementById('CodMunicipio');
            const direccionInput = document.getElementById('Direccion');

            paisSelect.addEventListener('change', function () {
                const paisId = this.value;
                estadoSelect.innerHTML = '<option value="">Seleccionar Estado/Departamento</option>';
                municipioSelect.innerHTML = '<option value="">Seleccionar Municipio/Ciudad</option>';

                if (paisId) {
                    fetch(`/paises/${paisId}/estados`)  // Ruta para obtener estados
                        .then(response => response.json())
                        .then(estados => {
                            estados.forEach(estado => {
                                const option = document.createElement('option');
                                option.value = estado.CodEstado;
                                option.textContent = estado.NomEstado;
                                estadoSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error al cargar estados:', error));
                }
            });

            estadoSelect.addEventListener('change', function () {
                const estadoId = this.value;
                municipioSelect.innerHTML = '<option value="">Seleccionar Municipio/Ciudad</option>';

                if (estadoId) {
                    fetch(`/estados/${estadoId}/municipios`)  // Ruta para obtener municipios
                        .then(response => response.json())
                        .then(municipios => {
                            municipios.forEach(municipio => {
                                const option = document.createElement('option');
                                option.value = municipio.CodMunicipio;
                                option.textContent = municipio.NomMunicipio;
                                municipioSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error al cargar municipios:', error));
                }
            });

            municipioSelect.addEventListener('change', function () {
                const municipioId = this.value;
                if (municipioId) {
                    fetch(`/municipios/${municipioId}/direccion`)  // Ruta para obtener la dirección
                        .then(response => response.json())
                        .then(data => {
                            direccionInput.value = data.direccion || '';
                        })
                        .catch(error => console.error('Error al cargar la dirección:', error));
                } else {
                    direccionInput.value = '';
                }
            });
        });
    </script>
@endsection