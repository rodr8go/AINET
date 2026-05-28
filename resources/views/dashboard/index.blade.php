<x-layouts::main-content 
    title="Dashboard" 
    heading="Dashboard" 
    subheading="Welcome back, {{ $user->name }}! ({{ $userType }})">
    
    {{-- ===== ADMIN DASHBOARD ===== --}}
    @if($user->isAdmin())
        
        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Sales</p>
                        <p class="text-2xl font-bold text-green-600">€{{ number_format($totalSales, 2) }}</p>
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
                        <p class="text-2xl font-bold text-blue-600">€{{ number_format($salesThisMonth, 2) }}</p>
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
                        <p class="text-2xl font-bold text-orange-600">{{ $orderStats['pending'] }}</p>
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
                        <p class="text-2xl font-bold text-purple-600">{{ $userCounts['customers'] }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Monthly Sales Chart --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">Monthly Sales (Last 6 Months)</h3>
            <div class="space-y-2">
                @foreach($monthlySales as $data)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>{{ $data['month'] }}</span>
                            <span>€{{ number_format($data['sales'], 2) }}</span>
                        </div>
                        @php
                            $maxSales = max(array_column($monthlySales, 'sales'));
                            $percentage = $maxSales > 0 ? ($data['sales'] / $maxSales) * 100 : 0;
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Orders --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Recent Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentOrders as $order)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-medium">#{{ $order->id }} - {{ $order->customer?->user?->name ?? 'Deleted Customer' }}</p>
                                <p class="text-sm text-gray-500">{{ $order->date->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">€{{ number_format($order->total_price, 2) }}</p>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'closed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No orders found.</p>
                    @endforelse
                </div>
            </div>
            
            {{-- User & Catalog Stats --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Platform Overview</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Users</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span>Customers</span>
                                <span class="font-medium">{{ $userCounts['customers'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Employees</span>
                                <span class="font-medium">{{ $userCounts['employees'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Administrators</span>
                                <span class="font-medium">{{ $userCounts['admins'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Blocked Users</span>
                                <span class="font-medium text-red-600">{{ $userCounts['blocked'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 border-t">
                        <h4 class="font-medium text-gray-700 mb-2">Catalog</h4>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span>Catalog Images</span>
                                <span>{{ $catalogStats['total_images'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Custom Images</span>
                                <span>{{ $catalogStats['custom_images'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Categories</span>
                                <span>{{ $catalogStats['categories'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Colors</span>
                                <span>{{ $catalogStats['colors'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    {{-- ===== EMPLOYEE DASHBOARD ===== --}}
    @elseif($user->isEmployee())
        
        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-orange-600">{{ $pendingOrdersCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Processed This Month</p>
                <p class="text-2xl font-bold text-green-600">{{ $processedThisMonth }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Orders Today</p>
                <p class="text-2xl font-bold text-blue-600">{{ $todaysOrders }}</p>
            </div>
        </div>
        
        {{-- Pending Orders --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Orders to Process</h3>
                <a href="{{ route('employee.orders.pending') }}" class="text-sm text-blue-600 hover:underline">View All</a>
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
                        @forelse($pendingOrders as $order)
                            <tr class="border-b">
                                <td class="px-4 py-2">#{{ $order->id }}</td>
                                <td class="px-4 py-2">{{ $order->customer->user->name }}</td>
                                <td class="px-4 py-2">{{ $order->date->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-right">€{{ number_format($order->total_price, 2) }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">Process</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">No pending orders</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Recently Processed --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium mb-4">Recently Processed (Last 7 days)</h3>
            <div class="space-y-2">
                @forelse($recentClosed as $order)
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-medium">Order #{{ $order->id }} - {{ $order->customer->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->date->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">€{{ number_format($order->total_price, 2) }}</p>
                            <span class="text-xs text-green-600">Closed</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No orders processed recently</p>
                @endforelse
            </div>
        </div>
    
    {{-- ===== CUSTOMER DASHBOARD ===== --}}
    @elseif($user->isCustomer())
        
        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold">{{ $orderStats['total'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Total Spent</p>
                <p class="text-2xl font-bold text-green-600">€{{ number_format($totalSpent, 2) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Custom Images</p>
                <p class="text-2xl font-bold text-purple-600">{{ $customImagesCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-orange-600">{{ $orderStats['pending'] }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Recent Orders --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Recent Orders</h3>
                    <a href="{{ route('orders.my') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentOrders as $order)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-medium">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">{{ $order->date->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">€{{ number_format($order->total_price, 2) }}</p>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'closed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No orders yet</p>
                    @endforelse
                </div>
            </div>
            
            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('catalog') }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Browse Catalog
                    </a>
                    <a href="{{ route('my-images.index') }}" class="block w-full text-center bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                        My Custom Images
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        Edit Profile
                    </a>
                </div>
                @if(isset($lastOrder) && $lastOrder && $lastOrder->isClosed() && $lastOrder->receipt_url)
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ route('orders.receipt', $lastOrder) }}" class="text-sm text-blue-600 hover:underline">
                            Download Last Receipt →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    
    @endif
    
</x-layouts::main-content>