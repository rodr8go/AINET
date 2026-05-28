<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    'customer_id',
    'category_id',
    'name',
    'description',
    'image_url',
    'custom',
])]

class TshirtImage extends Model
{
    use SoftDeletes;
    
    //====================CASTS===========================
    protected function casts(): array
    {
        return [
            'custom' => 'array',
            'deleted_at' => 'datetime',
        ];
    }
    
    //====================RELATIONSHIPS====================
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'tshirt_image_id');
    }
    
    //====================HELPER METHODS(Vericar user type/blocked)=======
    public function isCatalogImage(): bool
    {
        return is_null($this->customer_id);
    }
    
    public function isCustomImage(): bool
    {
        return !is_null($this->customer_id);
    }
}