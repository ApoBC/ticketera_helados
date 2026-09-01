<?php $__env->startSection('title', 'Ticket #' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Cabecera -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-yellow-200 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="text-4xl mr-4">🧾</div>
                    <div>
                        <h2 class="text-2xl font-bold text-yellow-600">Ticket #<?php echo e($ticket->ticket_number); ?></h2>
                        <p class="text-gray-600">Cliente: <?php echo e($ticket->customer_name); ?></p>
                        <p class="text-sm text-gray-500"><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></p>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-user"></i> Registrado por: <?php echo e($ticket->user->name ?? 'Usuario eliminado'); ?>

                        </p>
                    </div>
                </div>
                <div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold 
                        <?php if($ticket->status === 'abierto'): ?> bg-yellow-100 text-yellow-800
                        <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                        <?php echo e(ucfirst($ticket->status)); ?>

                    </span>
                </div>
            </div>
        </div>

        <!-- Mensajes -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Agregar producto (solo si está abierto) -->
        <?php if($ticket->status === 'abierto'): ?>
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 border-2 border-dashed border-yellow-200">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">
                    <i class="fas fa-plus-circle text-green-500"></i> Agregar Producto
                </h4>

                <form action="<?php echo e(route('tickets.items.store', $ticket)); ?>" method="POST" id="addItemForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" id="selected_product_id">
                    <input type="hidden" name="quantity" id="selected_quantity" value="1">

                    <!-- Pestañas de categoría -->
                    <div class="flex flex-wrap gap-2 mb-4" id="categoryTabs">
                        <button type="button" data-category="todos"
                                class="cat-tab px-5 py-3 rounded-full font-semibold text-sm border-2 border-yellow-400 bg-yellow-400 text-white">
                            Todos
                        </button>
                        <?php $__currentLoopData = $products->pluck('category')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-category="<?php echo e($cat); ?>"
                                    class="cat-tab px-5 py-3 rounded-full font-semibold text-sm border-2 border-yellow-300 text-yellow-700 bg-white">
                                <?php echo e(ucfirst($cat)); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Grilla de productos (tarjetas grandes, táctiles) -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-5" id="productGrid">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button"
                                    data-category="<?php echo e($product->category); ?>"
                                    data-id="<?php echo e($product->id); ?>"
                                    data-name="<?php echo e($product->name); ?>"
                                    data-price="<?php echo e($product->base_price); ?>"
                                    <?php if($product->isOutOfStock()): echo 'disabled'; endif; ?>
                                    class="product-tile min-h-[110px] rounded-2xl border-2 border-gray-200 p-3 flex flex-col items-center justify-center text-center transition-all
                                           active:scale-95 hover:border-yellow-400 hover:shadow-md
                                           disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:border-gray-200">
                                <div class="text-3xl mb-1">
                                    <?php if($product->category === 'helado'): ?> 🍦
                                    <?php elseif($product->category === 'topping'): ?> 🍫
                                    <?php elseif($product->category === 'postre'): ?> 🍰
                                    <?php elseif($product->category === 'bebida'): ?> 🥤
                                    <?php else: ?> 📦
                                    <?php endif; ?>
                                </div>
                                <div class="text-sm font-bold text-gray-800 leading-tight"><?php echo e($product->name); ?></div>
                                <div class="text-sm font-semibold text-yellow-600">S/ <?php echo e(number_format($product->base_price, 2)); ?></div>
                                <?php if($product->isOutOfStock()): ?>
                                    <div class="text-xs font-bold text-red-500 mt-1">AGOTADO</div>
                                <?php elseif($product->isLowStock()): ?>
                                    <div class="text-xs font-bold text-orange-500 mt-1">Quedan <?php echo e($product->stock); ?></div>
                                <?php endif; ?>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Producto seleccionado + cantidad (aparece al elegir un producto) -->
                    <div id="selectionPanel" class="hidden bg-yellow-50 rounded-2xl p-4 flex items-center justify-between gap-4 flex-wrap">
                        <div>
                            <p class="text-xs text-gray-500">Producto seleccionado</p>
                            <p id="selectedProductName" class="text-lg font-bold text-gray-800">—</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" id="qtyMinus"
                                    class="w-14 h-14 rounded-full bg-gray-200 hover:bg-gray-300 text-2xl font-bold text-gray-700 active:scale-90 transition-transform">
                                −
                            </button>
                            <span id="qtyDisplay" class="text-2xl font-bold w-10 text-center">1</span>
                            <button type="button" id="qtyPlus"
                                    class="w-14 h-14 rounded-full bg-gray-200 hover:bg-gray-300 text-2xl font-bold text-gray-700 active:scale-90 transition-transform">
                                +
                            </button>
                        </div>

                        <button type="submit"
                                class="flex-1 sm:flex-none min-w-[180px] h-14 bg-green-500 hover:bg-green-600 text-white font-bold text-lg rounded-full transition-all active:scale-95">
                            <i class="fas fa-check"></i> Agregar al ticket
                        </button>
                    </div>
                </form>
            </div>

            <script>
                (function () {
                    const grid = document.getElementById('productGrid');
                    const tabs = document.getElementById('categoryTabs');
                    const panel = document.getElementById('selectionPanel');
                    const nameEl = document.getElementById('selectedProductName');
                    const qtyDisplay = document.getElementById('qtyDisplay');
                    const productIdInput = document.getElementById('selected_product_id');
                    const quantityInput = document.getElementById('selected_quantity');
                    let qty = 1;

                    // Filtrar por categoría
                    tabs.addEventListener('click', function (e) {
                        const btn = e.target.closest('.cat-tab');
                        if (!btn) return;

                        tabs.querySelectorAll('.cat-tab').forEach(t => {
                            t.classList.remove('bg-yellow-400', 'text-white', 'border-yellow-400');
                            t.classList.add('bg-white', 'text-yellow-700', 'border-yellow-300');
                        });
                        btn.classList.add('bg-yellow-400', 'text-white', 'border-yellow-400');
                        btn.classList.remove('bg-white', 'text-yellow-700', 'border-yellow-300');

                        const category = btn.dataset.category;
                        grid.querySelectorAll('.product-tile').forEach(tile => {
                            tile.style.display = (category === 'todos' || tile.dataset.category === category) ? '' : 'none';
                        });
                    });

                    // Seleccionar producto
                    grid.addEventListener('click', function (e) {
                        const tile = e.target.closest('.product-tile');
                        if (!tile || tile.disabled) return;

                        grid.querySelectorAll('.product-tile').forEach(t => t.classList.remove('border-yellow-500', 'bg-yellow-50', 'ring-2', 'ring-yellow-400'));
                        tile.classList.add('border-yellow-500', 'bg-yellow-50', 'ring-2', 'ring-yellow-400');

                        productIdInput.value = tile.dataset.id;
                        nameEl.textContent = tile.dataset.name;
                        qty = 1;
                        qtyDisplay.textContent = qty;
                        quantityInput.value = qty;
                        panel.classList.remove('hidden');
                        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    });

                    // Stepper de cantidad
                    document.getElementById('qtyMinus').addEventListener('click', function () {
                        qty = Math.max(1, qty - 1);
                        qtyDisplay.textContent = qty;
                        quantityInput.value = qty;
                    });
                    document.getElementById('qtyPlus').addEventListener('click', function () {
                        qty += 1;
                        qtyDisplay.textContent = qty;
                        quantityInput.value = qty;
                    });
                })();
            </script>
        <?php endif; ?>

        <!-- Items del ticket -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <i class="fas fa-list text-yellow-500 mr-2"></i> Productos
                <span class="ml-2 text-sm text-gray-500">(<?php echo e($ticket->items->count()); ?>)</span>
            </h3>

            <?php if($ticket->items->isEmpty()): ?>
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <p class="text-gray-500">No hay productos en este ticket</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Producto</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Cant.</th>
                                <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">Precio</th>
                                <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ticket->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-100 hover:bg-yellow-50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-800"><?php echo e($item->product_name); ?></td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-600"><?php echo e($item->quantity); ?></td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-600">S/ <?php echo e(number_format($item->unit_price, 2)); ?></td>
                                    <td class="px-4 py-3 text-sm text-right font-bold text-yellow-600">S/ <?php echo e(number_format($item->subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-t-2 border-gray-300 bg-gray-50">
                                <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-700">TOTAL</td>
                                <td class="px-4 py-3 text-right font-bold text-yellow-600 text-lg">S/ <?php echo e(number_format($ticket->total, 2)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Acciones -->
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="<?php echo e(route('vendedor.dashboard')); ?>" class="h-14 flex items-center bg-gray-500 hover:bg-gray-600 text-white text-base font-semibold py-2 px-6 rounded-full transition-all duration-300 active:scale-95">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
            
            <a href="<?php echo e(route('tickets.print', $ticket)); ?>" target="_blank" class="h-14 flex items-center bg-blue-500 hover:bg-blue-600 text-white text-base font-semibold py-2 px-6 rounded-full transition-all duration-300 active:scale-95">
                <i class="fas fa-print mr-2"></i> Imprimir
            </a>

            <?php if($ticket->status === 'abierto'): ?>
                <form method="POST" action="<?php echo e(route('tickets.close', $ticket)); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="h-14 flex items-center bg-green-500 hover:bg-green-600 text-white text-base font-semibold py-2 px-6 rounded-full transition-all duration-300 active:scale-95" 
                            onclick="return confirm('¿Cerrar este ticket?')">
                        <i class="fas fa-check mr-2"></i> Cerrar Ticket
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/tickets/show.blade.php ENDPATH**/ ?>