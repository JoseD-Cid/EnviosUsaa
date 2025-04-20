<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Pais;

class UbicacionController extends Controller
{
    public function obtenerEstados($id)
    {
        $estados = Estado::where('CodPais', $id)->get();
        return response()->json($estados);
    }
    public function crear()
    {
        $paises = Pais::all(); // o donde tengas guardados los países
        return view('clientes.crear', compact('paises'));
    }
}

