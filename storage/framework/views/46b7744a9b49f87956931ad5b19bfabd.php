<?php if (isset($component)) { $__componentOriginal4fd443eb599deecec11361a2f0d420e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fd443eb599deecec11361a2f0d420e0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::main-content','data' => ['title' => 'My Custom Images','heading' => 'As Minhas Imagens Personalizadas','subheading' => 'Faça a gestão das imagens que enviou para as suas t-shirts']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::main-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'My Custom Images','heading' => 'As Minhas Imagens Personalizadas','subheading' => 'Faça a gestão das imagens que enviou para as suas t-shirts']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-700 pb-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">As Minhas Imagens 📸</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Envie e gira as suas estampas exclusivas para aplicar nas t-shirts.</p>
            </div>
            <div>
                
                <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => ''.e(route('my-images.create')).'','variant' => 'filled','color' => 'indigo','icon' => 'plus','class' => 'cursor-pointer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('my-images.create')).'','variant' => 'filled','color' => 'indigo','icon' => 'plus','class' => 'cursor-pointer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Enviar Nova Imagem
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
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($images->isEmpty()): ?>
            <div class="py-16 mt-6 text-center bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700">
                <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['icon' => 'photo','class' => 'mx-auto w-16 h-16 text-zinc-300 dark:text-zinc-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'photo','class' => 'mx-auto w-16 h-16 text-zinc-300 dark:text-zinc-600']); ?>
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
                <h2 class="mt-4 text-xl font-semibold text-zinc-900 dark:text-zinc-100">Ainda não tem imagens personalizadas</h2>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Gostava de uma estampa única? Envie o seu primeiro ficheiro.</p>
            </div>
        <?php else: ?>
            
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="overflow-hidden bg-white rounded-xl border shadow-sm dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 flex flex-col justify-between">
                        
                        
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-900/50 flex items-center justify-center h-48 border-b border-zinc-100 dark:border-zinc-700">
                            <img src="<?php echo e(route('my-images.show-image', $image->id)); ?>" alt="<?php echo e($image->name); ?>" class="max-h-full max-w-full object-contain">
                        </div>

                        
                        <div class="p-4 space-y-4">
                            <span class="font-bold text-sm text-zinc-900 dark:text-zinc-100 truncate block">
                                <?php echo e($image->name ?? 'Imagem Sem Nome'); ?>

                            </span>
                            
                            
                            <form action="<?php echo e(route('cart.add', $image->id)); ?>" method="POST" class="space-y-3 border-t border-zinc-100 dark:border-zinc-700 pt-3">
                                <?php echo csrf_field(); ?>
                                
                                
                                <input type="hidden" name="qty" value="1">

                                <div class="grid grid-cols-2 gap-2">
                                    
                                    <div>
                                        <label class="block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Tamanho</label>
                                        <select name="size" required class="mt-1 block w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-xs px-2 py-1 text-zinc-900 dark:text-zinc-100 focus:outline-none">
                                            <option value="S">S</option>
                                            <option value="M" selected>M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                        </select>
                                    </div>

                                    
                                    <div>
                                        <label class="block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Cor</label>
                                        <select name="color_code" required class="mt-1 block w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-xs px-2 py-1 text-zinc-900 dark:text-zinc-100 focus:outline-none">
                                            <option value="1e1e21">Preto</option>
                                            <option value="e7e0ee">Branco sujo</option>
                                            <option value="284d9d">Azul</option>
                                            <option value="73336a">Roxo</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="flex items-center gap-2 pt-1">
                                    <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['type' => 'submit','variant' => 'filled','color' => 'indigo','icon' => 'shopping-cart','size' => 'sm','class' => 'flex-1 cursor-pointer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'filled','color' => 'indigo','icon' => 'shopping-cart','size' => 'sm','class' => 'flex-1 cursor-pointer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        Meter no Carrinho
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
                                    
                                    <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => '#','onclick' => 'if(confirm(\'Deseja apagar esta imagem?\')) { document.getElementById(\'delete-form-'.e($image->id).'\').submit(); } return false;','variant' => 'ghost','color' => 'red','icon' => 'trash','size' => 'sm','square' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '#','onclick' => 'if(confirm(\'Deseja apagar esta imagem?\')) { document.getElementById(\'delete-form-'.e($image->id).'\').submit(); } return false;','variant' => 'ghost','color' => 'red','icon' => 'trash','size' => 'sm','square' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

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

                            
                            <form id="delete-form-<?php echo e($image->id); ?>" action="<?php echo e(route('my-images.destroy', $image->id)); ?>" method="POST" class="hidden">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            </form>
                        </div>

                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fd443eb599deecec11361a2f0d420e0)): ?>
<?php $attributes = $__attributesOriginal4fd443eb599deecec11361a2f0d420e0; ?>
<?php unset($__attributesOriginal4fd443eb599deecec11361a2f0d420e0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fd443eb599deecec11361a2f0d420e0)): ?>
<?php $component = $__componentOriginal4fd443eb599deecec11361a2f0d420e0; ?>
<?php unset($__componentOriginal4fd443eb599deecec11361a2f0d420e0); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\PROJETO\resources\views/pages/my-images/index.blade.php ENDPATH**/ ?>