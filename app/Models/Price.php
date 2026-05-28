<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Table(
    key: 'id',
    keyType: 'int',
    incrementing: true,
    timestamps: true,
)]
#[Fillable([
    'unit_price_catalog',
    'unit_price_own',
    'unit_price_catalog_discount',
    'unit_price_own_discount',
    'qty_discount',
    'custom',
])]

class Price extends Model
{
    //====================CASTS===========================
    protected function casts(): array
    {
        return [
            'unit_price_catalog' => 'decimal:2',
            'unit_price_own' => 'decimal:2',
            'unit_price_catalog_discount' => 'decimal:2',
            'unit_price_own_discount' => 'decimal:2',
            'qty_discount' => 'integer',
            'custom' => 'array',
        ];
    }
    
    //====================HELPER METHODS=======================
    
    public function getUnitPrice(bool $isCatalogImage, int $quantity): float
    {
        $hasDiscount = $quantity >= $this->qty_discount;
        
        if ($isCatalogImage) {
            return $hasDiscount ? $this->unit_price_catalog_discount : $this->unit_price_catalog;
        }
        
        return $hasDiscount ? $this->unit_price_own_discount : $this->unit_price_own;
    }
    
    public static function getCurrent(): ?self
    {
        return self::first();
    }
}