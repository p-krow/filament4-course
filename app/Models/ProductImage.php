<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id', 'disk', 'path', 'original_name', 'extension', 'size'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
