<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteReply extends Model
{
    protected $fillable = [
        'quote_id',
        'message',
        'sent_at',
        'meet_link',
        'created_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relaciones
    // -------------------------------------------------------------------------

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}