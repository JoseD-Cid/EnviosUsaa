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
        @method('PUT') {{-- O @method('PATCH') si prefieres PATCH --}}

        <div class="form-group">
            <label for="Dni">DNI:</label>
            <input type="text" id="Dni" name="Dni" value="{{ old('Dni', $cliente->Dni) }}" required class="form-control">
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
            <label for="Direccion">Dirección:</label>
            <input type="text" id="Direccion" name="Direccion" value="{{ old('Direccion', $cliente->Direccion) }}" required class="form-control">
        </div>

        {{-- ... otros campos del formulario ... --}}

        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        <a href="{{ route('clientes.ver') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection