@extends('layouts.app')

@section('title', 'Nuevo Ticket')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-yellow-200 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="text-4xl mr-4">🧾</div>
                    <div>
                        <h2 class="text-2xl font-bold text-yellow-600">Nuevo Ticket</h2>
                        <p class="text-gray-600">Selecciona productos para crear un pedido</p>
                    </div>
                </div>
               <a href="{{ route('vendedor.dashboard') }}" 
   class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-full text-sm transition-all duration-300">
    <i class="fas fa-arrow-left"></i> Volver
</a>
            </div>
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('vendedor.tickets.store') }}" id="ticketForm">
            @csrf
            
            <!-- Cliente -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-gray-200 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    <i class="fas fa-user text-yellow-500"></i> Datos del Cliente
                </h3>
                <div>
                    <label for="customer_name" class="block text-gray-700 text-sm font-bold mb-2">
                        Nombre del Cliente <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="customer_name" id="customer_name" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500 @error('customer_name') border-red-500 @enderror" 
                           value="{{ old('customer_name') }}" required autofocus>
                    @error('customer_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Productos -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-gray-200 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    <i class="fas fa-ice-cream text-yellow-500"></i> Productos
                </h3>
                
                <!-- Grid de productos -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
                    @foreach($products as $product)
                        <div class="product-card border border-gray-200 rounded-xl p-3 hover:border-yellow-400 hover:shadow-md transition-all cursor-pointer"
                             data-id="{{ $product->id }}"
                             data-name="{{ $product->name }}"
                             data-price="{{ $product->base_price }}"
                             onclick="addProductToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->base_price }})">
                            <div class="text-2xl text-center mb-1">
                                @if($product->category === 'helado') 🍦
                                @elseif($product->category === 'postre') 🍰
                                @elseif($product->category === 'bebida') 🥤
                                @else 📦
                                @endif
                            </div>
                            <div class="text-sm font-semibold text-gray-800 text-center">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 text-center">{{ $product->category }}</div>
                            <div class="text-sm font-bold text-yellow-600 text-center">S/ {{ number_format($product->base_price, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <!-- Carrito de productos seleccionados -->
                <div class="border-t border-gray-200 pt-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-shopping-cart text-yellow-500"></i> Carrito
                        <span id="cartCount" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">0</span>
                    </h4>
                    
                    <div id="cartItems" class="space-y-2">
                        <p class="text-gray-400 text-sm text-center py-4">No hay productos seleccionados</p>
                    </div>
                    
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                        <div>
                            <span class="text-sm text-gray-600">Total:</span>
                            <span id="cartTotal" class="text-xl font-bold text-yellow-600">S/ 0.00</span>
                        </div>
                        <button type="button" onclick="clearCart()" 
                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-full text-sm">
                            <i class="fas fa-trash"></i> Vaciar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Botón Guardar -->
            <button type="submit" id="submitBtn" disabled
        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-full transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
    <i class="fas fa-save"></i> Crear Ticket
</button>
        </form>
    </div>
</div>

<!-- JavaScript para manejar el carrito -->
<script>
    let cart = [];

    function addProductToCart(id, name, price) {
        // Buscar si el producto ya está en el carrito
        const existing = cart.find(item => item.id === id);
        
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                quantity: 1
            });
        }
        
        updateCartUI();
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        updateCartUI();
    }

    function updateQuantity(id, change) {
        const item = cart.find(item => item.id === id);
        if (item) {
            item.quantity = Math.max(1, item.quantity + change);
            updateCartUI();
        }
    }

    function updateCartUI() {
        const cartContainer = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartCount = document.getElementById('cartCount');
        const submitBtn = document.getElementById('submitBtn');
        
        if (cart.length === 0) {
            cartContainer.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">No hay productos seleccionados</p>';
            cartTotal.textContent = 'S/ 0.00';
            cartCount.textContent = '0';
            submitBtn.disabled = true;
            return;
        }
        
        let html = '';
        let total = 0;
        let count = 0;
        
        cart.forEach(item => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            count += item.quantity;
            
            html += `
                <div class="flex justify-between items-center bg-gray-50 rounded-lg p-3">
                    <div class="flex-1">
                        <div class="font-medium text-gray-800">${item.name}</div>
                        <div class="text-sm text-gray-500">S/ ${item.price.toFixed(2)} x ${item.quantity}</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="updateQuantity(${item.id}, -1)" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-6 h-6 rounded-full text-sm">
                            -
                        </button>
                        <span class="text-sm font-semibold w-6 text-center">${item.quantity}</span>
                        <button type="button" onclick="updateQuantity(${item.id}, 1)" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-6 h-6 rounded-full text-sm">
                            +
                        </button>
                        <button type="button" onclick="removeFromCart(${item.id})" 
                                class="text-red-500 hover:text-red-700 ml-2">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <input type="hidden" name="items[${item.id}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${item.id}][quantity]" value="${item.quantity}">
                </div>
            `;
        });
        
        cartContainer.innerHTML = html;
        cartTotal.textContent = `S/ ${total.toFixed(2)}`;
        cartCount.textContent = count;
        submitBtn.disabled = false;
    }

    function clearCart() {
        if (confirm('¿Vaciar el carrito?')) {
            cart = [];
            updateCartUI();
        }
    }
</script>

<style>
    .product-card {
        transition: all 0.2s ease;
        user-select: none;
    }
    .product-card:hover {
        transform: translateY(-2px);
    }
    .product-card:active {
        transform: scale(0.95);
    }
</style>
@endsection