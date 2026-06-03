<div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

    <div class="mb-8">
        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => ''.e(route('catalog.index')).'','icon' => 'arrow-left','variant' => 'subtle','class' => 'text-zinc-400 hover:text-zinc-200 bg-transparent border-transparent hover:bg-zinc-800/50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('catalog.index')).'','icon' => 'arrow-left','variant' => 'subtle','class' => 'text-zinc-400 hover:text-zinc-200 bg-transparent border-transparent hover:bg-zinc-800/50']); ?>
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

    <div class="bg-zinc-900/60 border border-transparent rounded-3xl p-6 lg:p-8 w-full shadow-2xl backdrop-blur-md">
        
        <div class="flex flex-col lg:flex-row items-start justify-between gap-12 lg:gap-24 w-full">

            <div class="shrink-0 mx-auto lg:mx-0" style="width: 400px;">
                <div class="bg-zinc-950/40 rounded-2xl border border-transparent shadow-inner flex items-center justify-center p-8 relative"
                     style="height: 420px;">
                    
                    <div class="relative w-full h-full flex items-center justify-center">
                        <img src="<?php echo e(asset('storage/tshirt_base/' . $selectedColor . '.jpg')); ?>"
                             class="absolute inset-0 w-full h-full object-contain z-10"
                             alt="T-shirt Base">
                        
                        <div class="absolute z-20 flex items-center justify-center"
                             style="top: 22%; left: 30%; width: 40%; height: 40%;">
                            <img src="<?php echo e(asset('storage/tshirt_images/' . $tshirt->image_url)); ?>"
                                 alt="<?php echo e($tshirt->name); ?>"
                                 class="max-w-full max-h-full object-contain drop-shadow-md">
                        </div>
                    </div>

                    <div wire:loading class="absolute inset-0 bg-zinc-950/80 flex items-center justify-center z-30 rounded-2xl backdrop-blur-xs">
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
            </div>

            <div class="flex-1 w-full space-y-6 pt-2 lg:max-w-xl">

                <div class="space-y-3 pb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-indigo-600/20 text-indigo-400 border border-indigo-500/30">
                        <?php echo e($tshirt->category?->name ?? 'Música'); ?>

                    </span>
                    
                    <h1 class="text-4xl font-black tracking-tight text-zinc-100">
                        <?php echo e($tshirt->name); ?>

                    </h1>
                    
                    <p class="text-sm text-zinc-400 leading-relaxed">
                        <?php echo e($tshirt->description ?? 'Dê vida ao seu estilo com este design exclusivo. Algodão premium de alta durabilidade e estampa com definição reforçada.'); ?>

                    </p>
                </div>

                <form action="<?php echo e(route('cart.add', $tshirt->id)); ?>" method="POST" class="space-y-6 w-full max-w-md">
                    <?php echo csrf_field(); ?>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400">Cor da T-Shirt</label>
                        <select wire:model.live="selectedColor" name="color_code"
                                class="block w-full rounded-xl text-sm font-semibold border border-zinc-800 bg-zinc-800 text-zinc-100 py-3 px-4 focus:ring-2 focus:ring-indigo-500 transition cursor-pointer shadow-md" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($color->code); ?>"><?php echo e($color->name); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div class="space-y-2.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400">Tamanho</label>
                        <div class="flex gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['XS','S','M','L','XL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <label class="relative cursor-pointer select-none">
                                <input type="radio" id="size_<?php echo e($size); ?>" name="size" value="<?php echo e($size); ?>" class="sr-only" wire:model.live="selectedSize">
                                <span class="flex items-center justify-center w-12 h-12 rounded-xl border border-zinc-800 text-sm font-bold transition-all duration-150
                                    <?php echo e($selectedSize === $size 
                                        ? 'border-indigo-500 bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' 
                                        : 'bg-zinc-800 text-zinc-300 hover:bg-zinc-700/50'); ?>">
                                    <?php echo e($size); ?>

                                </span>
                            </label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    <div class="space-y-2" x-data="{ count: <?php if ((object) ('qty') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('qty'->value()); ?>')<?php echo e('qty'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('qty'); ?>')<?php endif; ?>.live }">
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-400">Quantidade</label>
                        <div class="flex items-center bg-zinc-800 border border-zinc-800 w-fit rounded-xl p-1 shadow-md">
                            <button type="button" @click="if(count > 1) count--" 
                                    class="w-10 h-10 flex items-center justify-center text-zinc-400 hover:text-zinc-100 hover:bg-zinc-700 rounded-lg font-bold transition select-none">
                                -
                            </button>
                            
                            <input type="number" name="qty" x-model="count" min="1" max="10" readonly
                                   class="w-12 text-center bg-transparent border-0 text-zinc-100 font-black focus:ring-0 p-0 text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            
                            <button type="button" @click="if(count < 10) count++" 
                                    class="w-10 h-10 flex items-center justify-center text-zinc-400 hover:text-zinc-100 hover:bg-zinc-700 rounded-lg font-bold transition select-none">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <p class="text-xs font-bold tracking-wider uppercase text-zinc-400">Preço unitário:</p>
                        <div class="flex items-baseline gap-3 mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($priceRules && $qty >= $priceRules->qty_discount && $priceRules->unit_price_catalog_discount < $priceRules->unit_price_catalog): ?>
                                <p class="text-4xl font-black text-emerald-400 tracking-tight tabular-nums">
                                    <?php echo e(number_format($priceRules->unit_price_catalog_discount, 2, ',', '.')); ?> €
                                </p>
                                <p class="text-base font-semibold text-zinc-500 line-through tabular-nums">
                                    <?php echo e(number_format($priceRules->unit_price_catalog, 2, ',', '.')); ?> €
                                </p>
                            <?php else: ?>
                                <p class="text-4xl font-black text-zinc-100 tracking-tight tabular-nums">
                                    <?php echo e($priceRules ? number_format($priceRules->unit_price_catalog, 2, ',', '.') : '10,00'); ?> €
                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="pt-2">
                        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['type' => 'submit','variant' => 'filled','color' => 'zinc','icon' => 'shopping-cart','class' => 'w-full bg-white hover:bg-zinc-200 text-zinc-950 font-extrabold text-base py-4 rounded-xl shadow-lg border-transparent transition-all transform active:scale-[0.99] justify-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'filled','color' => 'zinc','icon' => 'shopping-cart','class' => 'w-full bg-white hover:bg-zinc-200 text-zinc-950 font-extrabold text-base py-4 rounded-xl shadow-lg border-transparent transition-all transform active:scale-[0.99] justify-center']); ?>
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
        
    </div>
</div><?php /**PATH C:\laragon\www\PROJETO\resources\views/catalog/product-show.blade.php ENDPATH**/ ?>