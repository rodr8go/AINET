<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use App\Models\TshirtImage;
use App\Models\Color;
use App\Models\Customer;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    protected $receiptService;
    
    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }
    
    public function store(CheckoutRequest $request)
    {
        // ... your existing checkout logic
        
        // After creating the order
        $order = DB::transaction(function () use ($user, $cart, $total, $request, $priceSettings) {
            // ... your order creation code
            
            return $order;
        });
        
        // Send pending order email (type = 'pending', no receipt)
        $this->receiptService->sendOrderEmail($order, 'pending');
        
        // Clear the cart
        session()->forget('cart');
        
        return redirect()->route('orders.show', $order)
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Order placed successfully! Check your email for confirmation.');
    }
}