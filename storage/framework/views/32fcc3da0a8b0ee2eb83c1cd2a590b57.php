<?php if (isset($component)) { $__componentOriginal4fd443eb599deecec11361a2f0d420e0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fd443eb599deecec11361a2f0d420e0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::main-content','data' => ['title' => 'Dashboard','heading' => 'Dashboard','subheading' => 'Welcome back, '.e($user->name).'! ('.e($userType).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::main-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard','heading' => 'Dashboard','subheading' => 'Welcome back, '.e($user->name).'! ('.e($userType).')']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->isAdmin()): ?>
        
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Sales</p>
                        <p class="text-2xl font-bold text-green-600">€<?php echo e(number_format($totalSales, 2)); ?></p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sales This Month</p>
                        <p class="text-2xl font-bold text-blue-600">€<?php echo e(number_format($salesThisMonth, 2)); ?></p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending Orders</p>
                        <p class="text-2xl font-bold text-orange-600"><?php echo e($orderStats['pending']); ?></p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Customers</p>
                        <p class="text-2xl font-bold text-purple-600"><?php echo e($userCounts['customers']); ?></p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">Monthly Sales (Last 6 Months)</h3>
            <div class="space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $monthlySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span><?php echo e($data['month']); ?></span>
                            <span>€<?php echo e(number_format($data['sales'], 2)); ?></span>
                        </div>
                        <?php
                            $maxSales = max(array_column($monthlySales, 'sales'));
                            $percentage = $maxSales > 0 ? ($data['sales'] / $maxSales) * 100 : 0;
                        ?>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Recent Orders</h3>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-medium">#<?php echo e($order->id); ?> - <?php echo e($order->customer?->user?->name ?? 'Deleted Customer'); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($order->date->format('d/m/Y')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">€<?php echo e(number_format($order->total_price, 2)); ?></p>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    <?php if($order->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($order->status == 'closed'): ?> bg-green-100 text-green-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <p class="text-gray-500">No orders found.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Platform Overview</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Users</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span>Customers</span>
                                <span class="font-medium"><?php echo e($userCounts['customers']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Employees</span>
                                <span class="font-medium"><?php echo e($userCounts['employees']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Administrators</span>
                                <span class="font-medium"><?php echo e($userCounts['admins']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Blocked Users</span>
                                <span class="font-medium text-red-600"><?php echo e($userCounts['blocked']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 border-t">
                        <h4 class="font-medium text-gray-700 mb-2">Catalog</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span>Catalog Images</span>
                                <span><?php echo e($catalogStats['total_images']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Custom Images</span>
                                <span><?php echo e($catalogStats['custom_images']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Categories</span>
                                <span><?php echo e($catalogStats['categories']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Colors</span>
                                <span><?php echo e($catalogStats['colors']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
    <?php elseif($user->isEmployee()): ?>
        
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-orange-600"><?php echo e($pendingOrdersCount); ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Processed This Month</p>
                <p class="text-2xl font-bold text-green-600"><?php echo e($processedThisMonth); ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Orders Today</p>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($todaysOrders); ?></p>
            </div>
        </div>
        
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Orders to Process</h3>
                <a href="<?php echo e(route('employee.orders.pending')); ?>" class="text-sm text-blue-600 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Order #</th>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-right">Total</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b">
                                <td class="px-4 py-2">#<?php echo e($order->id); ?></td>
                                <td class="px-4 py-2"><?php echo e($order->customer->user->name); ?></td>
                                <td class="px-4 py-2"><?php echo e($order->date->format('d/m/Y')); ?></td>
                                <td class="px-4 py-2 text-right">€<?php echo e(number_format($order->total_price, 2)); ?></td>
                                <td class="px-4 py-2 text-center">
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="text-blue-600 hover:underline">Process</a>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">No pending orders</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Recently Processed (Last 7 days)</h3>
            <div class="space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentClosed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-medium">Order #<?php echo e($order->id); ?> - <?php echo e($order->customer->user->name); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($order->date->format('d/m/Y')); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">€<?php echo e(number_format($order->total_price, 2)); ?></p>
                            <span class="text-xs text-green-600">Closed</span>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <p class="text-gray-500 text-center py-4">No orders processed recently</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    
    
    <?php elseif($user->isCustomer()): ?>
        
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold"><?php echo e($orderStats['total']); ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Total Spent</p>
                <p class="text-2xl font-bold text-green-600">€<?php echo e(number_format($totalSpent, 2)); ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Custom Images</p>
                <p class="text-2xl font-bold text-purple-600"><?php echo e($customImagesCount); ?></p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-orange-600"><?php echo e($orderStats['pending']); ?></p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Recent Orders</h3>
                    <a href="<?php echo e(route('orders.my')); ?>" class="text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-medium">Order #<?php echo e($order->id); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($order->date->format('d/m/Y')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">€<?php echo e(number_format($order->total_price, 2)); ?></p>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    <?php if($order->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($order->status == 'closed'): ?> bg-green-100 text-green-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <p class="text-gray-500 text-center py-4">No orders yet</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="<?php echo e(route('catalog')); ?>" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Browse Catalog
                    </a>
                    <a href="<?php echo e(route('my-images.index')); ?>" class="block w-full text-center bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                        My Custom Images
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block w-full text-center bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        Edit Profile
                    </a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($lastOrder) && $lastOrder && $lastOrder->isClosed() && $lastOrder->receipt_url): ?>
                    <div class="mt-4 pt-4 border-t">
                        <a href="<?php echo e(route('orders.receipt', $lastOrder)); ?>" class="text-sm text-blue-600 hover:underline">
                            Download Last Receipt →
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fd443eb599deecec11361a2f0d420e0)): ?>
<?php $attributes = $__attributesOriginal4fd443eb599deecec11361a2f0d420e0; ?>
<?php unset($__attributesOriginal4fd443eb599deecec11361a2f0d420e0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fd443eb599deecec11361a2f0d420e0)): ?>
<?php $component = $__componentOriginal4fd443eb599deecec11361a2f0d420e0; ?>
<?php unset($__componentOriginal4fd443eb599deecec11361a2f0d420e0); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\PROJETO\resources\views/dashboard/index.blade.php ENDPATH**/ ?>