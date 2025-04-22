@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Nuevo Rol</h1>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" id="name" name="name" required>
            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Permisos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($permissions as $permission)
                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->name }}" 
                                    id="permission-{{ $permission->id }}"
                                >
                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Crear Rol</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection