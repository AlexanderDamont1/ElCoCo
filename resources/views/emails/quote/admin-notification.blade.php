<x-mail::message>
# Nueva cotización recibida

**Referencia:** {{ $quote->reference }}  
**Fecha:** {{ $quote->created_at->format('d/m/Y H:i') }}  
**Cliente:** {{ $quote->name }}  
**Email:** {{ $quote->email }}

## Información del proyecto
{{ $quote->project_description ?? 'Sin descripción adicional' }}

## Resumen de la cotización
**Total:** ${{ number_format($totalCost, 0, '.', ',') }} MXN  
**Horas totales:** {{ $totalHours }} horas  
**Precio por hora:** $500 MXN

## Bloques seleccionados
@foreach ($blocks as $index => $block)
**{{ $index + 1 }}. {{ $block['name'] }}**  
- Horas: {{ $block['customHours'] ?? $block['hours'] }}  
- Costo: ${{ (($block['customHours'] ?? $block['hours']) * 500) }} MXN  
- Descripción: {{ $block['description'] }}

@endforeach

## Información técnica
**IP:** {{ $quote->ip_address }}  
**User Agent:** {{ $quote->user_agent }}

<x-mail::button :url="route('admin.quotes.show', $quote->id)">
    Ver en el panel de administración
</x-mail::button>

</x-mail::message>