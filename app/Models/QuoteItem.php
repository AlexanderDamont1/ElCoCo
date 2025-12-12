<?php
// app/Models/QuoteItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id',
        'quote_block_id',
        'name',
        'description',
        'type',
        'quantity',
        'hours',
        'unit_price',
        'total_price',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'quantity' => 'integer',
        'hours' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function block()
    {
        return $this->belongsTo(QuoteBlock::class, 'quote_block_id');
    }
}