
<p>Hola {{ $quote->client_name }}</p>

<p>{{ $messageText }}</p>

<p>
    Total cotizado:
    <strong>${{ number_format($quote->total, 2) }}</strong>
</p>
