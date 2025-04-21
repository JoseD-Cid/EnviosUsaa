{{-- resources/views/clientes/ver.blade.php --}}
@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">

    <h1>Lista de Clientes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="search-filters-container">
        <div class="form-group search-input">
            <label for="nombre">Buscar por Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ request('nombre') }}">
        </div>
        <div class="form-group filter-select">
            <label for="pais">Filtrar por País:</label>
            <select class="form-control" id="pais" name="pais">
                <option value="">Todos los Países</option>
                @foreach($paises as $pais)
                    <option value="{{ $pais->CodPais }}" {{ request('pais') == $pais->CodPais ? 'selected' : '' }}>{{ $pais->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group filter-select">
            <label for="estado">Filtrar por Estado:</label>
            <select class="form-control" id="estado" name="estado">
                <option value="">Todos los Estados</option>
                @if(request('pais'))
                    @foreach($estados->where('CodPais', request('pais')) as $estado)
                        <option value="{{ $estado->CodEstado }}" {{ request('estado') == $estado->CodEstado ? 'selected' : '' }}>{{ $estado->NomEstado }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('clientes.ver') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>DNI</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Primer Teléfono</th>
                    <th>Segundo Teléfono</th>
                    <th>País</th>
                    <th>Estado</th>
                    <th>Municipio</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->Dni }}</td>
                        <td>{{ $cliente->Nombres }}</td>
                        <td>{{ $cliente->Apellidos }}</td>
                        <td>{{ $cliente->PrimerTelefono }}</td>
                        <td>{{ $cliente->SegundoTelefono ?? '-' }}</td>
                        <td>{{ $cliente->estado?->pais?->Nombre ?? '-' }}</td>
                        <td>{{ $cliente->estado?->NomEstado ?? '-' }}</td>
                        <td>{{ $cliente->Municipio ?? '-' }}</td>
                        <td>{{ $cliente->Direccion ?? '-' }}</td>
                        <td>
                            <a href="{{ route('clientes.editar', ['dni' => $cliente->Dni]) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('clientes.eliminar', ['dni' => $cliente->Dni]) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center">No se encontraron clientes.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $clientes->links() }}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paisSelector = document.getElementById('pais');
            const estadoSelector = document.getElementById('estado');

            paisSelector.addEventListener('change', function() {
                const paisId = this.value;
                estadoSelector.innerHTML = '<option value="">Cargando Estados...</option>';

                if (paisId) {
                    fetch(`/paises/${paisId}/estados`)
                        .then(response => response.json())
                        .then(data => {
                            estadoSelector.innerHTML = '<option value="">Todos los Estados</option>';
                            data.forEach(estado => {
                                const option = document.createElement('option');
                                option.value = estado.CodEstado;
                                option.textContent = estado.NomEstado;
                                estadoSelector.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error al cargar los estados:', error);
                            estadoSelector.innerHTML = '<option value="">Error al cargar los estados</option>';
                        });
                } else {
                    estadoSelector.innerHTML = '<option value="">Todos los Estados</option>';
                }
            });
        });
    </script>
@endsection