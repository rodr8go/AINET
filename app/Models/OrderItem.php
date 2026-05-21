<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    public $timestamps = false;

    protected $fillable = [
        'order_id', 'tshirt_image_id', 'color_code', 'size', 'qty', 'unit_price', 'sub_total', 'custom',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'custom' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tshirtImage()
    {
        return $this->belongsTo(TshirtImage::class)->withTrashed();
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_code', 'code')->withTrashed();
    }
}