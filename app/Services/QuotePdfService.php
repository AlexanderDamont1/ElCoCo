<?php
// app/Services/QuotePdfService.php
namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class QuotePdfService
{
    public function generate(array $quoteData)
    {
        $data = [
            'quote' => $quoteData,
            'date' => now()->format('d/m/Y'),
            'taxRate' => 0.16
        ];

        $pdf = Pdf::loadView('quotes.pdf.quote', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'dejavu sans'
        ]);

        return $pdf->output();
    }
}