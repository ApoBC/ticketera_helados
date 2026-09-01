<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * El admin solo puede gestionar vendedores (su equipo). El superadmin
     * puede gestionar a todos. Este helper decide qué puede tocar quién.
     */
    private function actorCanManage(User $target): bool
    {
        if (auth()->user()->isSuperAdmin()) {
            return true;
        }

        // Un admin (no superadmin) solo puede gestionar vendedores
        return $target->isVendedor();
    }

    // Listado de usuarios: superadmin ve a todos, admin ve solo a su equipo (vendedores)
    public function index()
    {
        $query = User::orderBy('role')->orderBy('name');

        if (!auth()->user()->isSuperAdmin()) {
            $query->where('role', 'vendedor');
        }

        $users = $query->get();
        return view('admin.team.index', compact('users'));
    }

    // Formulario para crear un nuevo usuario
    public function create()
    {
        // El admin (no superadmin) solo puede crear vendedores, así que no se le
        // muestra el selector de rol.
        $canAssignAdmin = auth()->user()->isSuperAdmin();
        return view('admin.team.create', compact('canAssignAdmin'));
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $isSuperAdmin = auth()->user()->isSuperAdmin();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($isSuperAdmin) {
            $rules['role'] = ['required', Rule::in(['admin', 'vendedor'])];
        }

        $validated = $request->validate($rules);

        // Un admin (no superadmin) siempre crea vendedores, sin importar qué
        // le manden en el formulario.
        $role = $isSuperAdmin ? $validated['role'] : 'vendedor';

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'Usuario creado correctamente');
    }

    // Formulario para editar nombre/email de un usuario existente
    public function edit(User $user)
    {
        if (!$this->actorCanManage($user)) {
            abort(403, 'No tienes permiso para editar a este usuario.');
        }

        return view('admin.team.edit', compact('user'));
    }

    // Actualizar nombre/email (y opcionalmente contraseña) de un usuario
    public function update(Request $request, User $user)
    {
        if (!$this->actorCanManage($user)) {
            abort(403, 'No tienes permiso para editar a este usuario.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return redirect()->route('admin.team.index')
            ->with('success', "Datos de {$user->name} actualizados");
    }

    // Cambiar el rol de un usuario existente (exclusivo del superadmin)
    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Solo el superadmin puede cambiar roles.');
        }

        $validated = $request->validate([
            'role' => ['required', Rule::in(['admin', 'vendedor'])],
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes cambiar tu propio rol de superadmin.');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Rol de {$user->name} actualizado a {$validated['role']}");
    }

    // Eliminar un usuario (el admin solo puede eliminar vendedores)
    public function destroy(User $user)
    {
        if (!$this->actorCanManage($user)) {
            abort(403, 'No tienes permiso para eliminar a este usuario.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'No se puede eliminar a un superadmin.');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado');
    }
}
