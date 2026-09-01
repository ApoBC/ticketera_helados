@extends('layouts.app')

@section('title', 'Gestión de Equipo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-600">
                    👥 {{ Auth::user()->isSuperAdmin() ? 'Usuarios' : 'Mi equipo (vendedores)' }}
                </h2>
                <a href="{{ route('admin.team.create') }}" class="h-12 flex items-center bg-purple-600 text-white px-5 rounded-full text-sm font-semibold hover:bg-purple-700 active:scale-95 transition-transform">
                    + Nuevo {{ Auth::user()->isSuperAdmin() ? 'usuario' : 'vendedor' }}
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4">{{ session('error') }}</div>
            @endif

            @if ($users->isEmpty())
                <p class="text-gray-500 text-center py-8">
                    @if (Auth::user()->isSuperAdmin())
                        No hay usuarios todavía.
                    @else
                        Todavía no tienes vendedores registrados.
                    @endif
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-500 text-sm">
                                <th class="py-2">Nombre</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Rol</th>
                                <th class="py-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b last:border-0">
                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="py-3">
                                        <span class="text-xs px-2 py-1 rounded-full
                                            @if($user->role === 'superadmin') bg-purple-100 text-purple-600
                                            @elseif($user->role === 'admin') bg-yellow-100 text-yellow-700
                                            @else bg-blue-100 text-blue-600 @endif">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        @if ($user->isSuperAdmin())
                                            <span class="text-xs text-gray-400">—</span>
                                        @else
                                            <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                                <a href="{{ route('admin.team.edit', $user) }}" class="text-blue-500 hover:text-blue-700 text-sm">Editar</a>

                                                @if (Auth::user()->isSuperAdmin())
                                                    <form method="POST" action="{{ route('admin.team.updateRole', $user) }}" class="inline-flex items-center gap-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="role" class="text-sm border rounded px-2 py-1" onchange="this.form.submit()">
                                                            <option value="vendedor" @selected($user->role === 'vendedor')>vendedor</option>
                                                            <option value="admin" @selected($user->role === 'admin')>admin</option>
                                                        </select>
                                                    </form>
                                                @endif

                                                <form method="POST" action="{{ route('admin.team.destroy', $user) }}" class="inline" onsubmit="return confirm('¿Eliminar a {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
