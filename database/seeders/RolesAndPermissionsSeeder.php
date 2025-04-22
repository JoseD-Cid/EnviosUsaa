<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Eliminar todos los datos existentes
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        // Permisos para usuarios
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver usuarios']);
        
        // Permisos para clientes
        Permission::create(['name' => 'crear clientes']);
        Permission::create(['name' => 'editar clientes']);
        Permission::create(['name' => 'eliminar clientes']);
        Permission::create(['name' => 'ver clientes']);
        
        // Permisos para envíos
        Permission::create(['name' => 'crear envios']);
        Permission::create(['name' => 'editar envios']);
        Permission::create(['name' => 'eliminar envios']);
        Permission::create(['name' => 'ver envios']);

        // Crear roles y asignar permisos
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        
        $role = Role::create(['name' => 'operador']);
        $role->givePermissionTo([
            'crear clientes', 'editar clientes', 'ver clientes',
            'crear envios', 'editar envios', 'ver envios'
        ]);
        
        $role = Role::create(['name' => 'visualizador']);
        $role->givePermissionTo([
            'ver clientes', 'ver envios'
        ]);

        // Asignar rol de admin al usuario test@example.com
        $user = \App\Models\User::where('email', 'test@example.com')->first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}