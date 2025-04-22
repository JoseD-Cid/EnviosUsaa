@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Roles para {{ $user->name }}</h1>

    <form action="{{ route('roles.update-user', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                @foreach($roles as $role)
                    <div class="form-check mb-3">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="roles[]" 
                            value="{{ $role->name }}" 
                            id="role-{{ $role->id }}"
                            {{ $user->hasRole($role->name) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="role-{{ $role->id }}">
                            {{ ucfirst($role->name) }}
                        </label>
                        <small class="d-block text-muted">
                            @foreach($role->permissions as $permission)
                                <span class="badge bg-secondary">{{ $permission->name }}</span>
                            @endforeach
                        </small>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection