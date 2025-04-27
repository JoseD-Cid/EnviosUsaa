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
use Carbon\Carbon;
use App\Exports\EnviosReportExport;

class EnvioController extends Controller
{
    // Muestra todos los envíos con relaciones necesarias y genera datos para el reporte
    public function index(Request $request)
    {
        // Get filter period from request (default to 'all')
        $filterPeriod = $request->input('filter_period', 'all');
        $startDate = null;
        $endDate = Carbon::now();

        // Set date range based on filter
        switch ($filterPeriod) {
            case 'daily':
                $startDate = Carbon::today();
                break;
            case 'weekly':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'biweekly':
                $startDate = Carbon::now()->subDays(14);
                break;
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                break;
            default:
                $startDate = null; // No filter, fetch all
        }

        // Base query for shipments
        $query = Envio::with(['paquetes', 'cliente', 'clienteDestino', 'destino_pais', 'destino_estado', 'trackingHistory']);

        // Apply date filter if set
        if ($startDate) {
            $query->whereBetween('fecha_envio', [$startDate, $endDate]);
        }

        // Fetch filtered shipments
        $envios = $query->get();
        $paises = Pais::all();

        // Calculate totals
        $totalEnvios = $envios->count();
        $totalPaquetes = $envios->sum(function ($envio) {
            return $envio->paquetes->count();
        });
        $totalRevenue = $envios->sum(function ($envio) {
            return $envio->paquetes->sum('pivot.precio');
        });

        // Group by shipment status (type)
        $enviosByStatus = $envios->groupBy('estatus_envio')->map->count();

        // Group by client (Remitente)
        $enviosByClient = $envios->groupBy('cliente_dni')->map(function ($group) {
            return [
                'client_name' => $group->first()->cliente ? $group->first()->cliente->Nombres . ' ' . $group->first()->cliente->Apellidos : 'Desconocido',
                'count' => $group->count(),
            ];
        });

        // Handle export request
        if ($request->has('export')) {
            $exportType = $request->input('export');
            $reportData = [
                'envios' => $envios,
                'totalEnvios' => $totalEnvios,
                'totalPaquetes' => $totalPaquetes,
                'totalRevenue' => $totalRevenue,
                'enviosByStatus' => $enviosByStatus,
                'enviosByClient' => $enviosByClient,
                'filterPeriod' => $filterPeriod,
            ];

            if ($exportType === 'pdf') {
                $pdf = app('PDF')->loadView('envios.report', $reportData);
                return $pdf->download('reporte_envios_' . $filterPeriod . '_' . now()->format('Ymd') . '.pdf');
            } elseif ($exportType === 'excel') {
                return app('Excel')->download(new EnviosReportExport($reportData), 'reporte_envios_' . $filterPeriod . '_' . now()->format('Ymd') . '.xlsx');
            }
        }

        return view('envios.index', compact(
            'envios',
            'paises',
            'totalEnvios',
            'totalPaquetes',
            'totalRevenue',
            'enviosByStatus',
            'enviosByClient',
            'filterPeriod'
        ));
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

    public function buscarClientesDestino(Request $request): JsonResponse
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }
        
        $clientes = ClientesDestino::where('IsDelete', 0)
            ->where('Estatus', 1)
            ->where(function($q) use ($query) {
                $q->where('Dni', 'like', "%{$query}%")
                  ->orWhere('Nombres', 'like', "%{$query}%")
                  ->orWhere('Apellidos', 'like', "%{$query}%");
            })
            ->select('Dni', 'Nombres', 'Apellidos')
            ->limit(10)
            ->get();
            
        return response()->json($clientes);
    }

    // Eliminar envío
    public function destroy(Envio $envio)
    {
        // Delete related tracking history records
        $envio->trackingHistory()->delete();

        // Detach related packages from the pivot table
        $envio->paquetes()->detach();

        // Delete the envio
        $envio->delete();

        return redirect()->route('envios.index')->with('success', 'Envío eliminado exitosamente.');
    }

    // Actualizar envío
    public function edit(Envio $envio)
    {
        $paquetes = Paquete::all();
        $paises = Pais::all();
        $estados = Estado::all();
        $clientes = Cliente::all();
        $clientes_destino = ClientesDestino::all();

        return view('envios.edit', compact('envio', 'paquetes', 'paises', 'estados', 'clientes', 'clientes_destino'));
    }

    public function update(Request $request, Envio $envio)
    {
        $validated = $request->validate([
            'cliente_dni' => 'required|exists:clientes,Dni',
            'cliente_destino_dni' => 'required|exists:clientes_destino,Dni',
            'fecha_envio' => 'required|date',
            'tracking_number' => 'required|string|unique:envios,tracking_number,' . $envio->id,
            'destino_pais_id' => 'required|exists:paises,CodPais',
            'destino_estado_id' => 'required|exists:estados,CodEstado',
            'ciudad_destino' => 'required|string',
            'direccion_destino' => 'required|string',
            'estatus_envio' => 'required|in:registrado,en_transito,en_aduanas,entregado',
            'paquetes' => 'required|array',
            'paquetes.*' => 'exists:paquetes,PaqueteId',
            'descriptions' => 'required|array',
            'descriptions.*' => 'nullable|string',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
        ]);

        $envio->update([
            'cliente_dni' => $validated['cliente_dni'],
            'cliente_destino_dni' => $validated['cliente_destino_dni'],
            'fecha_envio' => $validated['fecha_envio'],
            'tracking_number' => $validated['tracking_number'],
            'destino_pais_id' => $validated['destino_pais_id'],
            'destino_estado_id' => $validated['destino_estado_id'],
            'ciudad_destino' => $validated['ciudad_destino'],
            'direccion_destino' => $validated['direccion_destino'],
            'estatus_envio' => $validated['estatus_envio'],
        ]);

        $paquetesData = [];
        foreach ($validated['paquetes'] as $index => $paqueteId) {
            $paquetesData[$paqueteId] = [
                'descripcion' => $validated['descriptions'][$index],
                'precio' => $validated['prices'][$index],
            ];
        }
        $envio->paquetes()->sync($paquetesData);

        return redirect()->route('envios.index')->with('success', 'Envío actualizado exitosamente.');
    }
}