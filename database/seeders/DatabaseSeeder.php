<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ejecutar seeder de roles y permisos
        $this->call(RolesAndPermissionsSeeder::class);

        // Asignar rol al usuario
        $user->assignRole('admin');
    }
}
