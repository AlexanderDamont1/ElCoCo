<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'reference',
        'client_name',
        'client_email',
        'client_company',
        'client_phone',
        'additional_requirements',
        'data',
        'subtotal',
        'tax',
        'total',
        'total_hours',
        'status',
        'sent_at',
        'pdf_path',
    ];

    protected $casts = [
        'data'        => 'array',
        'sent_at'     => 'datetime',
        'subtotal'    => 'decimal:2',
        'tax'         => 'decimal:2',
        'total'       => 'decimal:2',
        'total_hours' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Quote $quote) {
            $quote->reference = 'COT-' . strtoupper(uniqid());
        });
    }

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function replies()
    {
        return $this->hasMany(QuoteReply::class)->orderByDesc('sent_at');
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'    => 'Borrador',
            'sent'     => 'Enviada',
            'accepted' => 'Aceptada',
            'rejected' => 'Rechazada',
            'expired'  => 'Expirada',
            default    => ucfirst($this->status),
        };
    }
}