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
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CartConfirmationFormRequest;

class CheckoutController extends Controller
{
    protected \App\Services\ReceiptService $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    /**
     * Mostra o formulário de Checkout
     */
    public function index()
    {
        // Vai buscar o carrinho atual da sessão
        $cart = session()->get('cart', []);

        // Se o carrinho estiver vazio, redireciona de volta com aviso
        if (empty($cart)) {
            return redirect()->route('cart.show')
                ->with('alert-type', 'warning')
                ->with('alert-msg', 'O seu carrinho está vazio! Adicione produtos antes de fazer o checkout.');
        }

        // Calcula o total acumulado do carrinho usando as chaves corretas ('unit_price' e 'qty')
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['unit_price'] ?? 0) * ($item['qty'] ?? 1);
        }

        // Retorna a vista do checkout (recursos/views/checkout/index.blade.php)
        return view('checkout.index', compact('cart', 'totalPrice'));
    }

    /**
     * Processa a submissão do Checkout, valida na API externa e cria a encomenda
     */
    public function store(CartConfirmationFormRequest $request)
    {
        // O utilizador autenticado
        $user = Auth::user();
        $cart = session()->get('cart', []);

        // Se por algum motivo o carrinho esvaziou antes de submeter
        if (empty($cart)) {
            return redirect()->route('cart.show')
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Não foi possível processar. O seu carrinho está vazio.');
        }

        // 1. Calcular o valor total acumulado para enviar à API de pagamentos
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += ($item['unit_price'] ?? 0) * ($item['qty'] ?? 1);
        }

        // 2. COMUNICAÇÃO COM A PLATAFORMA EXTERNA DE PAGAMENTOS
        try {
            $formattedValue = (float) number_format($totalPrice, 2, '.', '');

            $response = Http::post('https://ainet-payments-api.vercel.app/api/payments', [
                'type'      => trim($request->payment_type),
                'reference' => trim($request->payment_ref),
                'value'     => $formattedValue,
            ]);



            /*if ($response->status() === 422) {
                dd($response->json(), [
                    'type' => $request->payment_type,
                    'reference' => $request->payment_ref,
                    'value' => (float) $totalPrice
                ]);
            }
            */

            // Se a API responder com um erro de validação/negócio (Ex: Status 422 - Saldo Insuficiente)
            if ($response->status() === 422) {
                $errorData = $response->json();

                // 🎯 Mapeia as três hipóteses onde a API costuma injetar as mensagens de erro
                $rawError = $errorData['errors']['value'][0] ??
                    ($errorData['errors']['reference'][0] ??
                        ($errorData['message'] ?? ''));

                // Fazemos o match com as strings exatas que a API envia
                $errorMessage = match (trim($rawError)) {
                    'There is no Visa card associated with this reference.'
                    => 'Não existe nenhum cartão Visa associado a esta referência.',

                    'There is no PayPal account associated with this reference.'
                    => 'Não existe nenhuma conta PayPal associada a esta referência.',

                    'There is no MB WAY account associated with this reference.'
                    => 'Não existe nenhuma conta MB WAY associada a este número.',

                    // 🎯 Ajustado para a frase exata da API que vimos no teu dd()!
                    'Insufficient balance to process this payment.'
                    => 'Saldo insuficiente para realizar este pagamento.',

                    'Validation failed'
                    => 'Dados de pagamento inválidos. Verifique os campos.',

                    default
                    => 'O pagamento foi recusado pela plataforma externa.'
                };

                return redirect()->back()
                    ->withInput()
                    ->with('alert-type', 'error')
                    ->with('alert-msg', "Falha no Pagamento: {$errorMessage}");
            }

            // Se falhar por qualquer outro código que não seja sucesso
            if (!$response->successful()) {
                return redirect()->back()
                    ->withInput()
                    ->with('alert-type', 'error')
                    ->with('alert-msg', 'A plataforma de pagamentos está indisponível de momento. Tente mais tarde.');
            }
        } catch (\Exception $e) {
            // Protege a aplicação caso o servidor da Vercel esteja completamente offline
            return redirect()->back()
                ->withInput()
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Erro de ligação ao servidor de pagamentos externo.');
        }

        // 3. SE O PAGAMENTO TEVE SUCESSO (Status 201), AVANÇA PARA A CRIAÇÃO DA ENCOMENDA
        $priceSettings = DB::table('prices')->first();

        // Criar a encomenda dentro de uma transação da BD
        $order = DB::transaction(function () use ($user, $cart, $request, $totalPrice) {
            $customer = $user->customer;

            $order = Order::create([
                'status'       => 'pending',
                'customer_id'  => $customer?->id,
                'date'         => now()->format('Y-m-d'),
                'total_price'  => $totalPrice,
                'notes'        => $request->notes,
                'nif'          => $request->nif ?? $customer?->nif,
                'address'      => $request->address ?? $customer?->address ?? 'Morada não especificada',
                'payment_type' => $request->payment_type,
                'payment_ref'  => $request->payment_ref,
                'receipt_url'  => null,
            ]);

            foreach ($cart as $id => $item) {
                $order->items()->create([
                    'tshirt_image_id' => $item['tshirt_image_id'],
                    'color_code'      => $item['color_code'],
                    'size'            => $item['size'],
                    'qty'             => $item['qty'],
                    'unit_price'      => $item['unit_price'],
                    'sub_total'       => $item['unit_price'] * $item['qty'],
                ]);
            }

            // Gera o PDF na pasta 'pdf_receipts'
            if (isset($this->receiptService)) {
                $this->receiptService->generateReceipt($order);
            }

            return $order;
        });




        // Envia o e-mail de encomenda paga (tipo = 'paid', com o recibo digital)
        try {
            $this->receiptService->sendOrderEmail($order, 'paid');
        } catch (\Exception $e) {
            Log::warning('Email de confirmação não enviado para order #' . $order->id . ': ' . $e->getMessage());
        }

        // Limpa o carrinho da sessão após o sucesso total
        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Encomenda submetida e paga com sucesso! Verifique o seu e-mail.');
    }
}
