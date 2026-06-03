<?php if (isset($component)) { $__componentOriginal4fd443eb599deecec11361a2f0d420e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fd443eb599deecec11361a2f0d420e0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::main-content','data' => ['title' => 'Início','heading' => 'Início']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::main-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Início','heading' => 'Início']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg text-center py-16 border border-zinc-200 dark:border-zinc-700">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-zinc-100">Bem-vindo à FunShirt! 👕</h1>
                <p class="mt-4 text-zinc-600 dark:text-zinc-400">A tua plataforma de t-shirts personalizadas.</p>
                
                <div class="mt-8">
                    <a href="<?php echo e(route('catalog.index')); ?>" class="px-6 py-3 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700 transition shadow-sm">
                        Ver Catálogo
                    </a>
                </div>
            </div>
        </div>
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\PROJETO\resources\views/home.blade.php ENDPATH**/ ?>