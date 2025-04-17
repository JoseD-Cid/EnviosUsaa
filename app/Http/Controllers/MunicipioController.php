<?php

namespace App\Http\Controllers;

    use App\Models\Municipio; // Importa el modelo Municipio
    use Illuminate\Http\JsonResponse;

    class MunicipioController extends Controller
    {
        public function obtenerMunicipiosPorEstado($estadoId): JsonResponse
        {
            $municipios = Municipio::where('CodEstado', $estadoId)->get();
            return response()->json($municipios);
        }
    }
