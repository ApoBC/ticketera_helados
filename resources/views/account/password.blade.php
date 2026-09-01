@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-pink-200">
            <h2 class="text-2xl font-bold text-pink-600 mb-1">🔑 Cambiar Contraseña</h2>
            <p class="text-sm text-gray-500 mb-6">{{ Auth::user()->name }}</p>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contraseña actual</label>
                    <input type="password" name="current_password" required autofocus
                           class="mt-1 block w-full h-14 px-4 text-lg rounded-lg border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                    <input type="password" name="password" required
                           class="mt-1 block w-full h-14 px-4 text-lg rounded-lg border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" required
                           class="mt-1 block w-full h-14 px-4 text-lg rounded-lg border-gray-300 shadow-sm">
                </div>

                <button type="submit" class="w-full h-14 bg-pink-500 hover:bg-pink-600 text-white text-lg font-bold rounded-full transition-all duration-300 active:scale-95">
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
