<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'nif',
    'address',
    'default_payment_type',
    'default_payment_ref',
    'custom'
])]
#[Table(
    key: 'id',
    keyType: 'int',
    incrementing: false,// Como o ID não é autoincrementável (descrito na pág. 9) [cite: 330]
    timestamps: false,
)]

class Customer extends Model
{
    use SoftDeletes;

    //====================CASTS===========================
    protected function casts(): array
    {
        return [
            'id' => 'int',
            'custom',
        ];
    }

    //====================RELATIONSHIPS====================
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
    
    public function customImages(): HasMany
    {
        return $this->hasMany(TshirtImage::class, 'customer_id', 'id');
    }

    //====================GETTERS(Métodos Acessores)=======
    public function getFormattedNifAttribute(): string
    {
        if (!$this->nif || strlen($this->nif) !== 9) {
            return $this->nif ?? 'Not provided';
        }
        
        return substr($this->nif, 0, 3) . ' ' . 
               substr($this->nif, 3, 3) . ' ' . 
               substr($this->nif, 6, 3);
    }
    
    public function getFullAddressAttribute(): string
    {
        return $this->address ?? 'No address provided';
    }
    
    public function getPaymentTypeLabelAttribute(): string
    {
        return match($this->default_payment_type) {
            'Visa' => 'Visa Card',
            'PayPal' => 'PayPal',
            'MB' => 'MB Way',
            default => 'Not defined',
        };
    }
    
    public function getMaskedPaymentRefAttribute(): string
    {
        if (!$this->default_payment_ref) {
            return 'Not provided';
        }
        
        return match($this->default_payment_type) {
            'Visa' => '**** **** **** ' . substr($this->default_payment_ref, -4),
            'PayPal' => substr($this->default_payment_ref, 0, 3) . '***@***.***',
            'MB' => '******' . substr($this->default_payment_ref, -3),
            default => '****',
        };
    }

}
