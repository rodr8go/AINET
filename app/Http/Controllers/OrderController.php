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
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    protected ReceiptService $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    //Customer: myOrders
    public function myOrders(): View
    {
        $user = Auth::user();

        //Verificar se user auth tem um customer account
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

    public function show(Order $order): View
    {
        //Autorizar a view da ORDER
        Gate::authorize('view', $order);

        $order->load('items.tshirtImage', 'items.color', 'customer.user');

        return view('orders.show', compact('order'));
    }

    public function downloadReceipt(Order $order)
    {
        // 1. Autorização
        Gate::authorize('downloadReceipt', $order);

        if ($order->status !== 'closed' && $order->status !== 'paid') {
            abort(403, 'Apenas encomendas pagas ou concluídas têm recibo.');
        }

        //ESTRATÉGIA DE CAMINHOS SEPARADOS
        if ($order->id <= 4800) {
            //Encomendas Antigas (Pasta Private)

            //Tentativa 1: Tenta o nome padrão correto que vimos na tua pasta: receipt_X.pdf
            $path = storage_path('app/private/pdf_receipts/receipt_' . $order->id . '.pdf');
            //Tentativa 2: Se o anterior não existir, tenta o que está guardado na BD
            if (!file_exists($path) && !empty($order->receipt_url)) {
                $path = storage_path('app/private/pdf_receipts/' . $order->receipt_url);
            }
            //Se nenhuma das duas opções existir fisicamente, aí sim dá 404
            if (!file_exists($path)) {
                abort(404, "O recibo físico da encomenda #{$order->id} não existe em storage/app/pdf_receipts/");
            }
        } else {
            //Encomendas Novas (Pasta Public)
            $path = storage_path('app/public/pdf_receipts/' . $order->receipt_url);

            //Se não existir nas novas, o teu ReceiptService gera-o na pasta pública
            if (empty($order->receipt_url) || !file_exists($path)) {
                if (isset($this->receiptService)) {
                    $this->receiptService->generateReceipt($order);
                    $order->refresh(); // Atualiza os dados
                    $path = storage_path('app/public/pdf_receipts/' . $order->receipt_url);
                }
            }

            if (!file_exists($path)) {
                abort(404, 'Não foi possível gerar o recibo para esta nova encomenda.');
            }
        }

        return response()->download($path, 'receipt_' . $order->id . '.pdf');
    }
    
    // ==================== EMPLOYEE METHODS ====================

    public function pending()
    {
        $orders = Order::where('status', 'pending')
            ->with('customer.user')
            ->orderBy('date', 'desc')
            ->get();

        return view('employee.orders.pending', compact('orders'));
    }

    public function close(Order $order)
    {
        // Garante que a encomenda está mesmo pendente antes de fechar
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Esta encomenda já não se encontra pendente.');
        }

        // Altera o estado
        $order->status = 'closed';
        $order->save();

        // Dispara automaticamente o e-mail verde de sucesso com o recibo em PDF anexado!
        try {
            $this->receiptService->sendOrderEmail($order, 'closed');
        } catch (\Exception $e) {
            Log::warning('Email de fecho não enviado para order #' . $order->id . ': ' . $e->getMessage());
        }

        // Redireciona de volta para a lista com uma mensagem de sucesso
        return redirect()->route('employee.orders.pending')
            ->with('toast', 'Encomenda #' . $order->id . ' concluída e enviada com sucesso!');
    }

    
    // ==================== ADMIN METHODS ====================

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Order::class);

        $ordersQuery = Order::with('customer.user');

        //Filtro por STATUS
        if ($request->filled('status')) {
            $ordersQuery->where('status', $request->status);
        }

        //Filtro por NOME
        if ($request->filled('customer_name')) {
            $ordersQuery->whereHas('customer.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        //Filtro por periodo de tempo
        if ($request->filled('date_from')) {
            $ordersQuery->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $ordersQuery->whereDate('date', '<=', $request->date_to);
        }


        $orders = $ordersQuery->orderBy('date', 'desc')->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        Gate::authorize('update', $order);

        $request->validate([
            'status' => 'required|in:pending,closed,canceled',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        //Gerar recibo no fecho da order
        if ($request->status === Order::STATUS_CLOSED && $oldStatus !== Order::STATUS_CLOSED) {
            // TODO: Generate PDF receipt and send email
        }

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Order #{$order->id} status updated to {$request->status}.");
    }

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

    public function employeeShow(Order $order): View
    {
        $order->load('items.tshirtImage', 'items.color', 'customer.user');
        return view('employee.orders.show', compact('order'));
    }

    public function showCancelForm(Order $order): View|RedirectResponse  // ← ALTERAR AQUI
    {
        //Auth
        Gate::authorize('cancel', $order);
        
        //Pode ser cancelada?
        if ($order->status === Order::STATUS_CANCELED) {
            return redirect()->route('admin.orders.show', $order)
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Esta encomenda já está cancelada.');
        }
        
        if ($order->status === Order::STATUS_CLOSED) {
            return redirect()->route('admin.orders.show', $order)
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Encomendas fechadas não podem ser canceladas.');
        }
        
        //Carregar os relacionamentos necessários
        $order->load('items.tshirtImage', 'customer.user');
        
        return view('admin.orders.cancel', compact('order'));
    }

}
