<?php $__env->startSection('title', 'Gestión de Equipo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-600">
                    👥 <?php echo e(Auth::user()->isSuperAdmin() ? 'Usuarios' : 'Mi equipo (vendedores)'); ?>

                </h2>
                <a href="<?php echo e(route('admin.team.create')); ?>" class="h-12 flex items-center bg-purple-600 text-white px-5 rounded-full text-sm font-semibold hover:bg-purple-700 active:scale-95 transition-transform">
                    + Nuevo <?php echo e(Auth::user()->isSuperAdmin() ? 'usuario' : 'vendedor'); ?>

                </a>
            </div>

            <?php if(session('success')): ?>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php if($users->isEmpty()): ?>
                <p class="text-gray-500 text-center py-8">
                    <?php if(Auth::user()->isSuperAdmin()): ?>
                        No hay usuarios todavía.
                    <?php else: ?>
                        Todavía no tienes vendedores registrados.
                    <?php endif; ?>
                </p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-500 text-sm">
                                <th class="py-2">Nombre</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Rol</th>
                                <th class="py-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b last:border-0">
                                    <td class="py-3"><?php echo e($user->name); ?></td>
                                    <td class="py-3 text-sm text-gray-500"><?php echo e($user->email); ?></td>
                                    <td class="py-3">
                                        <span class="text-xs px-2 py-1 rounded-full
                                            <?php if($user->role === 'superadmin'): ?> bg-purple-100 text-purple-600
                                            <?php elseif($user->role === 'admin'): ?> bg-yellow-100 text-yellow-700
                                            <?php else: ?> bg-blue-100 text-blue-600 <?php endif; ?>">
                                            <?php echo e($user->role); ?>

                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        <?php if($user->isSuperAdmin()): ?>
                                            <span class="text-xs text-gray-400">—</span>
                                        <?php else: ?>
                                            <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                                <a href="<?php echo e(route('admin.team.edit', $user)); ?>" class="text-blue-500 hover:text-blue-700 text-sm">Editar</a>

                                                <?php if(Auth::user()->isSuperAdmin()): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.team.updateRole', $user)); ?>" class="inline-flex items-center gap-1">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <select name="role" class="text-sm border rounded px-2 py-1" onchange="this.form.submit()">
                                                            <option value="vendedor" <?php if($user->role === 'vendedor'): echo 'selected'; endif; ?>>vendedor</option>
                                                            <option value="admin" <?php if($user->role === 'admin'): echo 'selected'; endif; ?>>admin</option>
                                                        </select>
                                                    </form>
                                                <?php endif; ?>

                                                <form method="POST" action="<?php echo e(route('admin.team.destroy', $user)); ?>" class="inline" onsubmit="return confirm('¿Eliminar a <?php echo e($user->name); ?>?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\HeladeriaC\ticketera_helados\resources\views/admin/team/index.blade.php ENDPATH**/ ?>