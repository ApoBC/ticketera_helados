@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-pink-200">
            <h2 class="text-2xl font-bold text-pink-600 text-center mb-6">Iniciar Sesión</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500 @error('email') border-red-500 @enderror" 
                           value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500 @error('password') border-red-500 @enderror" 
                           required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 transform hover:scale-105">
                    Ingresar
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-600 mt-4">
                ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-pink-600 hover:text-pink-800">Regístrate</a>
            </p>

            <div class="mt-6 pt-6 border-t border-pink-100">
                <p class="text-xs text-center text-gray-500">
                    <i class="fas fa-info-circle text-pink-400"></i>
                    Demo: admin@heladeria.com / admin123
                    <br>
                    vendedor@heladeria.com / vendedor123
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
