@extends('layouts.app')

@section('title', 'Panel Superadmin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="card">
            <div class="flex items-center mb-6">
                <div class="w-14 h-14 rounded-xl bg-ink flex items-center justify-center text-2xl mr-4">👑</div>
                <div>
                    <h2 class="text-2xl font-bold text-ink">Panel Superadmin</h2>
                    <p class="text-gray-500">Bienvenido, {{ Auth::user()->name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <a href="{{ route('admin.team.index') }}" class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-mint flex items-center justify-center text-2xl mb-3">👥</div>
                    <h3 class="font-bold text-ink">Gestionar Usuarios</h3>
                    <p class="text-sm text-gray-500">Crear admins y trabajadores, cambiar roles</p>
                </a>
                <a href="{{ route('admin.panel') }}" class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-mint flex items-center justify-center text-2xl mb-3">🍦</div>
                    <h3 class="font-bold text-ink">Panel Admin</h3>
                    <p class="text-sm text-gray-500">Gestión de productos y ventas</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
