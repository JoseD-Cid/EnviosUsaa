<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse; // Importar JsonResponse

class ClienteController extends Controller
{
    public function crear(): View
    {
        $paises = Pais::with('estados.municipios')->get();
        return view('clientes.crear', compact('paises'));
    }

    public function guardar(Request $request): RedirectResponse
    {
        $request->validate([
            'Dni' => 'required|unique:clientes|max:20',
            'Nombres' => 'required|max:255',
            'Apellidos' => 'required|max:255',
            'PrimerTelefono' => 'required|max:20',
            'SegundoTelefono' => 'nullable|max:20',
            'CodMunicipio' => 'nullable|exists:municipios,CodMunicipio',
            'Direccion' => 'required|max:255',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.ver')->with('success', 'Cliente creado.');
    }

    public function ver(): View
    {
        $clientes = Cliente::with('municipio.estado.pais')->get();
        return view('clientes.ver', compact('clientes'));
    }

    public function obtenerDireccionMunicipio(Request $request, $codMunicipio): JsonResponse
    {
        $municipio = Municipio::find($codMunicipio);

        if (!$municipio) {
            return response()->json(['error' => 'Municipio no encontrado'], 404);
        }

        return response()->json(['direccion' => $municipio->Direccion]);
    }

    public function editar(string $dni): View
    {
        $cliente = Cliente::findOrFail($dni);
        return view('clientes.editar', compact('cliente'));
    }

    public function actualizar(Request $request, string $dni): RedirectResponse
{
    $cliente = Cliente::findOrFail($dni);

    $request->validate([
        'Dni' => [
            'required',
            'unique:clientes,Dni,' . $cliente->Dni . ',Dni', // Añadimos ',Dni' al final
            'max:20'
        ],
        'Nombres' => 'required|max:50',
        'Apellidos' => 'required|max:50',
        'PrimerTelefono' => 'required|max:20',
        'SegundoTelefono' => 'nullable|max:20',
        'CodMunicipio' => 'nullable|exists:municipios,CodMunicipio',
        'Direccion' => 'required|max:200',
    ]);

    $cliente->update($request->all());

    return redirect()->route('clientes.ver')->with('success', 'Cliente actualizado.');
}

public function eliminar(string $dni): RedirectResponse
{
    $cliente = Cliente::findOrFail($dni);
    $cliente->update(['IsDelete' => 1]); // Marcamos el cliente como "eliminado"
    return redirect()->route('clientes.ver')->with('success', 'Cliente eliminado.');
}

}