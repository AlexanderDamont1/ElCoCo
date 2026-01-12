<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $messageText;

    public function __construct($quote, string $messageText)
    {
        $this->quote = $quote;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this
            ->subject('Respuesta a tu cotización ' . $this->quote->reference)
            ->view('emails.quote-reply')
            ->with([
                'quote' => $this->quote,
                'messageText' => $this->messageText,
            ]);
    }
}