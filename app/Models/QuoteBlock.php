<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteBlock extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'base_price',
        'default_hours',
        'config',
        'is_active',
        'order',
    ];

    protected $casts = [
        'config'    => 'array',
        'base_price'=> 'decimal:2',
        'is_active' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------

    public function category()
    {
        return $this->belongsTo(QuoteBlockCategory::class, 'category_id');
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }
}