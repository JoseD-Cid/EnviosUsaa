<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Paquete;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnvioController extends Controller
{
    // Muestra todos los envíos con relaciones necesarias
    public function index()
    {
        $envios = Envio::with(['paquetes', 'cliente', 'destino_pais', 'destino_estado', 'trackingHistory'])->get();

        return view('envios.index', compact('envios'));
    }

    // Muestra el formulario para crear un nuevo envío
    public function create()
    {
        $paises = Pais::all(); // Obtiene todos los países
        $clientes = Cliente::where('IsDelete', 0)->where('Estatus', 1)->get(); // Solo clientes activos
        $paquetes = Paquete::all(); // Obtiene todos los paquetes disponibles

        return view('envios.create', compact('paises', 'clientes', 'paquetes'));
    }

    // Guarda un nuevo envío y sus paquetes
    public function store(Request $request)
    {
        $request->validate([
            'cliente_dni' => 'required|string|max:20',
            'fecha_envio' => 'required|date',
            'destino_pais_id' => 'nullable|exists:paises,CodPais',
            'destino_estado_id' => 'nullable|exists:estados,CodEstado',
            'ciudad_destino' => 'required|string',
            'direccion_destino' => 'required|string',
            'estatus_envio' => 'required|string',
            'paquetes.*.paquete_id' => 'required|exists:paquetes,PaqueteId',
            'paquetes.*.descripcion' => 'required|string',
        ]);

        // Generar tracking único
        $tracking = 'TRK' . strtoupper(uniqid());

        // Preparar los datos del envío
        $data = $request->except('paquetes');
        $data['tracking_number'] = $tracking;

        // Crear el envío
        $envio = Envio::create($data);

        // Guardar las relaciones entre envío y paquetes
        if ($request->has('paquetes')) {
            foreach ($request->paquetes as $paqueteData) {
                $paqueteSeleccionado = Paquete::find($paqueteData['paquete_id']);
                
                if ($paqueteSeleccionado) {
                    // Usamos una tabla intermedia para la relación
                    // La tabla se llama envio_paquete
                    DB::table('envio_paquete')->insert([
                        'envio_id' => $envio->id,
                        'paquete_id' => $paqueteSeleccionado->PaqueteId,
                        'descripcion' => $paqueteData['descripcion'],
                        'precio' => $paqueteSeleccionado->precio,
                        'created_at' => now(),
                        'updated_at' => now()
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
        
        // Buscar el envío por el número de seguimiento
        $envio = Envio::where('tracking_number', $trackingNumber)->first();
    
        return view('seguimiento', compact('envio', 'trackingNumber'));
    }
    
    // Actualiza el estado de un envío y lo guarda en el historial
    public function actualizarEstado(Request $request, Envio $envio)
    {
        $request->validate([
            'estado' => 'required|in:registrado,en_transito,en_aduanas,entregado',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        // Actualizar el estado del envío
        $envio->update(['estatus_envio' => $request->estado]);

        // Crear un nuevo registro en el historial de seguimiento
        $envio->trackingHistory()->create([
            'estado' => $request->estado,
            'ubicacion' => $request->ubicacion,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Estado actualizado!');
    }
}