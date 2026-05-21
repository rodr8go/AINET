<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TshirtImage extends Model
{
    use SoftDeletes; 

    protected $table = 'tshirt_images';

    protected $fillable = [
        'customer_id', 'category_id', 'name', 'description', 'image_url', 'custom',
    ];

    protected $casts = [
        'custom' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'tshirt_image_id');
    }
}