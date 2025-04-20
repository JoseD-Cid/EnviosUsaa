@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <h1>Lista de Clientes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->Dni }}</td>
                        <td>{{ $cliente->Nombres }}</td>
                        <td>{{ $cliente->Apellidos }}</td>
                        <td>{{ $cliente->PrimerTelefono }}</td>
                        <td>{{ $cliente->SegundoTelefono ?? '-' }}</td>
                        <td>{{ $cliente->pais?->Nombre ?? '-' }}</td>
                        <td>{{ $cliente->estado?->NomEstado ?? '-' }}</td>
                        <td>{{ $cliente->Municipio?? '-' }}</td>
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
                @endforeach
            </tbody>
        </table>
    </div>
@endsection