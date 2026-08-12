<?php

namespace App\Models;

use Database\Factories\WhatsappClickFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappClick extends Model
{
    /** @use HasFactory<WhatsappClickFactory> */
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'store_id',
        'product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
