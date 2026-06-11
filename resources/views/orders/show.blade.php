<x-layouts::main-content title="Order #{{ $order->id }}" heading="Order Details" subheading="Order #{{ $order->id }} - {{ $order->date ? \Carbon\Carbon::parse($order->date)->format('d/m/Y') : $order->created_at->format('d/m/Y') }}">
    
    @php
        $hasItems = $order->items && $order->items->count() > 0;
    @endphp
    
    @if(!$hasItems)
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 rounded-lg p-4 mb-4">
            <p class="text-yellow-800 dark:text-yellow-200">No items found for this order.</p>
        </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Order Items Table --}}
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
                        @forelse($order->items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        {{-- Product Image --}}
                                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden flex-shrink-0">
                                            @if($item->tshirtImage && $item->tshirtImage->image_url)
                                                <img src="{{ asset('storage/tshirt_images/' . $item->tshirtImage->image_url) }}" 
                                                     alt="{{ $item->tshirtImage->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        {{-- Product Name --}}
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                {{ $item->tshirtImage->name ?? 'Product Not Available' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Color: {{ $item->color->name ?? $item->color_code }}
                                            </p>
                                            @if($item->tshirtImage && !$item->tshirtImage->isCatalogImage())
                                                <p class="text-xs text-purple-600 dark:text-purple-400">
                                                    Custom Image
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        {{ $item->size }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="text-gray-900 dark:text-white">{{ $item->qty }}</span>
                                </td>
                                
                                <td class="px-4 py-3 text-right">
                                    <span class="text-gray-900 dark:text-white">€{{ number_format($item->unit_price, 2) }}</span>
                                </td>
                                
                                <td class="px-4 py-3 text-right">
                                    <span class="font-medium text-gray-900 dark:text-white">€{{ number_format($item->sub_total, 2) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No items found in this order.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                    @if($hasItems)
                        <tfoot class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                                    Total:
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-lg text-indigo-600 dark:text-indigo-400">
                                    €{{ number_format($order->total_price, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
        
        {{-- Order Information Sidebar --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                Order Information
            </h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Status:</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'closed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Order Date:</span>
                    <span class="text-gray-900 dark:text-white">
                        {{ $order->date ? \Carbon\Carbon::parse($order->date)->format('d/m/Y') : $order->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Customer:</span>
                    <span class="text-gray-900 dark:text-white">{{ $order->customer->user->name ?? 'N/A' }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">NIF:</span>
                    <span class="text-gray-900 dark:text-white">{{ $order->nif ?? 'N/A' }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Address:</span>
                    <span class="text-gray-900 dark:text-white text-right">{{ $order->address ?? 'N/A' }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Payment:</span>
                    <span class="text-gray-900 dark:text-white">{{ $order->payment_type ?? 'N/A' }}</span>
                </div>
                
                @if($order->payment_ref)
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Payment Ref:</span>
                    <span class="text-gray-900 dark:text-white text-right break-all">{{ $order->payment_ref }}</span>
                </div>
                @endif
                
                @if($order->notes)
                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400 block mb-1">Notes:</span>
                    <p class="text-gray-900 dark:text-white text-sm">{{ $order->notes }}</p>
                </div>
                @endif
                
                @if($order->reason_for_cancellation)
                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-red-500 block mb-1">Cancellation Reason:</span>
                    <p class="text-red-600 dark:text-red-400 text-sm">{{ $order->reason_for_cancellation }}</p>
                </div>
                @endif
            </div>
            
            {{-- Action Buttons --}}
            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700 space-y-2">
                <a href="{{ route('orders.my') }}" 
                   class="block w-full text-center bg-gray-600 text-white px-3 py-2 rounded-md hover:bg-gray-700 transition text-sm font-medium">
                    ← Back to My Orders
                </a>
                
                @if($order->status === 'closed' || $order->status === 'paid')
                    <a href="{{ route('orders.receipt', $order) }}" 
                       class="block w-full text-center bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 transition text-sm font-medium shadow-sm">
                        Download Receipt (PDF)
                    </a>
                @endif
            </div>
        </div>
    </div>
    
</x-layouts::main-content>