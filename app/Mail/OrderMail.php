<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $type; // 'pending' or 'closed'
    public ?string $receiptPath;

    public function __construct(Order $order, string $type, ?string $receiptPath = null)
    {
        $this->order = $order;
        $this->type = $type;
        $this->receiptPath = $receiptPath;
    }

    public function envelope(): Envelope
    {
        $subject = $this->type === 'pending' 
            ? 'Order Confirmation - FunShirt'
            : 'Order Completed - FunShirt';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        // Use single view for both types
        return new Content(view: 'emails.orderStatus');
    }

    public function attachments(): array
    {
        // Only attach receipt for closed orders
        if ($this->type === 'closed' && $this->receiptPath && file_exists($this->receiptPath)) {
            return [
                Attachment::fromPath($this->receiptPath)
                    ->as('receipt_' . $this->order->id . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}