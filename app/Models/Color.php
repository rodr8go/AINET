<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code', 'name', 'custom',
    ];

    protected $casts = [
        'custom' => 'array',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'color_code', 'code');
    }
}