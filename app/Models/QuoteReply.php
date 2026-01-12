<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteReply extends Model
{
    protected $fillable = [
        'quote_id',
        'message',
        'sent_to_email',
        'sent_at',
    ];

    
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }



    public function replies()
    {
        return $this->hasMany(QuoteReply::class);
    }


}