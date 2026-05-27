<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteBlockCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
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

    public function blocks()
    {
        return $this->hasMany(QuoteBlock::class, 'category_id');
    }
}