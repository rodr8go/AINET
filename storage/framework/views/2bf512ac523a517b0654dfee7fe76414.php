<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
    <div class="mb-8">
        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => ''.e(route('catalog.index')).'','icon' => 'arrow-left','variant' => 'subtle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('catalog.index')).'','icon' => 'arrow-left','variant' => 'subtle']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            Voltar ao Catálogo
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <div class="lg:col-span-5 w-full max-w-md">
            <div class="relative bg-white aspect-square flex items-center justify-center p-6 overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                
                <div class="relative w-full h-full flex items-center justify-center">
                    <img src="<?php echo e(asset('storage/tshirt_base/' . $selectedColor . '.jpg')); ?>" 
                         class="absolute top-0 left-0 w-full h-full object-contain z-10" 
                         alt="T-shirt Base">
                    
                    <div class="absolute z-20 flex items-center justify-center" 
                         style="top: 22%; left: 30%; width: 40%; height: 40%;">
                        <img src="<?php echo e(asset('storage/tshirt_images/' . $tshirt->image_url)); ?>" 
                             alt="<?php echo e($tshirt->name); ?>" 
                             class="max-w-full max-h-full object-contain drop-shadow-sm">
                    </div>
                </div>

                <div wire:loading class="absolute inset-0 bg-white/70 flex items-center justify-center z-30 rounded-xl">
                    <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['icon' => 'arrow-path','class' => 'w-8 h-8 animate-spin text-indigo-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'arrow-path','class' => 'w-8 h-8 animate-spin text-indigo-600']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 w-full space-y-6">
            
            <div class="space-y-3">
                <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-zinc-100">
                    <?php echo e($tshirt->name); ?>

                </h1>
                <p class="text-base text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    <?php echo e($tshirt->description ?? 'Sem descrição disponível para este produto.'); ?>

                </p>
            </div>

            <div class="bg-zinc-100 dark:bg-zinc-900/50 p-4 rounded-xl w-fit border border-zinc-200 dark:border-zinc-800">
                <p class="text-xs font-bold tracking-wider uppercase text-zinc-500 dark:text-zinc-400">Preço Unitário</p>
                <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-1">19,90 €</p>
            </div>

            <form action="<?php echo e(route('cart.add', $tshirt->id)); ?>" method="POST" class="pt-6 border-t border-zinc-200 dark:border-zinc-700 space-y-6">
                <?php echo csrf_field(); ?>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-2">Cor</label>
                        <select wire:model.live="selectedColor" 
                                name="color_code" 
                                class="block w-full rounded-lg text-sm border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 py-2.5 px-3 shadow-xs focus:ring-2 focus:ring-indigo-500 transition cursor-pointer" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($color->code); ?>"><?php echo e($color->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-2">Tamanho</label>
                        <select name="size" 
                                class="block w-full rounded-lg text-sm border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 py-2.5 px-3 shadow-xs focus:ring-2 focus:ring-indigo-500 transition cursor-pointer" required>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M" selected>M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-2">Quantidade</label>
                        <input type="number" 
                               name="qty" 
                               min="1" 
                               max="10" 
                               value="1" 
                               class="block w-full rounded-lg text-sm border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 py-2 px-3 shadow-xs focus:ring-2 focus:ring-indigo-500 transition" required>
                    </div>
                </div>

                <div class="pt-2">
                    <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['type' => 'submit','variant' => 'filled','color' => 'indigo','icon' => 'shopping-cart','class' => 'w-full text-base py-4 font-bold shadow-md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'filled','color' => 'indigo','icon' => 'shopping-cart','class' => 'w-full text-base py-4 font-bold shadow-md']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        Adicionar ao Carrinho
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                </div>
            </form>
        </div>

    </div>
</div><?php /**PATH C:\laragon\www\PROJETO\resources\views/catalog/product-show.blade.php ENDPATH**/ ?>