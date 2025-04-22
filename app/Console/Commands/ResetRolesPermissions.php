<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetRolesPermissions extends Command
{
    protected $signature = 'roles:reset';
    protected $description = 'Reset all roles and permissions data';

    public function handle()
    {
        if ($this->confirm('¿Estás seguro? Esto eliminará TODOS los roles y permisos existentes.')) {
            Schema::disableForeignKeyConstraints();
            
            DB::table('role_has_permissions')->truncate();
            DB::table('model_has_roles')->truncate();
            DB::table('model_has_permissions')->truncate();
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();
            
            Schema::enableForeignKeyConstraints();
            
            $this->info('Roles y permisos han sido eliminados correctamente.');
            
            if ($this->confirm('¿Deseas ejecutar el seeder de roles y permisos ahora?')) {
                $this->call('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
            }
        }
    }
}