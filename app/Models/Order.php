<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(
    key: 'id',
    keyType: 'int',
    incrementing: true,
    timestamps: true,
)]
#[Fillable([
    'status',
    'customer_id',
    'date',
    'total_price',
    'notes',
    'reason_for_cancellation',
    'nif',
    'address',
    'payment_type',
    'payment_ref',
    'receipt_url',
])]

class Order extends Model
{
    //====================STATUS==========================
    public const STATUS_PENDING = 'pending';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_CANCELED = 'canceled';
    
    //====================CASTS===========================
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }
    
    //====================RELATIONSHIPS====================
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    
    //====================HELPER METHODS(Vericar STATUS)=======
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
    
    public function isClosed(): bool
    {
        return $this->status === self::STATUS_CLOSED;
    }
    
    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function getReceiptFullUrlAttribute(): ?string
    {
        $receiptUrl = $this->getAttribute('receipt_url');
        if ($receiptUrl) {
            return asset('storage/pdf_receipts/' . $receiptUrl);
        }
        return null;
    }
}