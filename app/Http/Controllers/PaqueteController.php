<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PaqueteController extends Controller
{
    /**
     * Mostrar listado de paquetes
     */
    public function index(): View
    {
        $paquetes = Paquete::all();
        return view('paquetes.index', compact('paquetes'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        return view('paquetes.create');
    }

    /**
     * Almacenar un nuevo paquete
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'NombrePaquete' => 'required|string|max:100',
            'dimension' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
        ]);

        Paquete::create($request->all());

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete creado exitosamente.');
    }

    /**
     * Mostrar un paquete específico
     */
    public function show(Paquete $paquete): View
    {
        return view('paquetes.show', compact('paquete'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Paquete $paquete): View
    {
        return view('paquetes.edit', compact('paquete'));
    }

    /**
     * Actualizar un paquete existente
     */
    public function update(Request $request, Paquete $paquete): RedirectResponse
    {
        $request->validate([
            'NombrePaquete' => 'required|string|max:100',
            'dimension' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
        ]);

        $paquete->update($request->all());

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete actualizado exitosamente.');
    }

    /**
     * Eliminar un paquete
     */
    public function destroy(Paquete $paquete): RedirectResponse
    {
        // Verificar si el paquete está en uso en algún envío
        if ($paquete->envios()->count() > 0) {
            return redirect()->route('paquetes.index')
                ->with('error', 'No se puede eliminar el paquete porque está asociado a uno o más envíos.');
        }

        $paquete->delete();

        return redirect()->route('paquetes.index')
            ->with('success', 'Paquete eliminado exitosamente.');
    }
}
