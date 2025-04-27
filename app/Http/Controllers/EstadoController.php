<?php

namespace App\Http\Controllers;

    use App\Models\Estado; // Importa el modelo Estado
    use Illuminate\Http\JsonResponse;

    class EstadoController extends Controller
    {
        public function obtenerEstadosPorPais($paisId): JsonResponse
        {
            $estados = Estado::where('CodPais', $paisId)->get();
            return response()->json($estados);
        }
        public function getByPais($paisId)
{
    $estados = Estado::where('pais_id', $paisId)->get();
    return response()->json($estados);
}
    }
