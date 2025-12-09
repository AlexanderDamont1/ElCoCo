<?php
// app/Mail/QuoteReceived.php
namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;

    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    public function build()
    {
        return $this->subject('Cotización recibida - ' . $this->quote->reference)
                    ->markdown('emails.quote.received')
                    ->attachFromStorage('public/' . $this->quote->pdf_path, 'cotizacion.pdf');
    }
}