@extends('layouts.app')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
    }
    .shipment-container {
        min-height: calc(100vh - 100px);
        padding: 20px;
        margin: 0 auto;
        max-width: 100%;
        box-sizing: border-box;
    }
    .shipment-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .shipment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    .shipment-card h2 {
        color: #003087;
        border-bottom: 3px solid #003087;
        padding-bottom: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        font-weight: 700;
        font-size: 1.75rem;
    }
    .shipment-card h2 i {
        margin-right: 12px;
        font-size: 1.5rem;
        color: #003087;
    }
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    .table {
        margin-bottom: 0;
        width: 100%;
    }
    .table thead {
        background: linear-gradient(90deg, #003087 0%, #0052cc 100%);
        color: white;
    }
    .table thead th {
        border: none;
        font-weight: 600;
        padding: 15px;
        text-align: center;
        font-size: 0.95rem;
    }
    .table tbody tr {
        transition: background-color 0.3s ease;
    }
    .table tbody tr:hover {
        background-color: #e6f0fa;
    }
    .table tbody td {
        padding: 12px;
        vertical-align: middle;
        font-size: 0.9rem;
        text-align: center;
    }
    .btn-primary, .btn-success {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        background: linear-gradient(90deg, #003087 0%, #0052cc 100%);
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #00205b 0%, #003087 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .btn-primary:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .btn-success {
        background: linear-gradient(90deg, #28a745 0%, #34c759 100%);
    }
    .btn-success:hover {
        background: linear-gradient(90deg, #218838 0%, #28a745 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .dropdown-toggle {
        border-radius: 25px;
        padding: 8px 16px;
        font-weight: 600;
        background: linear-gradient(90deg, #003087 0%, #0052cc 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .dropdown-toggle:hover {
        background: linear-gradient(90deg, #00205b 0%, #003087 100%);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .dropdown-item {
        padding: 10px 20px;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }
    .dropdown-item:hover {
        background-color: #e6f0fa;
    }
    .dropdown-item i {
        margin-right: 8px;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: none;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-size: 0.95rem;
    }
    .badge {
        font-size: 0.85em;
        padding: 6px 12px;
        border-radius: 12px;
    }
    .text-muted, .text-danger, .text-warning {
        font-size: 0.85em;
    }
    .small {
        font-size: 0.85em;
        color: #6c757d;
    }
    .modal-content {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
        background: linear-gradient(90deg, #003087 0%, #0052cc 100%);
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .modal-title {
        font-weight: 600;
    }
    .modal-body {
        padding: 25px;
    }
    .modal-footer {
        border-top: none;
        padding: 15px 25px;
    }
    .form-label {
        font-weight: 500;
        color: #003087;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #003087;
        box-shadow: 0 0 5px rgba(0, 48, 135, 0.3);
    }
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 4px;
    }
    .is-invalid ~ .invalid-feedback {
        display: block;
    }
    .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease;
    }
    .form-select:focus {
        border-color: #003087;
        box-shadow: 0 0 5px rgba(0, 48, 135, 0.3);
    }
    .btn-secondary {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .summary-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 5px solid #003087;
    }
    .summary-section h5 {
        color: #003087;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .summary-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .summary-card h6 {
        color: #003087;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1rem;
    }
    .summary-card p {
        margin: 5px 0;
        font-size: 0.9rem;
        color: #333;
    }
    .summary-card .metric {
        font-size: 1.2rem;
        font-weight: 700;
        color: #003087;
    }
    .summary-list {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 10px;
    }
    .summary-list::-webkit-scrollbar {
        width: 6px;
    }
    .summary-list::-webkit-scrollbar-thumb {
        background: #003087;
        border-radius: 3px;
    }
    @media (max-width: 768px) {
        .shipment-card h2 {
            font-size: 1.5rem;
        }
        .table thead th, .table tbody td {
            font-size: 0.85rem;
            padding: 10px;
        }
        .btn-primary, .dropdown-toggle, .btn-success {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        .summary-card h6 {
            font-size: 0.95rem;
        }
        .summary-card p {
            font-size: 0.85rem;
        }
        .summary-card .metric {
            font-size: 1rem;
        }
    }
</style>

<div class="shipment-container">
    <div class="shipment-card">
        <h2><i class="bi bi-truck"></i> Listado de Envíos</h2>

        <!-- Mostrar mensaje de éxito si existe -->
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter and Export Section -->
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <div>
                <label class="form-label">Filtrar por período:</label>
                <form method="GET" action="{{ route('envios.index') }}" style="display: inline;">
                    <select name="filter_period" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $filterPeriod == 'all' ? 'selected' : '' }}>Todos</option>
                        <option value="daily" {{ $filterPeriod == 'daily' ? 'selected' : '' }}>Diario</option>
                        <option value="weekly" {{ $filterPeriod == 'weekly' ? 'selected' : '' }}>Semanal</option>
                        <option value="biweekly" {{ $filterPeriod == 'biweekly' ? 'selected' : '' }}>Quincenal</option>
                        <option value="monthly" {{ $filterPeriod == 'monthly' ? 'selected' : '' }}>Mensual</option>
                    </select>
                </form>
            </div>
            <div>
                <form method="GET" action="{{ route('envios.index') }}" style="display: inline;">
                    <input type="hidden" name="filter_period" value="{{ $filterPeriod }}">
                    <input type="hidden" name="export" value="pdf">
                    <button type="submit" class="btn btn-primary">Exportar a PDF</button>
                </form>
                <form method="GET" action="{{ route('envios.index') }}" style="display: inline;">
                    <input type="hidden" name="filter_period" value="{{ $filterPeriod }}">
                    <input type="hidden" name="export" value="excel">
                    <button type="submit" class="btn btn-success">Exportar a Excel</button>
                </form>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <h5>Resumen Contable</h5>
            <div class="row g-3">
                <!-- Total Metrics -->
                <div class="col-md-4 col-sm-6">
                    <div class="summary-card">
                        <h6>Totales</h6>
                        <p>Total Envíos: <span class="metric">{{ $totalEnvios }}</span></p>
                        <p>Total Paquetes: <span class="metric">{{ $totalPaquetes }}</span></p>
                        <p>Ingresos Totales: <span class="metric">${{ number_format($totalRevenue, 2) }}</span></p>
                    </div>
                </div>
                <!-- Shipment Types -->
                <div class="col-md-4 col-sm-6">
                    <div class="summary-card">
                        <h6>Tipos de Envíos</h6>
                        <div class="summary-list">
                            @forelse($enviosByStatus as $status => $count)
                                <p>{{ ucfirst(str_replace('_', ' ', $status)) }}: <span class="metric">{{ $count }}</span></p>
                            @empty
                                <p class="text-muted">No hay datos disponibles.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Shipments by Client -->
                <div class="col-md-4 col-sm-6">
                    <div class="summary-card">
                        <h6>Envíos por Cliente</h6>
                        <div class="summary-list">
                            @forelse($enviosByClient as $client)
                                <p>{{ $client['client_name'] }}: <span class="metric">{{ $client['count'] }}</span></p>
                            @empty
                                <p class="text-muted">No hay datos disponibles.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para crear un nuevo envío -->
        <div class="mb-4 text-center">
            <a href="{{ route('envios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Registrar Nuevo Envío
            </a>
        </div>

        <!-- Tabla de envíos -->
        @if ($envios->isEmpty())
            <p class="text-muted text-center">No hay envíos registrados.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tracking</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Destino</th>
                            <th>Paquetes</th>
                            <th>Estatus</th>
                            <th>Fecha Envío</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($envios as $envio)
                            <tr>
                                <td>{{ $envio->tracking_number }}</td>
                                <td>
                                    @if($envio->cliente)
                                        {{ $envio->cliente->Nombres }} {{ $envio->cliente->Apellidos }}
                                        <br><small class="text-muted">DNI: {{ $envio->cliente->Dni }}</small>
                                        <br><small class="text-muted">Teléfono: {{ $envio->cliente->PrimerTelefono ?? 'N/A' }}</small>
                                    @else
                                        <span class="text-danger">Cliente no encontrado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($envio->clienteDestino)
                                        {{ $envio->clienteDestino->Nombres }} {{ $envio->clienteDestino->Apellidos }}
                                        <br><small class="text-muted">DNI: {{ $envio->cliente_destino_dni }}</small>
                                        <br><small class="text-muted">Teléfono: {{ $envio->clienteDestino->Telefono ?? 'N/A' }}</small>
                                    @else
                                        <span class="text-danger">Destinatario no encontrado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($envio->destino_pais && $envio->destino_estado)
                                        <strong>{{ $envio->destino_pais->Nombre }}</strong> - {{ $envio->destino_estado->NomEstado }}
                                        <br>{{ $envio->ciudad_destino }}
                                        <br><small>{{ $envio->direccion_destino }}</small>
                                    @else
                                        <span class="text-warning">Destino incompleto</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($envio->paquetes as $paquete)
                                        <div class="mb-2">
                                            <span class="badge bg-secondary">{{ $paquete->NombrePaquete }}</span>
                                            <div class="small">
                                                <strong>Descripción:</strong> {{ $paquete->pivot->descripcion }}<br>
                                                <strong>Dimensiones:</strong> {{ $paquete->dimension }}<br>
                                                <strong>Precio histórico:</strong> ${{ number_format($paquete->pivot->precio, 2) }}
                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-muted">Sin paquetes</span>
                                    @endforelse
                                </td>
                                <td>
                                    <span class="badge bg-{{ $envio->estatus_envio == 'entregado' ? 'success' : 'primary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $envio->estatus_envio)) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($envio->fecha_envio)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton{{ $envio->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear"></i> Acciones
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $envio->id }}">
                                            <li>
                                                <a class="dropdown-item update-tracking" 
                                                   href="#" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#updateStatusModal"
                                                   data-id="{{ $envio->id }}"
                                                   data-action="{{ route('envios.actualizar-estado', $envio) }}"
                                                   data-estado="{{ $envio->estatus_envio }}"
                                                   data-ubicacion="{{ $envio->trackingHistory->last()->ubicacion ?? '' }}"
                                                   data-descripcion="{{ $envio->trackingHistory->last()->descripcion ?? '' }}">
                                                    <i class="bi bi-pencil-square"></i> Actualizar Tracking
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('envios.edit', $envio) }}">
                                                    <i class="bi bi-edit"></i> Editar Envío
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="generatePDF('{{ $envio->tracking_number }}', '{{ $envio->cliente ? $envio->cliente->Nombres . ' ' . $envio->cliente->Apellidos : 'Cliente no encontrado' }}', '{{ $envio->cliente ? $envio->cliente->Dni : 'N/A' }}', '{{ $envio->cliente ? $envio->cliente->PrimerTelefono ?? 'N/A' : 'N/A' }}', '{{ $envio->clienteDestino ? $envio->clienteDestino->Nombres . ' ' . $envio->clienteDestino->Apellidos : 'Destinatario no encontrado' }}', '{{ $envio->cliente_destino_dni ?? 'N/A' }}', '{{ $envio->clienteDestino ? $envio->clienteDestino->Telefono : 'N/A' }}', '{{ $envio->direccion_destino }}', '{{ $envio->ciudad_destino }}', '{{ $envio->destino_estado ? $envio->destino_estado->NomEstado : 'N/A' }}', '{{ $envio->destino_pais ? $envio->destino_pais->Nombre : 'N/A' }}', '{{ json_encode($envio->paquetes->map(fn($paquete) => ['descripcion' => $paquete->pivot->descripcion, 'dimension' => $paquete->pivot->descripcion, 'precio' => $paquete->pivot->precio])) }}', '{{ \Carbon\Carbon::parse($envio->fecha_envio)->format('d-m-Y') }}')">
                                                    <i class="bi bi-file-pdf"></i> Generar Guía PDF
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $envio->id }})">
                                                    <i class="bi bi-trash"></i> Eliminar Envío
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Formulario oculto para eliminar el envío -->
                                    <form id="deleteForm{{ $envio->id }}" action="{{ route('envios.destroy', $envio) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Modal de Actualización (Fuera del bucle) -->
        <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Actualizar Estado del Envío</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateStatusForm" method="POST" action="">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label">Estado Actual:</label>
                                <select name="estado" id="estadoSelect" class="form-select" required>
                                    <option value="" disabled>Selecciona un estado</option>
                                    <option value="registrado">Registrado</option>
                                    <option value="en_transito">En Tránsito</option>
                                    <option value="en_aduanas">En Aduanas</option>
                                    <option value="entregado">Entregado</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecciona un estado.
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Ubicación Actual:</label>
                                <input type="text"
                                       name="ubicacion"
                                       id="ubicacionInput"
                                       class="form-control"
                                       required
                                       placeholder="Ej: Centro de distribución">
                                <div class="invalid-feedback">
                                    Por favor, ingresa una ubicación válida.
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Detalles (Opcional):</label>
                                <textarea name="descripcion"
                                          id="descripcionTextarea"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Ej: Salió del centro de distribución"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir bibliotecas para generar PDF y QR -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
// Confirmación para eliminar pedido
function confirmDelete(envioId) {
    if (confirm('¿Estás seguro de que deseas eliminar este pedido? Esta acción no se puede deshacer.')) {
        document.getElementById('deleteForm' + envioId).submit();
    }
}

// Manejar la apertura del modal y cerrar el dropdown
document.addEventListener('DOMContentLoaded', function () {
    const updateTrackingLinks = document.querySelectorAll('.update-tracking');
    const modal = document.getElementById('updateStatusModal');
    const form = document.getElementById('updateStatusForm');
    const estadoSelect = document.getElementById('estadoSelect');
    const ubicacionInput = document.getElementById('ubicacionInput');
    const descripcionTextarea = document.getElementById('descripcionTextarea');
    const submitBtn = document.getElementById('submitBtn');

    updateTrackingLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Obtener datos del enlace
            const action = this.getAttribute('data-action');
            const estado = this.getAttribute('data-estado');
            const ubicacion = this.getAttribute('data-ubicacion');
            const descripcion = this.getAttribute('data-descripcion');

            // Rellenar el formulario
            form.action = action;
            estadoSelect.value = estado || '';
            ubicacionInput.value = ubicacion || '';
            descripcionTextarea.value = descripcion || '';

            // Limpiar estados de validación
            estadoSelect.classList.remove('is-invalid');
            ubicacionInput.classList.remove('is-invalid');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Guardar Cambios';
        });
    });

    // Cerrar el dropdown al abrir el modal
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const dropdown = button.closest('.dropdown');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
        
        if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
            dropdownToggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Manejar el envío del formulario
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Validar campos
        let isValid = true;

        if (!estadoSelect.value) {
            estadoSelect.classList.add('is-invalid');
            isValid = false;
        } else {
            estadoSelect.classList.remove('is-invalid');
        }

        if (!ubicacionInput.value.trim()) {
            ubicacionInput.classList.add('is-invalid');
            isValid = false;
        } else {
            ubicacionInput.classList.remove('is-invalid');
        }

        if (!isValid) {
            return;
        }

        // Deshabilitar botón y mostrar estado de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Guardando...';

        // Enviar el formulario
        form.submit();
    });

    // Reiniciar el formulario y el botón al cerrar el modal
    modal.addEventListener('hidden.bs.modal', function () {
        form.reset();
        estadoSelect.classList.remove('is-invalid');
        ubicacionInput.classList.remove('is-invalid');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Guardar Cambios';
    });
});

function generatePDF(tracking, remitente, remitenteDni, remitenteTelefono, destinatario, destinatarioDni, destinatarioTelefono, direccion, ciudad, estado, pais, paquetesJson, fecha) {
    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Parsear los paquetes desde JSON
        const paquetes = JSON.parse(paquetesJson);

        // Calcular el total de precios
        const totalPrecio = paquetes.reduce((sum, paquete) => sum + parseFloat(paquete.precio || 0), 0);

        // Generar la URL para el seguimiento
        const trackingUrl = `https://yourdomain.com/seguimiento?tracking_number=${encodeURIComponent(tracking)}`;

        // Generar QR con la URL de seguimiento
        const qrDiv = document.createElement('div');
        const qrCode = new QRCode(qrDiv, {
            text: trackingUrl,
            width: 80,
            height: 80,
            colorDark: "#003087",
            colorLight: "#ffffff"
        });

        // Esperar a que el QR se renderice completamente
        setTimeout(() => {
            const qrCanvas = qrDiv.querySelector('canvas');
            if (!qrCanvas) {
                throw new Error('No se pudo generar el QR Code');
            }
            const qrDataURL = qrCanvas.toDataURL('image/png');

            // Cargar el logo
            const logo = new Image();
            logo.crossOrigin = "Anonymous";
            logo.src = '/img/LOGODALLAS.png';

            logo.onload = function() {
                try {
                    // Fondo y diseño
                    doc.setFillColor(245, 250, 255);
                    doc.rect(0, 0, 210, 297, 'F');

                    // Borde decorativo
                    doc.setDrawColor(0, 48, 135);
                    doc.setLineWidth(1);
                    doc.rect(5, 5, 200, 287, 'S');

                    // Encabezado con logo
                    doc.addImage(logo, 'PNG', 15, 15, 35, 35);
                    doc.setFontSize(14);
                    doc.setTextColor(0, 48, 135);
                    doc.setFont("helvetica", "bold");
                    doc.text('DALLAS SHIPPING', 55, 25);
                    doc.setFontSize(9);
                    doc.setTextColor(80, 80, 80);
                    doc.setFont("helvetica", "normal");
                    doc.text('PBX: 2202-9400  |  WhatsApp: +1 (973) 332-9126', 55, 33);
                    doc.text(`Paquete(s): ${paquetes.length}`, 55, 41);

                    // Barra de título con Tracking
                    doc.setFillColor(0, 48, 135);
                    doc.rect(15, 55, 180, 15, 'F');
                    doc.setTextColor(255, 255, 255);
                    doc.setFontSize(16);
                    doc.setFont("helvetica", "bold");
                    doc.text(`Tracking: ${tracking}`, 20, 65);
                    doc.setTextColor(0, 0, 0);
                    doc.setFontSize(9);
                    doc.setFont("helvetica", "normal");
                    doc.text(`Fecha: ${fecha}`, 165, 65);

                    // Línea decorativa
                    doc.setDrawColor(0, 48, 135);
                    doc.setLineWidth(0.5);
                    doc.line(15, 75, 195, 75);

                    // QR Code con fondo
                    doc.setFillColor(255, 255, 255);
                    doc.rect(15, 80, 50, 50, 'F');
                    doc.addImage(qrDataURL, 'PNG', 20, 85, 40, 40);
                    doc.setFontSize(8);
                    doc.setTextColor(100);
                    doc.text('Escanea para seguir tu envío', 20, 135);

                    // Secciones con fondo sombreado
                    doc.setFillColor(230, 240, 250);
                    doc.roundedRect(75, 80, 120, 50, 3, 3, 'F'); // Detalles del Envío
                    doc.roundedRect(75, 135, 120, 90, 3, 3, 'F'); // Detalles del Paquete
                    doc.roundedRect(15, 140, 50, 90, 3, 3, 'F'); // Destino

                    // Información del envío
                    doc.setFontSize(11);
                    doc.setTextColor(0, 48, 135);
                    doc.setFont("helvetica", "bold");
                    doc.text('Detalles del Envío', 80, 88);
                    doc.setLineWidth(0.3);
                    doc.line(80, 90, 130, 90);

                    doc.setFontSize(9);
                    doc.setTextColor(0);
                    doc.setFont("helvetica", "normal");
                    doc.text('Remitente:', 80, 98);
                    doc.setTextColor(80);
                    doc.text(remitente, 80, 104);
                    doc.setTextColor(0);
                    doc.text('DNI:', 80, 110);
                    doc.setTextColor(80);
                    doc.text(remitenteDni, 80, 116);
                    doc.setTextColor(0);
                    doc.text('Teléfono:', 80, 122);
                    doc.setTextColor(80);
                    doc.text(remitenteTelefono, 80, 128);

                    doc.setTextColor(0);
                    doc.text('Destinatario:', 135, 98);
                    doc.setTextColor(80);
                    doc.text(destinatario, 135, 104);
                    doc.setTextColor(0);
                    doc.text('DNI:', 135, 110);
                    doc.setTextColor(80);
                    doc.text(destinatarioDni, 135, 116);
                    doc.setTextColor(0);
                    doc.text('Teléfono:', 135, 122);
                    doc.setTextColor(80);
                    doc.text(destinatarioTelefono, 135, 128);

                    // Detalles del paquete
                    doc.setTextColor(0, 48, 135);
                    doc.setFont("helvetica", "bold");
                    doc.text('Detalles del Paquete', 80, 143);
                    doc.line(80, 145, 140, 145);

                    let yPosition = 153;
                    paquetes.forEach((paquete, index) => {
                        doc.setFontSize(9);
                        doc.setTextColor(0);
                        doc.setFont("helvetica", "normal");
                        doc.text(`Paquete ${index + 1}:`, 80, yPosition);
                        doc.setTextColor(80);
                        doc.text(`Descripción: ${paquete.descripcion}`, 80, yPosition + 6);
                        doc.setTextColor(0);
                        doc.text(`Dimensiones: ${paquete.dimension}`, 80, yPosition + 12);
                        doc.setTextColor(80);
                        doc.text(`Precio: $${parseFloat(paquete.precio).toFixed(2)}`, 80, yPosition + 18);
                        yPosition += 25;
                    });

                    // Mostrar el total
                    doc.setTextColor(0, 48, 135);
                    doc.setFont("helvetica", "bold");
                    doc.text(`Total: $${totalPrecio.toFixed(2)}`, 80, yPosition);

                    // Dirección y destino
                    doc.setTextColor(0, 48, 135);
                    doc.setFont("helvetica", "bold");
                    doc.text('Destino', 20, 148);
                    doc.line(20, 150, 50, 150);

                    doc.setFontSize(9);
                    doc.setTextColor(0);
                    doc.setFont("helvetica", "normal");
                    doc.text('Dirección:', 20, 158);
                    doc.setTextColor(80);
                    doc.text(direccion, 20, 164, { maxWidth: 40 });
                    doc.setTextColor(0);
                    doc.text('Ciudad:', 20, 176);
                    doc.setTextColor(80);
                    doc.text(ciudad, 20, 182);
                    doc.setTextColor(0);
                    doc.text('Estado:', 20, 188);
                    doc.setTextColor(80);
                    doc.text(estado, 20, 194);
                    doc.setTextColor(0);
                    doc.text('País:', 20, 200);
                    doc.setTextColor(80);
                    doc.text(pais, 20, 206);

                    // Footer
                    doc.setFillColor(0, 48, 135);
                    doc.rect(0, 277, 210, 20, 'F');
                    doc.setTextColor(255);
                    doc.setFontSize(10);
                    doc.setFont("helvetica", "bold");
                    doc.text('Gracias por elegir DALLAS SHIPPING - Rastreo seguro y confiable', 105, 287, { align: 'center' });

                    // Descargar el PDF
                    doc.save(`guia_${tracking}.pdf`);
                } catch (error) {
                    console.error('Error al generar el PDF dentro de logo.onload:', error);
                    alert('Error al generar el PDF. Por favor, revisa la consola para más detalles.');
                }
            };

            logo.onerror = function() {
                console.error('Error al cargar el logo. Procediendo sin el logo.');
                // Generar el PDF sin el logo
                doc.setFillColor(245, 250, 255);
                doc.rect(0, 0, 210, 297, 'F');

                doc.setDrawColor(0, 48, 135);
                doc.setLineWidth(1);
                doc.rect(5, 5, 200, 287, 'S');

                doc.setFontSize(14);
                doc.setTextColor(0, 48, 135);
                doc.setFont("helvetica", "bold");
                doc.text('DALLAS SHIPPING', 15, 25);
                doc.setFontSize(9);
                doc.setTextColor(80, 80, 80);
                doc.setFont("helvetica", "normal");
                doc.text('PBX: 2202-9400  |  WhatsApp: +1 (973) 332-9126', 15, 33);
                doc.text(`Paquete(s): ${paquetes.length}`, 15, 41);

                doc.setFillColor(0, 48, 135);
                doc.rect(15, 55, 180, 15, 'F');
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(16);
                doc.setFont("helvetica", "bold");
                doc.text(`Tracking: ${tracking}`, 20, 65);
                doc.setTextColor(0, 0, 0);
                doc.setFontSize(9);
                doc.setFont("helvetica", "normal");
                doc.text(`Fecha: ${fecha}`, 165, 65);

                doc.setDrawColor(0, 48, 135);
                doc.setLineWidth(0.5);
                doc.line(15, 75, 195, 75);

                doc.setFillColor(255, 255, 255);
                doc.rect(15, 80, 50, 50, 'F');
                doc.addImage(qrDataURL, 'PNG', 20, 85, 40, 40);
                doc.setFontSize(8);
                doc.setTextColor(100);
                doc.text('Escanea para seguir tu envío', 20, 135);

                doc.setFillColor(230, 240, 250);
                doc.roundedRect(75, 80, 120, 50, 3, 3, 'F');
                doc.roundedRect(75, 135, 120, 90, 3, 3, 'F');
                doc.roundedRect(15, 140, 50, 90, 3, 3, 'F');

                doc.setFontSize(11);
                doc.setTextColor(0, 48, 135);
                doc.setFont("helvetica", "bold");
                doc.text('Detalles del Envío', 80, 88);
                doc.setLineWidth(0.3);
                doc.line(80, 90, 130, 90);

                doc.setFontSize(9);
                doc.setTextColor(0);
                doc.setFont("helvetica", "normal");
                doc.text('Remitente:', 80, 98);
                doc.setTextColor(80);
                doc.text(remitente, 80, 104);
                doc.setTextColor(0);
                doc.text('DNI:', 80, 110);
                doc.setTextColor(80);
                doc.text(remitenteDni, 80, 116);
                doc.setTextColor(0);
                doc.text('Teléfono:', 80, 122);
                doc.setTextColor(80);
                doc.text(remitenteTelefono, 80, 128);

                doc.setTextColor(0);
                doc.text('Destinatario:', 135, 98);
                doc.setTextColor(80);
                doc.text(destinatario, 135, 104);
                doc.setTextColor(0);
                doc.text('DNI:', 135, 110);
                doc.setTextColor(80);
                doc.text(destinatarioDni, 135, 116);
                doc.setTextColor(0);
                doc.text('Teléfono:', 135, 122);
                doc.setTextColor(80);
                doc.text(destinatarioTelefono, 135, 128);

                doc.setTextColor(0, 48, 135);
                doc.setFont("helvetica", "bold");
                doc.text('Detalles del Paquete', 80, 143);
                doc.line(80, 145, 140, 145);

                let yPosition = 153;
                paquetes.forEach((paquete, index) => {
                    doc.setFontSize(9);
                    doc.setTextColor(0);
                    doc.setFont("helvetica", "normal");
                    doc.text(`Paquete ${index + 1}:`, 80, yPosition);
                    doc.setTextColor(80);
                    doc.text(`Descripción: ${paquete.descripcion}`, 80, yPosition + 6);
                    doc.setTextColor(0);
                    doc.text(`Dimensiones: ${paquete.dimension}`, 80, yPosition + 12);
                    doc.setTextColor(80);
                    doc.text(`Precio: $${parseFloat(paquete.precio).toFixed(2)}`, 80, yPosition + 18);
                    yPosition += 25;
                });

                doc.setTextColor(0, 48, 135);
                doc.setFont("helvetica", "bold");
                doc.text(`Total: $${totalPrecio.toFixed(2)}`, 80, yPosition);

                doc.setTextColor(0, 48, 135);
                doc.setFont("helvetica", "bold");
                doc.text('Destino', 20, 148);
                doc.line(20, 150, 50, 150);

                doc.setFontSize(9);
                doc.setTextColor(0);
                doc.setFont("helvetica", "normal");
                doc.text('Dirección:', 20, 158);
                doc.setTextColor(80);
                doc.text(direccion, 20, 164, { maxWidth: 40 });
                doc.setTextColor(0);
                doc.text('Ciudad:', 20, 176);
                doc.setTextColor(80);
                doc.text(ciudad, 20, 182);
                doc.setTextColor(0);
                doc.text('Estado:', 20, 188);
                doc.setTextColor(80);
                doc.text(estado, 20, 194);
                doc.setTextColor(0);
                doc.text('País:', 20, 200);
                doc.setTextColor(80);
                doc.text(pais, 20, 206);

                doc.setFillColor(0, 48, 135);
                doc.rect(0, 277, 210, 20, 'F');
                doc.setTextColor(255);
                doc.setFontSize(10);
                doc.setFont("helvetica", "bold");
                doc.text('Gracias por elegir DALLAS SHIPPING - Rastreo seguro y confiable', 105, 287, { align: 'center' });

                doc.save(`guia_${tracking}.pdf`);
            };
        }, 500); // Aumentar el retraso para asegurar que el QR se renderice
    } catch (error) {
        console.error('Error al generar el PDF:', error);
        alert('Error al generar el PDF. Por favor, revisa la consola para más detalles.');
    }
}
</script>
@endsection