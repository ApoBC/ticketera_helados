@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="card">
            <h2 class="text-2xl font-bold text-ink text-center mb-6">Iniciar Sesión</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative mb-4 text-sm">
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
                    <label for="email" class="block text-ink text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full h-14 px-4 text-lg border border-gray-200 rounded-xl focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink @error('email') border-red-400 @enderror" 
                           value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-ink text-sm font-semibold mb-2">Contraseña</label>
                    <input type="password" name="password" id="password" 
                           class="w-full h-14 px-4 text-lg border border-gray-200 rounded-xl focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink @error('password') border-red-400 @enderror" 
                           required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-ink w-full text-lg">
                    Ingresar
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-500 mt-4">
                ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-ink font-semibold hover:underline">Regístrate</a>
            </p>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-xs text-center text-gray-400">
                    <i class="fas fa-info-circle"></i>
                    Demo: admin@heladeria.com / admin123
                    <br>
                    vendedor@heladeria.com / vendedor123
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
