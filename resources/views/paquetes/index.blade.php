@extends('layouts.app')

@section('content')
<style>
    .package-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-section {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .card-section h2 {
        color: #003087;
        border-bottom: 2px solid #003087;
        padding-bottom: 5px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .card-section h2 i {
        margin-right: 10px;
    }
    .table thead {
        background-color: #003087;
        color: white;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 48, 135, 0.05);
    }
    .table tbody tr:hover {
        background-color: rgba(0, 48, 135, 0.1);
    }
    .btn-action {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
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
    .precio {
        font-weight: bold;
        color: #003087;
    }
    .filter-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f1f3f5;
        border-radius: 8px;
    }
</style>

<div class="container package-container">
    <div class="card-section">
        <h2><i class="bi bi-box-seam"></i> Gestión de Paquetes</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('paquetes.create') }}" class="btn btn-custom-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Paquete
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Dashboard
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dimensiones</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paquetes as $paquete)
                        <tr>
                            <td>{{ $paquete->PaqueteId }}</td>
                            <td>{{ $paquete->NombrePaquete }}</td>
                            <td>{{ $paquete->dimension }}</td>
                            <td class="precio">${{ number_format($paquete->precio, 2) }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('paquetes.show', $paquete->PaqueteId) }}" class="btn btn-info btn-action">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('paquetes.edit', $paquete->PaqueteId) }}" class="btn btn-primary btn-action">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('paquetes.destroy', $paquete->PaqueteId) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-action" 
                                            onclick="return confirm('¿Está seguro de eliminar este paquete?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay paquetes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection