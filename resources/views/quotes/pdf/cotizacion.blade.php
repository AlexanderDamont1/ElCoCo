<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 40px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .header .logo {
            display: table-cell;
            vertical-align: middle;
        }

        .header .logo img {
            height: 50px;
        }

        .header .title {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        h1 {
            font-size: 22px;
            margin: 0;
        }

        .muted {
            color: #6b7280;
        }

        .section {
            margin-bottom: 25px;
        }

        .client-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 12px 15px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            font-weight: 600;
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #d1d5db;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .right {
            text-align: right;
        }

        .totals {
            width: 40%;
            margin-left: auto;
            margin-top: 20px;
        }

        .totals td {
            padding: 6px 8px;
        }

        .totals tr:last-child td {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #1f2937;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/DMI-logob.png') }}" alt="DMI">
        </div>

        <div class="title">
            <h1>Cotización</h1>
            <p class="muted">
                Fecha: {{ now()->format('d/m/Y') }}
            </p>
        </div>
    </div>

    {{-- CLIENTE --}}
    <div class="section client-box">
        <strong>Cliente</strong><br>
        {{ $data['client']['name'] }}<br>
        {{ $data['client']['email'] }}<br>

        @if(!empty($data['client']['phone']))
            Tel: {{ $data['client']['phone'] }}<br>
        @endif

        @if(!empty($data['client']['company']))
            Empresa: {{ $data['client']['company'] }}
        @endif
    </div>

    {{-- SERVICIOS --}}
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th class="right">Horas</th>
                    <th class="right">Precio</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['blocks'] as $block)
                    <tr>
                        <td>{{ $block['name'] }}</td>
                        <td>{{ $block['description'] }}</td>
                        <td class="right">{{ $block['hours'] }}</td>
                        <td class="right">${{ number_format($block['base_price'], 2) }}</td>
                        <td class="right">${{ number_format($block['total_price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- TOTALES --}}
    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="right">${{ number_format($data['summary']['subtotal'], 2) }}</td>
        </tr>
        <tr>
            <td>Impuestos</td>
            <td class="right">${{ number_format($data['summary']['tax'], 2) }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="right">${{ number_format($data['summary']['total'], 2) }}</td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Este documento es una cotización informativa y no representa un compromiso contractual.<br>
        © {{ now()->year }} DMI
    </div>

</body>
</html>
