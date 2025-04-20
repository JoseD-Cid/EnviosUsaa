<?php

namespace App\Http\Controllers;

use App\Models\Estado; // Asegúrate de importar el modelo Estado
use Illuminate\Http\Request;

class PaisController extends Controller
{
    // Método para obtener los estados de un país específico
    public function getEstados($id)
    {
        // Buscamos los estados donde el CodPais sea igual al ID proporcionado
        $estados = Estado::where('CodPais', $id)
                         ->where('Estatus', 1)   // Solo activos
                         ->where('IsDelete', 0)  // No eliminados
                         ->get();

        // Retornamos la respuesta como JSON
        return response()->json($estados);
    }
}

