<?php $__env->startSection('title', 'Panel Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="card">
            <div class="flex items-center mb-6">
                <div class="w-14 h-14 rounded-xl bg-ink flex items-center justify-center text-2xl mr-4">🍦</div>
                <div>
                    <h2 class="text-2xl font-bold text-ink">Panel Admin</h2>
                    <p class="text-gray-500">Bienvenido, <?php echo e(Auth::user()->name); ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 transition-all duration-300 relative">
                    <?php if(($lowStockCount ?? 0) > 0): ?>
                        <span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            <?php echo e($lowStockCount); ?> ⚠️
                        </span>
                    <?php endif; ?>
                    <div class="w-12 h-12 rounded-xl bg-mint flex items-center justify-center text-2xl mb-3">🛒</div>
                    <h3 class="font-bold text-ink">Productos</h3>
                    <p class="text-sm text-gray-500">Crear, editar y poner precios a helados, toppings, bebidas y postres</p>
                </a>
                <a href="<?php echo e(route('admin.tickets.index')); ?>" class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-mint flex items-center justify-center text-2xl mb-3">📋</div>
                    <h3 class="font-bold text-ink">Tickets del día</h3>
                    <p class="text-sm text-gray-500">Ver pedidos registrados hoy</p>
                </a>
                <a href="<?php echo e(route('admin.reports.daily')); ?>" class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-mint flex items-center justify-center text-2xl mb-3">📊</div>
                    <h3 class="font-bold text-ink">Ventas del día</h3>
                    <p class="text-sm text-gray-500">Resumen por trabajador y por producto</p>
                </a>
                <a href="<?php echo e(route('admin.team.index')); ?>" class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md hover:border-gray-200 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-mint flex items-center justify-center text-2xl mb-3">👥</div>
                    <h3 class="font-bold text-ink">Mi Equipo</h3>
                    <p class="text-sm text-gray-500">Agregar y editar vendedores</p>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/admin/panel.blade.php ENDPATH**/ ?>