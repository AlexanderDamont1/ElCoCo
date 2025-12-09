<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $quote['reference'] ?? '' }}</title>
    <style>
        /* Estilos profesionales para PDF */
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #10b981;
            --text-color: #1f2937;
            --light-gray: #f3f4f6;
            --border-color: #e5e7eb;
        }
        
        @page {
            margin: 50px 40px;
            font-family: 'DejaVu Sans', sans-serif;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            font-size: 12pt;
        }
        
        /* Encabezado */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 20px;
        }
        
        .company-info h1 {
            color: var(--primary-color);
            font-size: 24pt;
            margin: 0 0 5px 0;
        }
        
        .company-info p {
            margin: 0;
            color: #6b7280;
            font-size: 10pt;
        }
        
        .quote-info {
            text-align: right;
        }
        
        .quote-title {
            color: var(--primary-color);
            font-size: 20pt;
            margin: 0 0 10px 0;
        }
        
        .quote-meta {
            font-size: 10pt;
            color: #6b7280;
        }
        
        /* Información del cliente */
        .client-section {
            margin-bottom: 30px;
            background: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
        }
        
        .section-title {
            color: var(--primary-color);
            font-size: 14pt;
            margin: 0 0 15px 0;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 5px;
        }
        
        .client-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .detail-item {
            margin-bottom: 8px;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 10pt;
        }
        
        .detail-value {
            color: var(--text-color);
        }
        
        /* Tabla de cotización */
        .quote-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .quote-table thead {
            background: var(--primary-color);
            color: white;
        }
        
        .quote-table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 11pt;
        }
        
        .quote-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }
        
        .quote-table tbody tr:nth-child(even) {
            background: var(--light-gray);
        }
        
        .section-row {
            background: #dbeafe !important;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .nested-row {
            background: #f8fafc !important;
            padding-left: 30px !important;
        }
        
        .total-row {
            background: var(--accent-color) !important;
            color: white;
            font-weight: 600;
            font-size: 11pt;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Resumen de totales */
        .summary-section {
            margin-top: 30px;
            border-top: 2px solid var(--border-color);
            padding-top: 20px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .summary-value {
            font-size: 20pt;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0;
        }
        
        .summary-label {
            font-size: 10pt;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Totales */
        .totals-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 10px 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .totals-table tr:last-child td {
            border-bottom: none;
            font-weight: 600;
            font-size: 13pt;
        }
        
        .grand-total {
            background: var(--primary-color);
            color: white;
        }
        
        /* Términos y condiciones */
        .terms-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        
        .terms-content {
            font-size: 9pt;
            color: #6b7280;
            line-height: 1.4;
        }
        
        /* Firmas */
        .signatures {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid var(--border-color);
            margin: 40px 0 10px 0;
        }
        
        .signature-label {
            font-size: 10pt;
            color: #6b7280;
        }
        
        /* Utilidades */
        .page-break {
            page-break-before: always;
        }
        
        .text-primary {
            color: var(--primary-color);
        }
        
        .text-accent {
            color: var(--accent-color);
        }
        
        .font-bold {
            font-weight: 600;
        }
        
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mb-4 { margin-bottom: 20px; }
        .mb-5 { margin-bottom: 25px; }
        
        .mt-1 { margin-top: 5px; }
        .mt-2 { margin-top: 10px; }
        .mt-3 { margin-top: 15px; }
        .mt-4 { margin-top: 20px; }
        .mt-5 { margin-top: 25px; }
        
        /* Modo impresión */
        @media print {
            .no-print {
                display: none;
            }
            
            body {
                font-size: 11pt;
            }
            
            .header {
                margin-bottom: 30px;
            }
            
            .quote-table {
                font-size: 10pt;
            }
        }
        
        /* Encabezado y pie de página */
        .header-space {
            height: 50px;
        }
        
        .footer-space {
            height: 30px;
        }
        
        .header, .footer {
            position: fixed;
            left: 0;
            right: 0;
        }
        
        .header {
            top: 0;
        }
        
        .footer {
            bottom: 0;
            text-align: center;
            color: #6b7280;
            font-size: 9pt;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
        }
        
        .content {
            margin-top: 70px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <!-- Encabezado fijo -->
    <div class="header">
        <div class="company-info">
            <h1>{{ config('app.name', 'Sistema de Cotizaciones') }}</h1>
            <p>Cotización profesional de servicios tecnológicos</p>
        </div>
        <div class="quote-info">
            <h2 class="quote-title">COTIZACIÓN</h2>
            <div class="quote-meta">
                <div>Referencia: <strong>{{ $quote['reference'] ?? 'N/A' }}</strong></div>
                <div>Fecha: <strong>{{ date('d/m/Y') }}</strong></div>
                <div>Válido hasta: <strong>{{ date('d/m/Y', strtotime('+30 days')) }}</strong></div>
            </div>
        </div>
    </div>
    
    <div class="header-space"></div>
    
    <!-- Contenido principal -->
    <div class="content">
        <!-- Información del cliente -->
        <div class="client-section">
            <h3 class="section-title">Información del cliente</h3>
            <div class="client-details">
                <div class="detail-item">
                    <div class="detail-label">Cliente / Empresa</div>
                    <div class="detail-value">{{ $quote['client']['name'] ?? '' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $quote['client']['email'] ?? '' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Teléfono</div>
                    <div class="detail-value">{{ $quote['client']['phone'] ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Empresa</div>
                    <div class="detail-value">{{ $quote['client']['company'] ?? 'N/A' }}</div>
                </div>
            </div>
            
            @if(!empty($quote['client']['project_description']))
            <div class="mt-3">
                <div class="detail-label">Descripción del proyecto</div>
                <div class="detail-value">{{ $quote['client']['project_description'] }}</div>
            </div>
            @endif
        </div>
        
        <!-- Detalle de la cotización -->
        <h3 class="section-title">Detalle de servicios</h3>
        
        <table class="quote-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="40%">Descripción</th>
                    <th width="10%">Cantidad</th>
                    <th width="15%">Precio unitario</th>
                    <th width="15%">Subtotal</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rowNumber = 1;
                    $sectionNumber = 1;
                @endphp
                
                @foreach($quote['blocks'] ?? [] as $block)
                    <!-- Secciones principales -->
                    @if($block['type'] === 'section')
                        <tr class="section-row">
                            <td>{{ $sectionNumber++ }}</td>
                            <td colspan="5">
                                <strong>{{ $block['name'] }}</strong>
                                @if(!empty($block['description']))
                                    <div class="detail-value" style="font-size: 9pt; margin-top: 5px;">
                                        {{ $block['description'] }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                        
                        <!-- Bloques dentro de la sección -->
                        @foreach($block['nestedBlocks'] ?? [] as $nestedBlock)
                            @php
                                $subtotal = $nestedBlock['totalPrice'] ?? 0;
                                $quantity = $nestedBlock['quantity'] ?? 1;
                                $unitPrice = $quantity > 0 ? $subtotal / $quantity : $subtotal;
                            @endphp
                            
                            <tr class="nested-row">
                                <td></td>
                                <td>
                                    <div class="font-bold">{{ $nestedBlock['name'] ?? 'Sin nombre' }}</div>
                                    @if(!empty($nestedBlock['description']))
                                        <div style="font-size: 9pt; color: #6b7280; margin-top: 3px;">
                                            {{ $nestedBlock['description'] }}
                                        </div>
                                    @endif
                                    
                                    <!-- Detalles específicos por tipo -->
                                    @if($nestedBlock['type'] === 'course')
                                        <div style="font-size: 9pt; margin-top: 5px;">
                                            Modalidad: {{ $nestedBlock['modality'] === 'onsite' ? 'En instalaciones' : 'En línea' }} | 
                                            Participantes: {{ $nestedBlock['participants'] ?? 10 }}
                                        </div>
                                    @elseif($nestedBlock['type'] === 'software_module')
                                        <div style="font-size: 9pt; margin-top: 5px;">
                                            Complejidad: {{ ucfirst($nestedBlock['complexity'] ?? 'media') }} | 
                                            Horas: {{ $nestedBlock['estimatedHours'] ?? 0 }}
                                            @if($nestedBlock['requiresIntegration'] ?? false)
                                                | Incluye integración API
                                            @endif
                                        </div>
                                    @elseif($nestedBlock['type'] === 'audit')
                                        <div style="font-size: 9pt; margin-top: 5px;">
                                            Alcance: {{ ucfirst($nestedBlock['scope'] ?? 'standard') }} | 
                                            Sistemas: {{ $nestedBlock['systems'] ?? 1 }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $quantity }}</td>
                                <td class="text-right">${{ number_format($unitPrice, 2) }}</td>
                                <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                                <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                            </tr>
                            @php $rowNumber++; @endphp
                        @endforeach
                        
                    @else
                        <!-- Bloques individuales -->
                        @php
                            $subtotal = $block['totalPrice'] ?? 0;
                            $quantity = $block['quantity'] ?? 1;
                            $unitPrice = $quantity > 0 ? $subtotal / $quantity : $subtotal;
                        @endphp
                        
                        <tr>
                            <td>{{ $rowNumber++ }}</td>
                            <td>
                                <div class="font-bold">{{ $block['name'] ?? 'Sin nombre' }}</div>
                                @if(!empty($block['description']))
                                    <div style="font-size: 9pt; color: #6b7280; margin-top: 3px;">
                                        {{ $block['description'] }}
                                    </div>
                                @endif
                                
                                <!-- Detalles específicos por tipo -->
                                @if($block['type'] === 'audit')
                                    <div style="font-size: 9pt; margin-top: 5px;">
                                        Alcance: {{ ucfirst($block['scope'] ?? 'standard') }} | 
                                        Sistemas: {{ $block['systems'] ?? 1 }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">{{ $quantity }}</td>
                            <td class="text-right">${{ number_format($unitPrice, 2) }}</td>
                            <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                            <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
                
                <!-- Totales -->
                <tr class="total-row">
                    <td colspan="4"></td>
                    <td class="text-right font-bold">Subtotal:</td>
                    <td class="text-right font-bold">${{ number_format($quote['summary']['subtotal'] ?? 0, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4"></td>
                    <td class="text-right font-bold">IVA (16%):</td>
                    <td class="text-right font-bold">${{ number_format($quote['summary']['tax'] ?? 0, 2) }}</td>
                </tr>
                <tr class="total-row grand-total">
                    <td colspan="4"></td>
                    <td class="text-right font-bold">TOTAL:</td>
                    <td class="text-right font-bold">${{ number_format($quote['summary']['total'] ?? 0, 2) }}</td>
                </tr>
            </tbody>
        </table>
        
        <!-- Resumen estadístico -->
        <div class="summary-section">
            <h3 class="section-title mb-4">Resumen general</h3>
            
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-value">${{ number_format($quote['summary']['total'] ?? 0, 2) }}</div>
                    <div class="summary-label">Valor total</div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-value">{{ $quote['summary']['hours'] ?? 0 }}</div>
                    <div class="summary-label">Horas estimadas</div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-value">{{ $quote['summary']['blocks'] ?? 0 }}</div>
                    <div class="summary-label">Servicios incluidos</div>
                </div>
                
                <div class="summary-card">
                    <div class="summary-value">30</div>
                    <div class="summary-label">Días de validez</div>
                </div>
            </div>
            
            <!-- Tabla de totales compacta -->
            <table class="totals-table">
                <tr>
                    <td>Subtotal servicios:</td>
                    <td class="text-right">${{ number_format($quote['summary']['subtotal'] ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>IVA (16%):</td>
                    <td class="text-right">${{ number_format($quote['summary']['tax'] ?? 0, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td><strong>TOTAL A PAGAR:</strong></td>
                    <td class="text-right"><strong>${{ number_format($quote['summary']['total'] ?? 0, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        
        <!-- Términos y condiciones -->
        <div class="terms-section">
            <h3 class="section-title">Términos y condiciones</h3>
            <div class="terms-content">
                <ol>
                    <li>Esta cotización es válida por <strong>30 días</strong> a partir de la fecha de emisión.</li>
                    <li>Los precios están expresados en <strong>Pesos Mexicanos (MXN)</strong> e incluyen IVA del 16%.</li>
                    <li>El pago se realizará en <strong>dos parcialidades</strong>: 50% al inicio del proyecto y 50% al completar.</li>
                    <li>El tiempo de entrega estimado comienza una vez recibido el pago inicial y aprobados los requerimientos.</li>
                    <li>Cualquier cambio en el alcance del proyecto podrá afectar el costo y tiempo de entrega.</li>
                    <li>El cliente contará con <strong>30 días de soporte gratuito</strong> posterior a la entrega del proyecto.</li>
                    <li>Los derechos de propiedad intelectual serán transferidos al cliente una vez completado el pago total.</li>
                    <li>Cualquier discrepancia deberá ser notificada por escrito dentro de los 5 días hábiles posteriores a la recepción de esta cotización.</li>
                </ol>
                
                <div class="mt-4">
                    <p><strong>Formas de pago aceptadas:</strong> Transferencia bancaria, tarjeta de crédito/débito, PayPal.</p>
                    <p><strong>Datos bancarios:</strong> Bancomer | CLABE: 012180001234567890 | Cuenta: 1234567890</p>
                </div>
            </div>
        </div>
        
        <!-- Firmas -->
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Cliente / Empresa</div>
                <div class="detail-value">{{ $quote['client']['name'] ?? '' }}</div>
                <div class="signature-label mt-2">Fecha de aceptación</div>
            </div>
            
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">{{ config('app.name', 'Sistema de Cotizaciones') }}</div>
                <div class="signature-label mt-2">Fecha de emisión: {{ date('d/m/Y') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Pie de página fijo -->
    <div class="footer">
        <div class="footer-space"></div>
        <div class="footer-content">
            <p>
                {{ config('app.name', 'Sistema de Cotizaciones') }} | 
                Tel: +52 55 1234 5678 | 
                Email: info@{{ config('app.domain', 'ejemplo.com') }} | 
                Web: {{ config('app.url', 'https://ejemplo.com') }}
            </p>
            <p style="font-size: 8pt; color: #9ca3af;">
                Referencia: {{ $quote['reference'] ?? 'N/A' }} | 
                Página <span class="page-number"></span> de <span class="page-count"></span>
            </p>
        </div>
    </div>
    
    <script type="text/javascript">
        // Numeración de páginas
        var totalPages = Math.ceil(document.body.scrollHeight / 1123); // A4 height in pixels at 96 DPI
        document.querySelectorAll('.page-number').forEach(function(el) {
            el.textContent = 1;
        });
        document.querySelectorAll('.page-count').forEach(function(el) {
            el.textContent = totalPages;
        });
        
        // Actualizar numeración en cada página (esto se ejecuta en cada página en PDF)
        if (typeof window.PDFViewerApplication !== 'undefined') {
            window.PDFViewerApplication.eventBus.on('pagerendered', function(e) {
                var page = e.pageNumber;
                var pageElement = e.source.div;
                var pageNumberSpan = pageElement.querySelector('.page-number');
                if (pageNumberSpan) {
                    pageNumberSpan.textContent = page;
                }
            });
        }
    </script>
</body>
</html>