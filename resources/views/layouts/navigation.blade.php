<nav class="bg-white/80 backdrop-blur-sm shadow-lg border-b border-pink-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-2xl mr-2">🍦</span>
                    <span class="text-xl font-bold text-pink-600">Heladería</span>
                </a>
            </div>

            <!-- Menú de navegación -->
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                    <span class="text-xs px-2 py-1 rounded-full bg-pink-100 text-pink-600">
                        {{ Auth::user()->role }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-pink-600 hover:text-pink-800">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-800">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>