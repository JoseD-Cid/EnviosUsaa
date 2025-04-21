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
        $envios = Envio::with('paquetes')->get();
        return view('envios.index', compact('envios'));
    }

    public function create()
    {
        $paises = Pais::all();
        $clientes = Cliente::where('IsDelete', 0)->where('Estatus', 1)->get();
    
        return view('envios.create', compact('paises', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_dni' => 'required|string|max:20',
            'fecha_envio' => 'required|date',
            'tracking_number' => 'required|unique:envios',
            'destino_pais_id' => 'nullable|exists:paises,CodPais',
            'destino_estado_id' => 'nullable|exists:estados,CodEstado',
            'ciudad_destino' => 'required|string',
            'direccion_destino' => 'required|string',
            'estatus_envio' => 'required|string',
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
    public function obtenerEstadosPorPais($paisId)
{
    $estados = Estado::where('CodPais', $paisId)
        ->where('IsDelete', 0)
        ->where('Estatus', 1)
        ->get();

    return response()->json($estados);
}

}
