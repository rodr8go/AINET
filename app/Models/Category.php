<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name', 'image_url', 'custom',
    ];

    protected $casts = [
        'custom' => 'array',
    ];

    public function tshirtImages()
    {
        return $this->hasMany(TshirtImage::class);
    }
}