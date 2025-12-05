<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;

    /**
     * Create a new message instance.
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🎉 ¡Hemos recibido tu cotización!')
                    ->markdown('emails.quote.received')
                    ->with([
                        'quote' => $this->quote,
                        'blocks' => $this->quote->blocks,
                        'totalHours' => $this->quote->total_hours,
                        'totalCost' => $this->quote->total_cost,
                    ]);
    }
}