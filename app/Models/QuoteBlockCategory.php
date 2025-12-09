<?php
// app/Models/QuoteBlockCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteBlockCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function blocks()
{
    return $this->hasMany(QuoteBlock::class, 'category_id');
}


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}