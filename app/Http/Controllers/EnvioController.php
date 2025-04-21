<?php


namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Paquete;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cliente; // <- ¡Aquí es donde debe ir!
use Illuminate\Http\Request;
use App\Models\DestinoPais;
use App\Models\DestinoEstado;


class EnvioController extends Controller
{
    public function index()
    {
        $envios = Envio::with(['paquetes', 'cliente', 'destino_pais'])->get();
        return view('envios.index', compact('envios'));
    }
    

    public function create()
    {
        $paises = \App\Models\Pais::all();
        $clientes = \App\Models\Cliente::where('IsDelete', 0)->where('Estatus', 1)->get();
    
        return view('envios.create', compact('paises', 'clientes'));
    }
    

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
            'paquetes.*.descripcion' => 'required|string',
            'paquetes.*.peso' => 'required|numeric|min:0',
            'paquetes.*.valor_declarado' => 'required|numeric|min:0',
        ]);
    
        // Generar tracking único
        $tracking = 'TRK' . strtoupper(uniqid());
    
        $data = $request->except('paquetes');
        $data['tracking_number'] = $tracking;
    
        $envio = \App\Models\Envio::create($data);
    
        foreach ($request->paquetes as $paquete) {
            $envio->paquetes()->create($paquete);
        }
    
        return redirect()->route('envios.index')->with('success', '¡Envío creado correctamente!');
    }
    
    
    public function obtenerEstadosPorPais($paisId)
{
    $estados = Estado::where('CodPais', $paisId)
        ->where('IsDelete', 0)
        ->where('Estatus', 1)
        ->get();

    return response()->json($estados);
}


}
