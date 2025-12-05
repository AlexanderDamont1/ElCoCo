<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'project_description',
        'blocks',
        'total_hours',
        'total_cost',
        'ip_address',
        'user_agent',
        'status',
    ];

    /**
     * Los atributos que deberían ser casteados.
     *
     * @var array
     */
    protected $casts = [
        'blocks' => 'array',
        'total_hours' => 'integer',
        'total_cost' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Los valores por defecto para los atributos del modelo.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Obtener el precio por hora (siempre $500 MXN)
     */
    public function getPricePerHourAttribute()
    {
        return 500;
    }

    /**
     * Formatear el costo total
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_cost, 0, '.', ',') . ' MXN';
    }

    /**
     * Obtener el número de referencia
     */
    public function getReferenceAttribute()
    {
        return 'QUOTE-' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Scope para cotizaciones pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para cotizaciones procesadas
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    /**
     * Scope para buscar por email
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}