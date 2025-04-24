<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Paquete;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cliente;
use App\Models\ClientesDestino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnvioController extends Controller
{
    // Muestra todos los envíos con relaciones necesarias
    public function index()
    {
        $envios = Envio::with(['paquetes', 'cliente', 'clienteDestino', 'destino_pais', 'destino_estado', 'trackingHistory'])->get();
        return view('envios.index', compact('envios'));
    }

    // Muestra el formulario para crear un nuevo envío
    public function create()
    {
        $paises = Pais::all();
        $clientes = Cliente::where('IsDelete', 0)->where('Estatus', 1)->get(); // Clientes origen
        $clientes_destino = ClientesDestino::where('IsDelete', 0)->where('Estatus', 1)->get(); // Clientes destino
        $paquetes = Paquete::all();

        return view('envios.create', compact('paises', 'clientes', 'clientes_destino', 'paquetes'));
    }

    // Guarda un nuevo envío y sus paquetes
    public function store(Request $request)
    {
        $request->validate([
            'cliente_dni' => 'required|string|max:20|exists:clientes,Dni',
            'cliente_destino_option' => 'required|in:existing,new',
            'cliente_destino_dni' => 'nullable|required_if:cliente_destino_option,existing|exists:clientes_destino,Dni',
            'nuevo_destino_dni' => 'required_if:cliente_destino_option,new|unique:clientes_destino,Dni|max:20',
            'nuevo_destino_nombres' => 'required_if:cliente_destino_option,new|string|max:50',
            'nuevo_destino_apellidos' => 'required_if:cliente_destino_option,new|string|max:50',
            'nuevo_destino_telefono' => 'nullable|string|max:15',
            'nuevo_destino_email' => 'nullable|email|max:100',
            'fecha_envio' => 'required|date',
            'destino_pais_id' => 'nullable|exists:paises,CodPais',
            'destino_estado_id' => 'nullable|exists:estados,CodEstado',
            'ciudad_destino' => 'required|string|max:100',
            'direccion_destino' => 'required|string|max:255',
            'estatus_envio' => 'required|string',
            'paquetes.*.paquete_id' => 'required|exists:paquetes,PaqueteId',
            'paquetes.*.descripcion' => 'required|string',
        ]);

        // Manejar cliente destino
        if ($request->cliente_destino_option === 'new') {
            $clienteDestino = ClientesDestino::create([
                'Dni' => $request->nuevo_destino_dni,
                'Nombres' => $request->nuevo_destino_nombres,
                'Apellidos' => $request->nuevo_destino_apellidos,
                'Telefono' => $request->nuevo_destino_telefono,
                'Email' => $request->nuevo_destino_email,
                'CodPais' => $request->destino_pais_id,
                'CodEstado' => $request->destino_estado_id,
                'Ciudad' => $request->ciudad_destino,
                'Direccion' => $request->direccion_destino,
                'Estatus' => 1,
                'IsDelete' => 0,
            ]);
            $cliente_destino_dni = $clienteDestino->Dni;
        } else {
            $cliente_destino_dni = $request->cliente_destino_dni;
        }

        // Generar tracking único
        $tracking = 'TRK' . strtoupper(uniqid());

        // Preparar los datos del envío (sin cliente_destino_dni por ahora)
        $data = $request->except(
            'paquetes',
            'cliente_destino_option',
            'nuevo_destino_dni',
            'nuevo_destino_nombres',
            'nuevo_destino_apellidos',
            'nuevo_destino_telefono',
            'nuevo_destino_email'
        );
        $data['tracking_number'] = $tracking;

        // Asegurarse de que cliente_destino_dni esté siempre definido
        if (!isset($cliente_destino_dni) || empty($cliente_destino_dni)) {
            throw new \Exception('El DNI del cliente destino no puede estar vacío.');
        }

        // Crear el envío sin cliente_destino_dni en el $data array
        $envio = new Envio($data);
        $envio->cliente_destino_dni = $cliente_destino_dni; // Set explicitly
        $envio->save();

        // Guardar las relaciones entre envío y paquetes
        if ($request->has('paquetes')) {
            foreach ($request->paquetes as $paqueteData) {
                $paqueteSeleccionado = Paquete::find($paqueteData['paquete_id']);

                if ($paqueteSeleccionado) {
                    DB::table('envio_paquete')->insert([
                        'envio_id' => $envio->id,
                        'paquete_id' => $paqueteSeleccionado->PaqueteId,
                        'descripcion' => $paqueteData['descripcion'],
                        'precio' => $paqueteSeleccionado->precio,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('envios.index')->with('success', '¡Envío creado correctamente!');
    }

    // Devuelve los estados por país para AJAX
    public function obtenerEstadosPorPais($paisId)
    {
        $estados = Estado::where('CodPais', $paisId)
            ->where('IsDelete', 0)
            ->where('Estatus', 1)
            ->get();

        return response()->json($estados);
    }

    // Muestra el seguimiento de un envío
    public function seguimiento(Request $request)
    {
        $trackingNumber = $request->input('tracking_number');
        $envio = Envio::where('tracking_number', $trackingNumber)->first();

        return view('seguimiento', compact('envio', 'trackingNumber'));
    }

    // Actualiza el estado de un envío y lo guarda en el historial
    public function actualizarEstado(Request $request, Envio $envio)
    {
        $request->validate([
            'estado' => 'required|in:registrado,en_transito,en_aduanas,entregado',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $envio->update(['estatus_envio' => $request->estado]);

        $envio->trackingHistory()->create([
            'estado' => $request->estado,
            'ubicacion' => $request->ubicacion,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Estado actualizado!');
    }
}