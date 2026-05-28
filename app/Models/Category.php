<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    'name',
    'image_url',
    'custom',
])]

class Category extends Model
{
    use SoftDeletes;
    
    //====================CASTS===========================
    protected function casts(): array
    {
        return [
            'custom' => 'array',
            'deleted_at' => 'datetime',
            'custom',
        ];
    }
    
    //====================RELATIONSHIPS====================
    public function tshirtImages(): HasMany
    {
        return $this->hasMany(TshirtImage::class, 'category_id', 'id');
    }
    
    //====================GETTERS(Métodos Acessores)=======
    public function getImageFullUrlAttribute(): string
    {
        if ($this->image_url) {
            return asset("storage/categories/{$this->image_url}");
        }
        return asset("storage/categories/default-category.png");
    }
    
    public function getHasImageAttribute(): bool
    {
        return !is_null($this->image_url);
    }
 
    public function getTshirtCountAttribute(): int
    {
        // This is an accessor - use when you need the count without eager loading
        // For better performance with multiple categories, use withCount() instead
        return $this->tshirtImages()->count();
    }
}