<?php
// app/Models/Quote.php
namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Quote extends Model
{
    protected $fillable = [
        'reference',
        'client_name',
        'client_email',
        'client_company',
        'client_phone',
        'cita',
        'additional_requirements',
        'data',
        'subtotal',
        'tax',
        'total',
        'total_hours',
        'status',
        'sent_at',
        'pdf_path'
    ];

    protected $casts = [
        'data' => 'array',
        'cita'=> 'array',
        'sent_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'total_hours' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            $quote->reference = 'COT-' . strtoupper(uniqid());
        });
    }

    // AGREGAR ESTA RELACIÓN
    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }


    public function replies()
    {
        return $this->hasMany(QuoteReply::class);
    }
}