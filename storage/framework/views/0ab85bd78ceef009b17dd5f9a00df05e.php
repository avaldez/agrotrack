<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('mensaje')): ?>
        <div class="mb-4 p-3 bg-agro-50 border border-agro-200 rounded-xl text-sm text-agro-700">
            <?php echo e(session('mensaje')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex justify-end mb-3">
        <button wire:click="$set('mostrarForm', true)"
            class="text-xs px-3 py-1.5 rounded-lg bg-agro-500 text-white font-medium">
            + Nuevo usuario
        </button>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostrarForm): ?>
        <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3"><?php echo e($editandoId ? 'Editar' : 'Nuevo'); ?> usuario</h3>
            <form wire:submit.prevent="guardar" class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nombre *</label>
                    <input type="text" wire:model="name"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Email *</label>
                    <input type="email" wire:model="email"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Rol</label>
                        <select wire:model="role"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                            <option value="Admin">Admin</option>
                            <option value="Tecnico">Técnico</option>
                            <option value="Consulta">Consulta</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Teléfono</label>
                        <input type="text" wire:model="telefono"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block"><?php echo e($editandoId ? 'Nueva contraseña' : 'Contraseña *'); ?></label>
                        <input type="password" wire:model="password"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Confirmar</label>
                        <input type="password" wire:model="password_confirmation"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-agro-500 text-white font-medium rounded-xl text-sm hover:bg-agro-600 transition">
                        Guardar
                    </button>
                    <button type="button" wire:click="resetForm"
                        class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm text-gray-500">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="space-y-2">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white border border-gray-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-800"><?php echo e($u->name); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$u->activo): ?>
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-400">Inactivo</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5"><?php echo e($u->email); ?></div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xs px-2 py-0.5 rounded-full font-medium
                            <?php echo e($u->role === 'Admin' ? 'bg-purple-100 text-purple-700' : ''); ?>

                            <?php echo e($u->role === 'Tecnico' ? 'bg-agro-50 text-agro-700' : ''); ?>

                            <?php echo e($u->role === 'Consulta' ? 'bg-gray-100 text-gray-600' : ''); ?>">
                            <?php echo e($u->role); ?>

                        </span>
                        <button wire:click="editar(<?php echo e($u->id); ?>)"
                            class="p-1 text-gray-300 hover:text-agro-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\livewire\admin\gestion-usuarios.blade.php ENDPATH**/ ?>