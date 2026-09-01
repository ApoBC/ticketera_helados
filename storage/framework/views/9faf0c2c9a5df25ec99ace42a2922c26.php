<?php $__env->startSection('title', 'Cambiar Contraseña'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-pink-200">
            <h2 class="text-2xl font-bold text-pink-600 mb-1">🔑 Cambiar Contraseña</h2>
            <p class="text-sm text-gray-500 mb-6"><?php echo e(Auth::user()->name); ?></p>

            <?php if(session('success')): ?>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('account.password.update')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/account/password.blade.php ENDPATH**/ ?>