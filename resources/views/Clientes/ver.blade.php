{{-- resources/views/clientes/ver.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="bi bi-people-fill me-2 text-primary"></i>
                Lista de Clientes
            </h3>
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Regresar
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('clientes.ver') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Buscar por Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ request('nombre') }}">
                </div>
                <div class="col-md-4">
                    <label for="pais" class="form-label">Filtrar por País</label>
                    <select name="pais" id="pais" class="form-select">
                        <option value="">Todos los Países</option>
                        @foreach($paises as $pais)
                            <option value="{{ $pais->CodPais }}" {{ request('pais')==$pais->CodPais ? 'selected':'' }}>
                                {{ $pais->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="estado" class="form-label">Filtrar por Estado</label>
                    <select name="estado" id="estado" class="form-select">
                        <option value="">Todos los Estados</option>
                        @if(request('pais'))
                            @foreach($estados->where('CodPais', request('pais')) as $estado)
                                <option value="{{ $estado->CodEstado }}" {{ request('estado')==$estado->CodEstado ? 'selected':'' }}>
                                    {{ $estado->NomEstado }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter-circle-fill me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('clientes.ver') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle-fill me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de Clientes --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>País / Estado</th>
                            <th>Dirección</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $c)
                            <tr>
                                <td>{{ $c->Dni }}</td>
                                <td>{{ $c->Nombres }} {{ $c->Apellidos }}</td>
                                <td>{{ $c->PrimerTelefono }}{{ $c->SegundoTelefono ? ' / '.$c->SegundoTelefono : '' }}</td>
                                <td>
                                    {{ optional($c->estado?->pais)->Nombre ?? '-' }}
                                    <br>
                                    <small class="text-muted">{{ $c->estado?->NomEstado ?? '-' }}</small>
                                </td>
                                <td>{{ $c->Direccion ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('clientes.editar', $c->Dni) }}"
                                       class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('clientes.eliminar', $c->Dni) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Eliminar cliente?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No se encontraron clientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $clientes->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
