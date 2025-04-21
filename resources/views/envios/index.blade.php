@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Envíos</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Tracking</th>
                <th>Fecha</th>
                <th>País</th>
                <th>Estado/Depto</th>
                <th>Dirección de Entrega</th>
                <th>Estatus</th>
                <th>Paquetes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($envios as $envio)
                <tr>
                <td>{{ $envio->cliente->Nombres }} {{ $envio->cliente->Apellidos }}</td>

                    <td>{{ $envio->tracking_number }}</td>
                    <td>{{ $envio->fecha_envio }}</td>
                    <td>{{ $envio->destino_pais->Nombre ?? 'N/A' }}</td>
                    <td>{{ $envio->destino_estado ->NomEstado ?? 'N/A' }}</td>
                    <td>
                        {{ $envio->ciudad_destino }}<br>
                        {{ $envio->direccion_destino }}
                    </td>

                    <td>{{ ucfirst($envio->estatus_envio) }}</td>
                    <td>
                        <ul>
                            @foreach ($envio->paquetes as $paquete)
                                <li>{{ $paquete->descripcion }} ({{ $paquete->peso }}g / ${{ $paquete->valor_declarado }})</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
