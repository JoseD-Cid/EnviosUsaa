@extends('layouts.app')

@section('content')
<style>
    .package-details {
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
    .package-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #003087;
    }
    .detail-label {
        font-weight: 600;
        color: #495057;
    }
    .detail-value {
        font-size: 1.1rem;
    }
    .package-icon {
        font-size: 3rem;
        color: #003087;
    }
    .price-badge {
        font-size: 1.2rem;
        background-color: #003087;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
    }
    .usage-card {
        background-color: #f1f3f5;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }
</style>

<div class="container package-details">
    <div class="card-section">
        <h2><i class="bi bi-box-seam"></i> Detalles del Paquete</h2>

        <div class="row mb-4">
            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                <i class="bi bi-box package-icon"></i>
            </div>
            <div class="col-md-7">
                <h3 class="package-title mb-3">{{ $paquete->NombrePaquete }}</h3>
                <div class="mb-2">
                    <span class="detail-label">ID:</span>
                    <span class="detail-value">{{ $paquete->PaqueteId }}</span>
                </div>
                <div class="mb-2">
                    <span class="detail-label">Dimensiones:</span>
                    <span class="detail-value">{{ $paquete->dimension }}</span>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-items-center justify-content-center">
                <span class="price-badge">
                    <i class="bi bi-tag-fill me-1"></i>${{ number_format($paquete->precio, 2) }}
                </span>
            </div>
        </div>

        <div class="usage-card">
            <h4><i class="bi bi-truck"></i> Uso en Envíos</h4>
            <p>Este paquete ha sido utilizado en {{ $paquete->envios->count() }} envíos.</p>
            @if($paquete->envios->count() > 0)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Este paquete está siendo utilizado activamente. 
                    Tenga en cuenta que modificar sus detalles podría afectar a los envíos existentes.
                </div>
            @endif
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('paquetes.edit', $paquete->PaqueteId) }}" class="btn btn-custom-primary">
                <i class="bi bi-pencil"></i> Editar Paquete
            </a>
            <a href="{{ route('paquetes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver a la Lista
            </a>
            @if($paquete->envios->count() == 0)
                <form action="{{ route('paquetes.destroy', $paquete->PaqueteId) }}" method="POST" class="ms-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('¿Está seguro de eliminar este paquete?')">
                        <i class="bi bi-trash"></i> Eliminar Paquete
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection