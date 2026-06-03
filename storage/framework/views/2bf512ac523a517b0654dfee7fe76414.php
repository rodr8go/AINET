<div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

    <div class="mb-8">
        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => ''.e(route('catalog.index')).'','icon' => 'arrow-left','variant' => 'subtle','class' => 'dark:text-zinc-400 dark:hover:text-zinc-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('catalog.index')).'','icon' => 'arrow-left','variant' => 'subtle','class' => 'dark:text-zinc-400 dark:hover:text-zinc-200']); ?>
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

    <div
        style="display: flex; flex-direction: row; align-items: flex-start; justify-content: center; width: 100%; gap: 40px;">

        <div class="bg-white rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-lg flex items-center justify-center p-8 relative"
            style="width: 380px !important; max-w: 380px !important; min-w: 380px !important; height: 400px !important; shrink: 0; flex-shrink: 0; overflow: hidden;">

            <div class="relative w-full h-full flex items-center justify-center"
                style="position: relative; width: 100%; height: 100%;">
                <img src="<?php echo e(asset('storage/tshirt_base/' . $selectedColor . '.jpg')); ?>"
                    style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; z-index: 10;"
                    alt="T-shirt Base">

                <div class="absolute z-20 flex items-center justify-center"
                    style="position: absolute; z-index: 20; top: 22%; left: 30%; width: 40%; height: 40%;">
                    <img src="<?php echo e(asset('storage/tshirt_images/' . $tshirt->image_url)); ?>" alt="<?php echo e($tshirt->name); ?>"
                        style="max-width: 100%; max-height: 100%; object-fit: contain;" class="drop-shadow-md">
                </div>
            </div>

            <div wire:loading
                class="absolute inset-0 bg-white/80 dark:bg-zinc-900/80 flex items-center justify-center z-30 rounded-2xl backdrop-blur-xs">
                <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['icon' => 'arrow-path','class' => 'w-8 h-8 animate-spin text-indigo-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'arrow-path','class' => 'w-8 h-8 animate-spin text-indigo-500']); ?>
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

        <div style="flex: 1; width: 100%;" class="space-y-6 pt-2">

            <div class="space-y-2">
                <h1 class="text-4xl font-black tracking-tight text-zinc-900 dark:text-zinc-100">
                    <?php echo e($tshirt->name); ?>

                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed max-w-lg">
                    <?php echo e($tshirt->description ?? 'Dê vida ao seu estilo com este design exclusivo. Algodão premium de alta durabilidade e estampa com definição reforçada.'); ?>

                </p>
            </div>

<div class="flex items-center gap-6 py-4 border-y border-zinc-200 dark:border-zinc-800 max-w-md">
        <div>
            <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-zinc-400 dark:text-zinc-500 mb-0.5">
                Preço Unitário
            </p>
            <div class="flex items-baseline gap-3 mt-0.5">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($priceRules && $qty >= $priceRules->qty_discount && $priceRules->unit_price_catalog_discount < $priceRules->unit_price_catalog): ?>
                    <p class="text-3xl font-black text-red-500 tabular-nums">
                        <?php echo e(number_format($priceRules->unit_price_catalog_discount, 2, ',', '.')); ?> €
                    </p>
                    <p class="text-sm font-semibold text-zinc-400 dark:text-zinc-500 line-through tabular-nums">
                        <?php echo e(number_format($priceRules->unit_price_catalog, 2, ',', '.')); ?> €
                    </p>
                <?php else: ?>
                    <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400 tabular-nums">
                        <?php echo e($priceRules ? number_format($priceRules->unit_price_catalog, 2, ',', '.') : '10,00'); ?> €
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <div class="text-xs text-zinc-400 dark:text-zinc-500 space-y-1 pl-6 border-l border-zinc-200 dark:border-zinc-800">
            <p>✓ Envio gratuito acima de 50€</p>
            <p>✓ Devolução em 30 dias</p>
        </div>
    </div>

    <form action="<?php echo e(route('cart.add', $tshirt->id)); ?>" method="POST" class="space-y-6 max-w-md pt-2">
        <?php echo csrf_field(); ?>

        <div class="space-y-2">
            <label class="block text-[11px] font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Cor</label>
            <select wire:model.live="selectedColor" name="color_code"
                    class="block w-full rounded-xl text-sm font-semibold border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 dark:text-zinc-100 py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition cursor-pointer" required>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($color->code); ?>"><?php echo e($color->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>

        <div class="space-y-2.5">
            <label class="block text-[11px] font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Tamanho</label>
            <div class="flex gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['XS','S','M','L','XL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <label class="relative cursor-pointer select-none">
                    <input type="radio" 
                           id="size_<?php echo e($size); ?>" 
                           name="size" 
                           value="<?php echo e($size); ?>" 
                           class="sr-only" 
                           wire:model.live="selectedSize">
                    <span class="flex items-center justify-center w-12 h-12 rounded-xl border-2 text-sm font-bold transition-all duration-150
                        <?php echo e($selectedSize === $size 
                            ? 'border-indigo-500 bg-indigo-600 text-white shadow-md shadow-indigo-600/20' 
                            : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-300 hover:border-zinc-400 dark:hover:border-zinc-500'); ?>">
                        <?php echo e($size); ?>

                    </span>
                </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-[11px] font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Quantidade</label>
            <div class="flex items-center gap-3">
                <input type="number" 
                       name="qty" 
                       min="1" 
                       max="10" 
                       wire:model.live="qty" 
                       class="w-20 rounded-xl text-sm font-bold text-center border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 dark:text-zinc-100 py-3 focus:ring-2 focus:ring-indigo-500 transition shadow-xs" required>
                <span class="text-xs text-zinc-400 dark:text-zinc-500 font-medium">
                    Desconto aplicado a partir de <?php echo e($priceRules?->qty_discount ?? 5); ?> unidades!
                </span>
            </div>
        </div>

        <div class="pt-2">
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['type' => 'submit','variant' => 'filled','color' => 'indigo','icon' => 'shopping-cart','class' => 'w-full text-base py-3.5 font-bold rounded-xl shadow-md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'filled','color' => 'indigo','icon' => 'shopping-cart','class' => 'w-full text-base py-3.5 font-bold rounded-xl shadow-md']); ?>
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