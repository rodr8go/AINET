<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    // Como o ID não é autoincrementável (descrito na pág. 9) [cite: 330]
    public $incrementing = false; 
    protected $keyType = 'int';

    protected $fillable = [
        'id', 'nif', 'address', 'default_payment_type', 'default_payment_ref', 'custom',
    ];

    protected $casts = [
        'custom' => 'array',
    ];

    // Cada registo de customer pertence a apenas um User (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tshirtImages()
    {
        return $this->hasMany(TshirtImage::class);
    }
}