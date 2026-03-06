<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Cotización {{ $quote['reference'] ?? '' }}</title>

<style>
body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#1f2937;
    margin:40px;
}

.header{
    display:table;
    width:100%;
    margin-bottom:30px;
}

.logo{
    display:table-cell;
    vertical-align:middle;
}

.logo img{
    height:50px;
}

.title{
    display:table-cell;
    text-align:right;
    vertical-align:middle;
}

h1{
    font-size:22px;
    margin:0;
}

.muted{
    color:#6b7280;
}

.section{
    margin-bottom:25px;
}

.client-box{
    background:#f9fafb;
    border:1px solid #e5e7eb;
    padding:12px 15px;
    border-radius:6px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f3f4f6;
    font-weight:600;
    text-align:left;
    padding:8px;
    border-bottom:1px solid #d1d5db;
}

td{
    padding:8px;
    border-bottom:1px solid #e5e7eb;
}

.right{
    text-align:right;
}

.section-row{
    background:#eef2ff;
    font-weight:bold;
}

.totals{
    width:40%;
    margin-left:auto;
    margin-top:20px;
}

.totals td{
    padding:6px 8px;
}

.totals tr:last-child td{
    font-weight:bold;
    font-size:14px;
    border-top:2px solid #1f2937;
}

.footer{
    margin-top:40px;
    font-size:10px;
    color:#6b7280;
    text-align:center;
}
</style>
</head>

<body>

{{-- HEADER --}}
<div class="header">

    <div class="logo">
        <img src="{{ public_path('images/DMI-logob.png') }}">
    </div>

    <div class="title">
        <h1>Cotización</h1>
        <p class="muted">
            Ref: {{ $quote['reference'] ?? 'N/A' }}<br>
            Fecha: {{ now()->format('d/m/Y') }}
        </p>
    </div>

</div>

{{-- CLIENTE --}}
<div class="section client-box">

<strong>Cliente</strong><br>

{{ $quote['client']['name'] ?? '' }}<br>
{{ $quote['client']['email'] ?? '' }}<br>

@if(!empty($quote['client']['phone']))
Tel: {{ $quote['client']['phone'] }}<br>
@endif

@if(!empty($quote['client']['company']))
Empresa: {{ $quote['client']['company'] }}
@endif

@if(!empty($quote['client']['project_description']))
<br><br>
<strong>Proyecto</strong><br>
{{ $quote['client']['project_description'] }}
@endif

</div>

{{-- SERVICIOS --}}
<div class="section">

<table>

<thead>
<tr>
<th>Servicio</th>
<th>Descripción</th>
<th class="right">Cantidad</th>
<th class="right">Precio</th>
<th class="right">Total</th>
</tr>
</thead>

<tbody>

@foreach($quote['blocks'] ?? [] as $block)

@php
$isSection = isset($block['nestedBlocks']);
@endphp

{{-- SECCION --}}
@if($isSection)

<tr class="section-row">
<td colspan="5">
{{ $block['name'] }}
@if(!empty($block['description']))
<br>
<span class="muted">{{ $block['description'] }}</span>
@endif
</td>
</tr>

@foreach($block['nestedBlocks'] as $nested)

@php
$total = $nested['totalPrice'] ?? 0;
$q = $nested['quantity'] ?? 1;
$price = $q > 0 ? $total/$q : $total;
@endphp

<tr>
<td>{{ $nested['name'] }}</td>

<td>
@if(!empty($nested['description']))
{{ $nested['description'] }}
@endif
</td>

<td class="right">{{ $q }}</td>
<td class="right">${{ number_format($price,2) }}</td>
<td class="right">${{ number_format($total,2) }}</td>

</tr>

@endforeach

{{-- ITEM NORMAL --}}
@else

@php
$total = $block['totalPrice'] ?? 0;
$q = $block['quantity'] ?? 1;
$price = $q > 0 ? $total/$q : $total;
@endphp

<tr>

<td>{{ $block['name'] }}</td>

<td>
@if(!empty($block['description']))
{{ $block['description'] }}
@endif
</td>

<td class="right">{{ $q }}</td>
<td class="right">${{ number_format($price,2) }}</td>
<td class="right">${{ number_format($total,2) }}</td>

</tr>

@endif

@endforeach

</tbody>
</table>

</div>

{{-- TOTALES --}}
<table class="totals">

<tr>
<td>Subtotal</td>
<td class="right">
${{ number_format($quote['summary']['subtotal'] ?? 0,2) }}
</td>
</tr>

<tr>
<td>IVA</td>
<td class="right">
${{ number_format($quote['summary']['tax'] ?? 0,2) }}
</td>
</tr>

<tr>
<td>Total</td>
<td class="right">
${{ number_format($quote['summary']['total'] ?? 0,2) }}
</td>
</tr>

</table>

{{-- FOOTER --}}
<div class="footer">

Este documento es una cotización informativa.<br>
© {{ now()->year }} {{ config('app.name') }}

</div>

</body>
</html>