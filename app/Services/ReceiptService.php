<?php

namespace App\Services;

use App\Models\Order;
use App\Mail\OrderMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ReceiptService
{
    /**
     * Generate PDF receipt and store it
     */
    public function generateReceipt(Order $order): ?string
    {
        try {
            $order->load(['items.tshirtImage', 'items.color', 'customer.user']);
            
            // Create directory if it doesn't exist (NOW USING PUBLIC DISK)
            if (!Storage::disk('public')->exists('pdf_receipts')) {
                Storage::disk('public')->makeDirectory('pdf_receipts');
            }
            
            // Generate PDF
            $pdf = Pdf::loadView('pdfs.receipt', compact('order'));
            
            // Filename
            $filename = 'receipt_' . $order->id . '.pdf';
            $relativePath = 'pdf_receipts/' . $filename;
            
            // Save PDF to PUBLIC disk (not private)
            Storage::disk('public')->put($relativePath, $pdf->output());
            
            // Update order with receipt filename
            $order->receipt_url = $filename;
            $order->save();
            
            return Storage::disk('public')->path($relativePath);
            
        } catch (\Exception $e) {
            \Log::error('Receipt generation failed: ' . $e->getMessage());
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
        
        Mail::to($order->customer->user->email)
            ->send(new OrderMail($order, $type, $receiptPath));
    }
}