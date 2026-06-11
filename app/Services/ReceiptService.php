<?php

namespace App\Services;

use App\Models\Order;
use App\Mail\OrderMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;



class ReceiptService
{
    /**
     * Generate PDF receipt and store it
     */
    public function generateReceipt(Order $order): ?string
    {
        try {
            if (!$order->exists || empty($order->id)) {
                $order->save();
            }

            // 🎯 Se for uma encomenda antiga, não fazemos nada (deixamos o ficheiro private em paz)
            if ($order->id <= 4800) {
                return storage_path('app/private/pdf_receipts/receipt_' . $order->id . '.pdf');
            }

            $order->load(['items.tshirtImage', 'items.color', 'customer.user']);

            // Garante a pasta apenas no disco PUBLIC
            if (!Storage::disk('public')->exists('pdf_receipts')) {
                Storage::disk('public')->makeDirectory('pdf_receipts');
            }

            $filename = 'receipt_' . $order->id . '.pdf';
            $relativePath = 'pdf_receipts/' . $filename;

            // GERA O PDF DINÂMICO (Com o layout completo para as tuas novas compras)
            $pdf = Pdf::loadView('pdfs.receipt', compact('order'));

            // Grava no disco PUBLIC
            Storage::disk('public')->put($relativePath, $pdf->output());

            $order->receipt_url = $filename;
            $order->save();

            return Storage::disk('public')->path($relativePath);
        } catch (\Exception $e) {
            Log::error('Receipt generation failed: ' . $e->getMessage());
            return null;
        }
    }
    /**
     * Delete receipt from storage
     */
    public function deleteReceipt(Order $order): bool
    {
        if ($order->receipt_url) {
            $path = 'pdf_receipts/' . $order->receipt_url;
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
        }
        return false;
    }

    /**
     * Regenerate receipt (overwrites existing)
     */
    public function regenerateReceipt(Order $order): ?string
    {
        // Delete old receipt if exists
        $this->deleteReceipt($order);

        // Generate new receipt
        return $this->generateReceipt($order);
    }

    /**
     * Send order email (pending or closed with receipt)
     */
    public function sendOrderEmail(Order $order, string $type, ?string $receiptPath = null): void
    {
        $order->load('customer.user', 'items.tshirtImage');

        // Se não foi passado path, tenta calcular automaticamente
        if ($receiptPath === null && $order->receipt_url) {
            $receiptPath = storage_path('app/public/pdf_receipts/' . $order->receipt_url);
        }

        Mail::to($order->customer->user->email)
            ->send(new OrderMail($order, $type, $receiptPath));

        sleep(1);
    }
}
