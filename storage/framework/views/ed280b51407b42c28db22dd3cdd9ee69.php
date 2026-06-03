<?php if (isset($component)) { $__componentOriginal4fd443eb599deecec11361a2f0d420e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fd443eb599deecec11361a2f0d420e0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::main-content','data' => ['title' => 'My Orders','heading' => 'My Orders','subheading' => 'View your order history']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::main-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'My Orders','heading' => 'My Orders','subheading' => 'View your order history']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->isEmpty()): ?>
            <div class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg font-medium mb-2">No orders yet</h3>
                <p class="text-gray-500 mb-4">You haven't placed any orders yet.</p>
                <a href="<?php echo e(route('catalog.index')); ?>" class="inline-flex px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Start Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Order #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    #<?php echo e($order->id); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($order->created_at->format('d/m/Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900 dark:text-white">
                                    €<?php echo e(number_format($order->total_price, 2)); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($order->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($order->status == 'closed'): ?> bg-green-100 text-green-800
                                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <?php echo e($orders->links()); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\PROJETO\resources\views/orders/myOrders.blade.php ENDPATH**/ ?>