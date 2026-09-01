@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-200">
            <h2 class="text-2xl font-bold text-purple-600 mb-1">Editar Usuario</h2>
            <p class="text-sm text-gray-500 mb-6">{{ $user->name }} · <span class="text-xs">{{ $user->role }}</span></p>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.team.update', $user) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="mt-1 block w-full h-12 px-3 rounded-lg border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="mt-1 block w-full h-12 px-3 rounded-lg border-gray-300 shadow-sm">
                </div>

                <div class="border-t pt-4">
                    <p class="text-xs text-gray-500 mb-2">Dejar en blanco para no cambiar la contraseña.</p>
                    <label class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                    <input type="password" name="password"
                           class="mt-1 block w-full h-12 px-3 rounded-lg border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation"
                           class="mt-1 block w-full h-12 px-3 rounded-lg border-gray-300 shadow-sm">
                </div>

                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('admin.team.index') }}" class="text-sm text-gray-500">Cancelar</a>
                    <button type="submit" class="h-12 px-6 bg-purple-600 text-white rounded-lg hover:bg-purple-700 active:scale-95 transition-transform">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
