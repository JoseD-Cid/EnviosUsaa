@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Envíos</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tracking</th>
                <th>Cliente</th>
                <th>Destino</th>
                <th>Paquetes</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($envios as $envio)
            <tr>
                <td>{{ $envio->tracking_number }}</td>
                <td>
                    {{ $envio->cliente->nombres }} {{ $envio->cliente->apellidos }}<br>
                    <small>DNI: {{ $envio->cliente->dni }}</small>
                </td>
                <td>
                    {{ $envio->pais->Nombre }} - {{ $envio->estado->NomEstado }}<br>
                    {{ $envio->ciudad_destino }}, {{ $envio->direccion_destino }}
                </td>
                <td>
                    @foreach($envio->paquetes as $paquete)
                    • {{ $paquete->descripcion }} ({{ $paquete->peso }}g)<br>
                    @endforeach
                </td>
                <td>{{ ucfirst($envio->estatus_envio) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection