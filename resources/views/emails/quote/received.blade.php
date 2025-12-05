<x-mail::message>
# ¡Gracias por tu cotización, {{ $quote->name }}!

Hemos recibido tu solicitud de cotización y estamos emocionados de poder ayudarte con tu proyecto.

## Resumen de tu cotización
**Referencia:** {{ $quote->reference }}  
**Fecha:** {{ $quote->created_at->format('d/m/Y H:i') }}  
**Total estimado:** ${{ number_format($totalCost, 0, '.', ',') }} MXN  
**Horas estimadas:** {{ $totalHours }} horas

## Bloques seleccionados
@foreach ($blocks as $block)
- **{{ $block['name'] }}**: {{ ($block['customHours'] ?? $block['hours']) }} horas (${{ (($block['customHours'] ?? $block['hours']) * 500) }} MXN)
@endforeach

## Próximos pasos
1. Nuestro equipo revisará tu solicitud en detalle
2. Te contactaremos en menos de **24 horas** para discutir los detalles
3. Coordinaremos una reunión inicial sin costo

<x-mail::button :url="route('home')">
    Visitar nuestro sitio
</x-mail::button>

Gracias por confiar en nosotros,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>