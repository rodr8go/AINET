<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class OrderController extends Controller
{
    protected ReceiptService $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    /**
     * Display a listing of the user's own orders (customer view)
     */
    public function myOrders(): View
    {
        $user = Auth::user();

        // Ensure the authenticated user has an associated customer record
        if (!$user || !$user->customer) {
            abort(403, 'Only customers can view orders.');
        }

        $customer = $user->customer;

        $orders = Order::where('customer_id', $customer->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.myOrders', compact('orders'));
    }

    /**
     * Display the specified order (customer view - their own orders only)
     */
    public function show(Order $order): View
    {
        // Authorize that the user can view this order
        Gate::authorize('view', $order);

        $order->load('items.tshirtImage', 'items.color', 'customer.user');

        return view('orders.show', compact('order'));
    }

    public function downloadReceipt(Order $order)
    {
        Gate::authorize('downloadReceipt', $order);

        if (!$order->isClosed() || !$order->receipt_url) {
            abort(404);
        }

        // Look in PRIVATE disk (not public)
        $path = storage_path('app/private/pdf_receipts/' . $order->receipt_url);

        // Also check public as fallback
        if (!file_exists($path)) {
            $path = storage_path('app/public/pdf_receipts/' . $order->receipt_url);
        }

        if (!file_exists($path)) {
            abort(404, 'Receipt file not found.');
        }

        return response()->download($path, 'receipt_' . $order->id . '.pdf');
    }
    
    // ==================== EMPLOYEE METHODS ====================

    /**
     * Display pending orders (employee view)
     */
    public function pending()
    {
        // Procura as encomendas com estado 'pending' (ajusta o nome do campo 'status' se for diferente na BD)
        $orders = Order::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Retorna a vista onde os funcionários trabalham
        return view('employee.orders.pending', compact('orders'));
    }

    /**
     * Close an order (mark as shipped/processed)
     */
    public function close(Order $order)
    {
        // Garante que a encomenda está mesmo pendente antes de fechar
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Esta encomenda já não se encontra pendente.');
        }

        // Altera o estado
        $order->status = 'closed';
        $order->save();

        // Redireciona de volta para a lista com uma mensagem de sucesso
        return redirect()->route('employee.orders.pending')
            ->with('toast', 'Encomenda #' . $order->id . ' concluída e enviada com sucesso!');
    }
    
    // ==================== ADMIN METHODS ====================

    /**
     * Display all orders (admin view)
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Order::class);

        $ordersQuery = Order::with('customer.user');

        // Filter by status
        if ($request->filled('status')) {
            $ordersQuery->where('status', $request->status);
        }

        // Filter by customer name
        if ($request->filled('customer_name')) {
            $ordersQuery->whereHas('customer.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $ordersQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $ordersQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $ordersQuery->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update order status (admin)
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('update', $order);

        $request->validate([
            'status' => 'required|in:pending,closed,canceled',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // If order is being closed, generate receipt
        if ($request->status === Order::STATUS_CLOSED && $oldStatus !== Order::STATUS_CLOSED) {
            // TODO: Generate PDF receipt and send email
        }

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Order #{$order->id} status updated to {$request->status}.");
    }

    /**
     * Cancel an order (admin)
     */
    public function cancel(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('cancel', $order);

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $order->status = Order::STATUS_CANCELED;
        $order->reason_for_cancellation = $request->reason;
        $order->save();

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Order #{$order->id} has been canceled.");
    }
}
