<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PackagePermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos para paquetes
        $packagePermissions = [
            'crear paquetes',
            'editar paquetes',
            'eliminar paquetes',
            'ver paquetes'
        ];

        foreach ($packagePermissions as $permission) {
            // Crear solo si no existe ya
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar permisos a los roles existentes
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($packagePermissions);
        }

        $operadorRole = Role::where('name', 'operador')->first();
        if ($operadorRole) {
            $operadorRole->givePermissionTo([
                'crear paquetes', 
                'editar paquetes', 
                'ver paquetes'
            ]);
        }

        $visualizadorRole = Role::where('name', 'visualizador')->first();
        if ($visualizadorRole) {
            $visualizadorRole->givePermissionTo('ver paquetes');
        }

        $this->command->info('Permisos de paquetes creados y asignados correctamente.');
    }
}
