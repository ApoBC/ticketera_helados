<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-pink-200">
            <div class="flex items-center mb-6">
                <div class="text-4xl mr-4">📊</div>
                <div>
                    <h2 class="text-2xl font-bold text-pink-600">Dashboard</h2>
                    <p class="text-gray-600">Bienvenido, <?php echo e(Auth::user()->name); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e(date('d/m/Y H:i')); ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-xl p-6 shadow-md">
                    <div class="text-3xl mb-2">👑</div>
                    <h3 class="font-bold text-gray-700">Panel de Administración</h3>
                    <p class="text-sm text-gray-600">Gestionar sistema</p>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.panel')); ?>" 
                           class="inline-block mt-3 bg-pink-500 hover:bg-pink-600 text-white py-2 px-6 rounded-full text-sm transition-all duration-300">
                            Ir al Panel
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl p-6 shadow-md">
                    <div class="text-3xl mb-2">🍦</div>
                    <h3 class="font-bold text-gray-700">Dashboard Vendedor</h3>
                    <p class="text-sm text-gray-600">Gestión de ventas</p>
                    <?php if(Auth::user()->role === 'vendedor'): ?>
                        <a href="<?php echo e(route('vendedor.dashboard')); ?>" 
                           class="inline-block mt-3 bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-6 rounded-full text-sm transition-all duration-300">
                            Ir al Dashboard
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/dashboard.blade.php ENDPATH**/ ?>