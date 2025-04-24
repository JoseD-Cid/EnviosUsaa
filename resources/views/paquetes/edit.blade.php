@extends('layouts.app')

@section('content')
<style>
    .package-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-section {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .card-section h2 {
        color: #003087;
        border-bottom: 2px solid #003087;
        padding-bottom: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    .card-section h2 i {
        margin-right: 10px;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .form-control:focus {
        border-color: #003087;
        box-shadow: 0 0 0 0.2rem rgba(0, 48, 135, 0.25);
    }
    .btn-custom-primary {
        background-color: #003087;
        border-color: #003087;
        color: white;
    }
    .btn-custom-primary:hover {
        background-color: #002366;
        border-color: #002366;
        color: white;
    }
    .required::after {
        content: " *";
        color: red;
    }
    .input-group-text {
        background-color: #f0f0f0;
    }
    .package-id {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>

<div class="container package-form">
    <div class="card-section">
        <h2><i class="bi bi-box-seam"></i> Editar Paquete</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('paquetes.update', $paquete->PaqueteId) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="PaqueteId" class="form-label">ID del Paquete</label>
                <input type="text" class="form-control package-id" id="PaqueteId" value="{{ $paquete->PaqueteId }}" readonly>
                <small class="form-text text-muted">El ID no puede ser modificado</small>
            </div>

            <div class="mb-3">
                <label for="NombrePaquete" class="form-label required">Nombre del Paquete</label>
                <input type="text" class="form-control" id="NombrePaquete" name="NombrePaquete" 
                       value="{{ old('NombrePaquete', $paquete->NombrePaquete) }}" required>
            </div>

            <div class="mb-3">
                <label for="dimension" class="form-label required">Dimensiones</label>
                <input type="text" class="form-control" id="dimension" name="dimension" 
                       value="{{ old('dimension', $paquete->dimension) }}" required>
                <small class="form-text text-muted">Ejemplo: 30x20x15 cm, 45x30x20 cm, etc.</small>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label required">Precio</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="precio" name="precio" 
                           value="{{ old('precio', $paquete->precio) }}" step="0.01" min="0" required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-custom-primary">
                    <i class="bi bi-save"></i> Actualizar Paquete
                </button>
                <a href="{{ route('paquetes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection