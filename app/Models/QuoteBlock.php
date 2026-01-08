<?php
// app/Models/QuoteBlock.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteBlock extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'category_id',
        'base_price',
        'default_hours',
        'config',
       // 'formula',
        //'validation_rules',
        'is_active',
        'order'
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
        'default_hours' => 'integer'
    ];

    public function category()
{
    return $this->belongsTo(QuoteBlockCategory::class, 'category_id');
}

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}