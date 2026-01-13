<p>
    Hola <strong>{{ $quote->client_name }}</strong>,
</p>

<p>
    Esperamos que te encuentres muy bien. Te compartimos la cotización solicitada en formato PDF, 
    donde podrás revisar a detalle los servicios considerados, así como los importes correspondientes.
</p>

<p>
    {{ $messageText }}
</p>

<p>
    <strong>Total cotizado:</strong>
    ${{ number_format($quote->total, 2) }}
</p>

<p>
    El archivo PDF adjunto contiene la información completa de la cotización. 
    Si tienes alguna duda, comentario o requieres algún ajuste, quedamos atentes para apoyarte.
</p>

<p>
    Saludos cordiales,<br>
    <strong>Equipo de Ventas</strong>
</p>
