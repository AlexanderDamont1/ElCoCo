<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuoteReplyMail extends Mailable 
{
    use Queueable, SerializesModels;

    public $quote;
    public $messageText;
    public $pdfPath;

    public function __construct($quote, $messageText, $pdfPath)
    {
        $this->quote = $quote;
        $this->messageText = $messageText;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Tu cotización y cita virtual')
                    ->view('emails.quote-reply')
                    ->with([
                        'quote' => $this->quote,
                        'messageText' => $this->messageText,
                    ])
                    ->attach(storage_path('app/public/' . $this->pdfPath), [
                        'as' => $this->quote->reference . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
