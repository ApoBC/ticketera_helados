@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-pink-200">
            <h2 class="text-2xl font-bold text-pink-600 text-center mb-6">Editar Perfil</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" name="name" id="name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500" 
                           value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500" 
                           value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300">
                    Actualizar Perfil
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-pink-100">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300" 
                            onclick="return confirm('¿Estás seguro de eliminar tu cuenta?')">
                        Eliminar Cuenta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection