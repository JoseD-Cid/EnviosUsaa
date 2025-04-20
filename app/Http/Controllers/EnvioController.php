<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Paquete;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    public function index()
{
    // Cargar relaciones con nombres correctos
    $envios = Envio::with(['pais', 'estado', 'paquetes', 'cliente'])->get();
    
    return view('envios.index', compact('envios'));
}

public function create()
{
    $clientes = Cliente::where('IsDelete', 0)
                      ->where('Estatus', 1)
                      ->get(); // Agrega esto para depuración
                      
    // dd($clientes); // Descomenta para ver los resultados

    $paises = Pais::all();
    return view('envios.create', compact('paises', 'clientes'));
}

    public function store(Request $request)
    {
        $request->validate([
            'cliente_dni' => 'required|string|max:20',
            'fecha_envio' => 'required|date',
            'tracking_number' => 'required|unique:envios',
            'destino_pais_id' => 'nullable|integer',
            'destino_estado_id' => 'nullable|integer',
            'ciudad_destino' => 'required|string',
            'direccion_destino' => 'required|string',
            'estatus_envio' => 'required|string',

            // Validar paquetes como array
            'paquetes.*.descripcion' => 'required|string',
            'paquetes.*.peso' => 'required|integer',
            'paquetes.*.valor_declarado' => 'required|integer',
        ]);

        $envio = Envio::create($request->except('paquetes'));

        foreach ($request->paquetes as $paqueteData) {
            $envio->paquetes()->create($paqueteData);
        }

        return redirect()->route('envios.index')->with('success', '¡Envío creado con paquetes!');
    }
}
