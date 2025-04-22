<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->get();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('roles.index', compact('users', 'roles', 'permissions'));
    }
    
    public function editUserRoles($id): View
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        
        return view('roles.edit-user', compact('user', 'roles'));
    }
    
    public function updateUserRoles(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'roles' => 'array',
        ]);
        
        $user->syncRoles($request->input('roles', []));
        
        return redirect()->route('roles.index')->with('success', 'Roles asignados exitosamente.');
    }
    
    public function editRole($id): View
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        
        return view('roles.edit-role', compact('role', 'permissions'));
    }
    
    public function updateRole(Request $request, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'permissions' => 'array',
        ]);
        
        $role->syncPermissions($request->input('permissions', []));
        
        return redirect()->route('roles.index')->with('success', 'Permisos actualizados exitosamente.');
    }
    
    public function createRole(): View
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }
    
    public function storeRole(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);
        
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions', []));
        
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }
    
    public function deleteRole($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol de administrador.');
        }
        
        $role->delete();
        
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
