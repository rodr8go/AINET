<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(
    key: 'id',
    keyType: 'int',
    incrementing: true,
    timestamps: true,
)]
#[Fillable([
    'order_id',
    'tshirt_image_id',
    'color_code',
    'size',
    'qty',
    'unit_price',
    'sub_total',
    'custom',
])]

class OrderItem extends Model
{
    public $timestamps = false;
    //====================SIZES==========================
    public const SIZES = ['XS', 'S', 'M', 'L', 'XL'];
    
    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'unit_price' => 'decimal:2',
            'sub_total' => 'decimal:2',
            'custom' => 'array',
        ];
    }
    
    //====================RELATIONSHIPS====================
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    
    public function tshirtImage(): BelongsTo
    {
        return $this->belongsTo(TshirtImage::class, 'tshirt_image_id', 'id');
    }
    
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_code', 'code');
    }
}