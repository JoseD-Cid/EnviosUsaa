<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ClienteController extends Controller
{
    public function crear(): View
    {
        $paises = Pais::with('estados')->get();
        return view('clientes.crear', compact('paises'));
    }

    public function guardar(Request $request): RedirectResponse
    {
    $request->validate([
        'Dni' => 'required|unique:clientes|max:20',
        'Nombres' => 'required|max:50',
        'Apellidos' => 'required|max:50',
        'PrimerTelefono' => 'required|regex:/^[0-9]+$/|max:20', // Solo números
        'SegundoTelefono' => 'nullable|regex:/^[0-9]+$/|max:20', // Solo números (opcional)
        'PaisID' => 'required|exists:paises,CodPais', // Debe existir en la tabla paises
        'EstadoID' => 'required|exists:estados,CodEstado,CodPais,' . $request->input('PaisID'), // Debe existir en la tabla estados y pertenecer al PaisID seleccionado
        'Municipio' => 'required|max:50',
        'Direccion' => 'required|max:200',
    ]);

    Cliente::create($request->all());

    return redirect()->route('clientes.ver')->with('success', 'Cliente creado.');
    }

    public function ver(Request $request): View
{
    $query = Cliente::query()->where('IsDelete', 0)->with('estado.pais');

    if ($request->has('nombre') && $request->filled('nombre')) {
        $query->where(function ($q) use ($request) {
            $q->where('Nombres', 'like', '%' . $request->input('nombre') . '%')
              ->orWhere('Apellidos', 'like', '%' . $request->input('nombre') . '%');
        });
    }

    if ($request->has('pais') && $request->filled('pais')) {
        $paisId = $request->input('pais');
        $query->whereHas('estado', function ($q) use ($paisId) {
            $q->whereHas('pais', function ($subQuery) use ($paisId) {
                $subQuery->where('CodPais', $paisId);
            });
        });
    }

    if ($request->has('estado') && $request->filled('estado')) {
        $query->where('EstadoID', $request->input('estado'));
    }

    $clientes = $query->paginate(10);
    $paises = Pais::all();
    $estados = Estado::all();

    return view('clientes.ver', compact('clientes', 'paises', 'estados'));
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
    $paises = Pais::all(); // Obtén todos los países
    $estados = Estado::all(); // Obtén todos los estados
    return view('clientes.editar', compact('cliente', 'paises', 'estados'));
    }   

    public function actualizar(Request $request, string $dni): RedirectResponse
    {
    $cliente = Cliente::findOrFail($dni);

    $request->validate([
        'Nombres' => 'required|max:50',
        'Apellidos' => 'required|max:50',
        'PrimerTelefono' => 'required|regex:/^[0-9]+$/|max:20', // Solo números
        'SegundoTelefono' => 'nullable|regex:/^[0-9]+$/|max:20', // Solo números (opcional)
        'EstadoID' => 'nullable|exists:estados,CodEstado',
        'Municipio' => 'nullable|max:50',
        'Direccion' => 'required|max:255',
    ]);

    $cliente->update($request->except('Dni'));

    return redirect()->route('clientes.ver')->with('success', 'Cliente actualizado.');
    }

    public function eliminar(string $dni): RedirectResponse
    {
        $cliente = Cliente::findOrFail($dni);
        $cliente->update(['IsDelete' => 1]);
        return redirect()->route('clientes.ver')->with('success', 'Cliente eliminado.');
    }
    public function buscar(Request $request): JsonResponse
{
    $query = $request->input('q');
    
    if (empty($query) || strlen($query) < 2) {
        return response()->json([]);
    }
    
    $clientes = Cliente::where('IsDelete', 0)
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
}