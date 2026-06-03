<?php if (isset($component)) { $__componentOriginal4fd443eb599deecec11361a2f0d420e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fd443eb599deecec11361a2f0d420e0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::main-content','data' => ['title' => 'Order #'.e($order->id).'','heading' => 'Order Details','subheading' => 'Order #'.e($order->id).' - '.e($order->created_at->format('d/m/Y')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::main-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Order #'.e($order->id).'','heading' => 'Order Details','subheading' => 'Order #'.e($order->id).' - '.e($order->created_at->format('d/m/Y')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    
    <?php
        // Debug - check if order has items
        $hasItems = $order->items && $order->items->count() > 0;
    ?>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$hasItems): ?>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 rounded-lg p-4 mb-4">
            <p class="text-yellow-800 dark:text-yellow-200">No items found for this order.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-white">Order Items</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Size
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Unit Price
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        
                                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden flex-shrink-0">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->tshirtImage && $item->tshirtImage->image_url): ?>
                                                <img src="<?php echo e(asset('storage/tshirt_images/' . $item->tshirtImage->image_url)); ?>" 
                                                     alt="<?php echo e($item->tshirtImage->name); ?>"
                                                     class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                <?php echo e($item->tshirtImage->name ?? 'Product Not Available'); ?>

                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Color: <?php echo e($item->color->name ?? $item->color_code); ?>

                                            </p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->tshirtImage && !$item->tshirtImage->isCatalogImage()): ?>
                                                <p class="text-xs text-purple-600 dark:text-purple-400">
                                                    Custom Image
                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        <?php echo e($item->size); ?>

                                    </span>
                                <td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="text-gray-900 dark:text-white"><?php echo e($item->qty); ?></span>
                                </td>
                                
                                <td class="px-4 py-3 text-right">
                                    <span class="text-gray-900 dark:text-white">€<?php echo e(number_format($item->unit_price, 2)); ?></span>
                                </td>
                                
                                <td class="px-4 py-3 text-right">
                                    <span class="font-medium text-gray-900 dark:text-white">€<?php echo e(number_format($item->sub_total, 2)); ?></span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No items found in this order.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->items && $order->items->count() > 0): ?>
                        <tfoot class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                                    Total:
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-lg text-indigo-600 dark:text-indigo-400">
                                    €<?php echo e(number_format($order->total_price, 2)); ?>

                                </td>
                            </tr>
                        </tfoot>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </table>
            </div>
        </div>
        
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                Order Information
            </h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Status:</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        <?php if($order->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                        <?php elseif($order->status == 'closed'): ?> bg-green-100 text-green-800
                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                        <?php echo e(ucfirst($order->status)); ?>

                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Order Date:</span>
                    <span class="text-gray-900 dark:text-white"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Customer:</span>
                    <span class="text-gray-900 dark:text-white"><?php echo e($order->customer->user->name ?? 'N/A'); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">NIF:</span>
                    <span class="text-gray-900 dark:text-white"><?php echo e($order->nif ?? 'N/A'); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Address:</span>
                    <span class="text-gray-900 dark:text-white text-right"><?php echo e($order->address ?? 'N/A'); ?></span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Payment:</span>
                    <span class="text-gray-900 dark:text-white"><?php echo e($order->payment_type ?? 'N/A'); ?></span>
                </div>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment_ref): ?>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Payment Ref:</span>
                    <span class="text-gray-900 dark:text-white text-right break-all"><?php echo e($order->payment_ref); ?></span>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->notes): ?>
                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400 block mb-1">Notes:</span>
                    <p class="text-gray-900 dark:text-white text-sm"><?php echo e($order->notes); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->reason_for_cancellation): ?>
                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-red-500 block mb-1">Cancellation Reason:</span>
                    <p class="text-red-600 dark:text-red-400 text-sm"><?php echo e($order->reason_for_cancellation); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            
            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700 space-y-2">
                <a href="<?php echo e(route('orders.my')); ?>" 
                   class="block w-full text-center bg-gray-600 text-white px-3 py-2 rounded-md hover:bg-gray-700 transition text-sm font-medium">
                    ← Back to My Orders
                </a>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->isClosed() && $order->getAttribute('receipt_url')): ?>
                    <a href="<?php echo e(route('orders.receipt', $order)); ?>" class="...">
                        Download Receipt (PDF)
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\PROJETO\resources\views/orders/show.blade.php ENDPATH**/ ?>