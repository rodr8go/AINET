<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Table(
    key: 'code',
    keyType: 'string',
    incrementing: false,
    timestamps: false
)]

#[Fillable([
    'code',
    'name',
    'custom',
])]

class Color extends Model
{
    use SoftDeletes;
    
    //====================CASTS===========================
    protected function casts(): array
    {
        return [
            'code' => 'string',
            'custom' => 'array',
            'deleted_at' => 'datetime',
            'custom',
        ];
    }
    
    //====================RELATIONSHIPS====================
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'color_code', 'code');
    }
    
    //====================GETTERS(Métodos Acessores)=======
    public function getCssStyleAttribute(): string
    {
        return "background-color: {$this->code};";
    }
    
    public function getTextColorAttribute(): string
    {
        $darkColors = ['black', '#000', '#000000', 'navy', 'darkblue', 'maroon', '#000080'];
        
        if (in_array(strtolower($this->code), $darkColors)) {
            return 'white';
        }
        
        // Check if hex code is dark
        if (preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $this->code, $matches)) {
            $hex = ltrim($this->code, '#');
            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b);
            return $luminance > 128 ? 'black' : 'white';
        }
        
        return 'black';
    }
}