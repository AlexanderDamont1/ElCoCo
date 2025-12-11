<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="quoteBuilder()" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cotizador Profesional - {{ config('app.name', 'Digital Market Intelligence') }}</title>
    
    <!-- Fonts y estilos de la plantilla -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Interact.js para drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    
    <style>
        /* ===== VARIABLES DE LA PLANTILLA MELIORA ===== */
        :root {
            --primary: #2d3748;
            --primary-dark: #1a202c;
            --primary-light: #4a5568;
            --accent: #4f46e5;
            --accent-light: #6366f1;
            --accent: #374151;
            --accent-light: #4B5563;
            --accent-dark: #1F2937;
            --white: #ffffff;
            --off-white: #f7fafc;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --font-heading: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-body: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            --radius-sm: 0.25rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-full: 9999px;
            
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== RESET Y BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--off-white);
            color: var(--gray-800);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-meliora {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--gray-200);
        }

        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gray-900);
        }

        .navbar-logo img {
            height: 3rem;
            width: auto;
        }

        .nav-button {
            padding: 0.625rem 1.5rem;
            background: var(--accent);
            color: white;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all var(--transition-fast);
            border: 2px solid var(--accent);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-button:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* ===== LAYOUT PRINCIPAL ===== */
        .main-container {
            margin-top: 80px;
            padding: 2rem;
            max-width: 1600px;
            margin-left: auto;
            margin-right: auto;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 2rem;
            height: calc(100vh - 140px);
        }

        /* ===== SIDEBAR DE BLOQUES ===== */
        .blocks-sidebar {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .category-section {
            margin-bottom: 16px;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .category-header {
            padding: 12px 16px;
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
        }
        
        .category-header:hover {
            background: var(--gray-100);
        }
        
        .category-content {
            padding: 8px;
            background: white;
            display: grid;
            gap: 8px;
        }
        
        .block-item-sidebar {
            padding: 12px;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            cursor: grab;
            user-select: none;
            transition: all var(--transition-fast);
        }
        
        .block-item-sidebar:hover {
            border-color: var(--accent);
            background: var(--gray-50);
            transform: translateX(4px);
        }
        
        .block-item-sidebar:active {
            cursor: grabbing;
        }

        /* ===== CANVAS PRINCIPAL ===== */
        .construction-area {
            background: var(--white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .construction-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .canvas-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .zoom-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--gray-100);
            padding: 0.5rem;
            border-radius: var(--radius-md);
        }

        .zoom-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            background: var(--white);
            border: 1px solid var(--gray-300);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            color: var(--gray-700);
        }

        .zoom-btn:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .zoom-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .zoom-level {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            min-width: 3rem;
            text-align: center;
        }

        .canvas-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            border: 2px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            outline: none;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--gray-700);
            border-color: var(--gray-300);
        }

        .btn-secondary:hover:not(:disabled) {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ===== ÁREA DEL CANVAS ===== */
        .construction-canvas {
            flex: 1;
            position: relative;
            background: var(--gray-50);
            overflow: auto;
            min-height: 500px;
        }

        .construction-grid {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: -1px -1px;
            pointer-events: none;
            z-index: 1;
        }

        /* ===== BLOQUES DRAGGABLE ===== */
        .draggable-block {
            position: absolute;
            background: white;
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            box-shadow: var(--shadow-sm);
            cursor: move;
            user-select: none;
            transition: all var(--transition-fast);
            z-index: 10;
            min-width: 280px;
            max-width: 350px;
            transform-origin: center;
        }
        
        .draggable-block:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--accent);
        }
        
        .draggable-block.dragging {
            opacity: 0.9;
            cursor: grabbing;
            box-shadow: var(--shadow-2xl);
            transform: rotate(1deg) scale(1.02);
            z-index: 100;
        }
        
        .block-header {
            padding: 12px 16px;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            border-bottom: 1px solid var(--gray-200);
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: move;
        }
        
        .block-content {
            padding: 16px;
        }
        
        .block-actions {
            padding: 12px 16px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ===== CAMPOS DE FORMULARIO ===== */
        .field-group {
            margin-bottom: 12px;
        }

        .field-label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .field-input, .field-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all var(--transition-fast);
            background: white;
        }

        .field-input:focus, .field-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
        }

        .modifier-group {
            margin-top: 12px;
            padding: 12px;
            background: var(--gray-50);
            border-radius: 6px;
            border: 1px solid var(--gray-200);
            font-size: 0.875rem;
        }

        .price-breakdown {
            margin-top: 12px;
            padding: 12px;
            background: var(--gray-50);
            border-radius: 6px;
            border: 1px solid var(--gray-200);
            font-size: 0.875rem;
        }

        .breakdown-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .breakdown-row.total {
            font-weight: 600;
            border-top: 1px solid var(--gray-300);
            padding-top: 8px;
            margin-top: 8px;
        }

        /* ===== PANEL INFERIOR ===== */
        .summary-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            box-shadow: var(--shadow-xl);
            padding: 1.5rem;
            z-index: 900;
        }

        .summary-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            align-items: center;
        }

        .summary-total {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .summary-label {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .summary-breakdown {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .summary-item-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .summary-item-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .summary-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        /* ===== MODALES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--radius-xl);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-2xl);
        }

        /* ===== TOASTS ===== */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 400px;
        }

        .toast {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1rem 1.25rem;
            border-left: 4px solid;
            box-shadow: var(--shadow-xl);
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: toastSlideIn 0.3s ease-out forwards;
            transform: translateX(100%);
        }

        @keyframes toastSlideIn {
            to {
                transform: translateX(0);
            }
        }

        .toast-success {
            border-left-color: #10b981;
        }

        .toast-error {
            border-left-color: #ef4444;
        }

        .toast-info {
            border-left-color: #3b82f6;
        }

        .toast-warning {
            border-left-color: #f59e0b;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                height: auto;
                min-height: calc(100vh - 140px);
            }
            
            .blocks-sidebar {
                max-height: 300px;
                order: 2;
            }
            
            .construction-area {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
                margin-top: 70px;
            }
            
            .navbar-container {
                padding: 0 1rem;
            }
            
            .construction-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar-meliora">
        <div class="navbar-container">
            <a href="/" class="navbar-logo">
                <img src="/images/DMI-logob.png" alt="DMI Logo">
                <span>Cotizador</span>
            </a>
            <a href="/" class="nav-button">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Volver al Inicio
            </a>
        </div>
    </nav>

    <!-- Toasts Container -->
    <div class="toast-container"></div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="dashboard-grid">
            <!-- Sidebar de Bloques -->
            <div class="blocks-sidebar">
                <div class="sidebar-header">
                    <h2 class="text-lg font-semibold text-gray-900">Componentes</h2>
                    <p class="text-sm text-gray-600 mt-1">Arrastra bloques al área de construcción</p>
                </div>
                
                <div class="sidebar-content">
                    <!-- Categorías de Bloques -->
                    <template x-for="category in categories" :key="category.id">
                        <div class="category-section">
                            <div 
                                class="category-header"
                                @click="toggleCategory(category.id)"
                            >
                                <span class="font-medium text-gray-900" x-text="category.name"></span>
                                <svg 
                                    class="w-4 h-4 text-gray-500 transition-transform"
                                    :class="{ 'rotate-180': category.expanded }"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            
                            <div 
                                class="category-content"
                                x-show="category.expanded"
                                x-transition
                            >
                                <template x-for="block in getBlocksByCategory(category.id)" :key="block.id">
                                    <div 
                                        class="block-item-sidebar draggable"
                                        :data-block-id="block.id"
                                        draggable="true"
                                        @dragstart="onDragStart($event, block)"
                                        @dragend="onDragEnd($event)"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900" x-text="block.name"></h4>
                                                <p class="text-xs text-gray-600 mt-1" x-text="block.description"></p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-semibold text-accent" 
                                                     x-text="formatCurrency(block.base_price)"></div>
                                                <div class="text-xs text-gray-500" x-text="block.default_hours + ' horas'"></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Área de Construcción -->
            <div class="construction-area">
                <div class="construction-header">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Cotización</h1>
                        <p class="text-sm text-gray-600 mt-1" x-text="'Total: ' + formatCurrency(totalCost)"></p>
                    </div>
                    
                    <div class="canvas-controls">
                        <div class="zoom-controls">
                            <button 
                                class="zoom-btn" 
                                @click="zoomOut"
                                :disabled="zoom <= 0.5"
                                title="Alejar"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <span class="zoom-level" x-text="Math.round(zoom * 100) + '%'"></span>
                            <button 
                                class="zoom-btn" 
                                @click="zoomIn"
                                :disabled="zoom >= 2"
                                title="Acercar"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="canvas-actions">
                            <button 
                                @click="undo()"
                                :disabled="historyIndex === 0"
                                class="btn btn-secondary"
                                title="Deshacer (Ctrl+Z)"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                                Deshacer
                            </button>
                            <button 
                                @click="redo()"
                                :disabled="historyIndex >= history.length - 1"
                                class="btn btn-secondary"
                                title="Rehacer (Ctrl+Y)"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
                                </svg>
                                Rehacer
                            </button>
                            <button 
                                @click="clearCanvas"
                                :disabled="placedBlocks.length === 0"
                                class="btn btn-secondary"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Limpiar
                            </button>
                            <button @click="saveQuote()" class="btn btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Guardar
                            </button>
                            <button @click="showSubmitModal = true" class="btn btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Enviar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div 
                    class="construction-canvas"
                    id="construction-canvas"
                    @dragover.prevent="onCanvasDragOver"
                    @drop.prevent="onCanvasDrop"
                >
                    <!-- Grid de fondo -->
                    <div class="construction-grid"></div>
                    
                    <!-- Bloques colocados -->
                    <template x-for="(block, index) in placedBlocks" :key="block.instanceId">
                        <div 
                            class="draggable-block"
                            :class="{ 'dragging': block.isDragging }"
                            :style="{
                                left: block.x + 'px',
                                top: block.y + 'px',
                                zIndex: block.zIndex || 10,
                                transform: 'scale(' + zoom + ')'
                            }"
                            :data-instance-id="block.instanceId"
                        >
                            <div 
                                class="block-header draggable"
                                @mousedown="startDrag($event, block)"
                            >
                                <div class="flex items-center justify-between w-full">
                                    <div>
                                        <h3 class="font-medium text-gray-900" x-text="block.name"></h3>
                                        <p class="text-xs text-gray-600 mt-1" x-text="block.description"></p>
                                    </div>
                                    <button 
                                        @click="removeBlock(block.instanceId)"
                                        class="p-1 hover:bg-red-50 text-red-600 rounded"
                                        title="Eliminar bloque"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="block-content">
                                <!-- Campos específicos por tipo de bloque -->
                                <template x-if="block.type === 'course'">
                                    <div class="space-y-3">
                                        <div class="field-group">
                                            <label class="field-label">Modalidad</label>
                                            <select 
                                                x-model="block.modality"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="online">En línea</option>
                                                <option value="onsite">Presencial</option>
                                                <option value="hybrid">Híbrido</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Nivel de dificultad</label>
                                            <select 
                                                x-model="block.difficulty"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="basic">Básico</option>
                                                <option value="intermediate">Intermedio</option>
                                                <option value="advanced">Avanzado</option>
                                                <option value="expert">Experto</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Número de participantes</label>
                                            <input 
                                                type="number" 
                                                x-model="block.participants"
                                                min="1"
                                                @change="updateBlockPrice(block)"
                                                class="field-input"
                                            />
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Horas estimadas</label>
                                            <input 
                                                type="number" 
                                                x-model="block.hours"
                                                min="1"
                                                @change="updateBlockPrice(block)"
                                                class="field-input"
                                            />
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Materiales incluidos</label>
                                            <select 
                                                x-model="block.materials"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="basic">Básicos (digital)</option>
                                                <option value="premium">Premium (digital + físico)</option>
                                                <option value="complete">Completo (digital + físico + certificado)</option>
                                            </select>
                                        </div>
                                        <div class="price-breakdown" x-show="block.totalPrice > 0">
                                            <div class="breakdown-row">
                                                <span>Precio base:</span>
                                                <span x-text="formatCurrency(block.base_price)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Modalidad (<span x-text="getModalityName(block.modality)"></span>):</span>
                                                <span x-text="formatCurrency(block.modalityPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Dificultad (<span x-text="getDifficultyName(block.difficulty)"></span>):</span>
                                                <span x-text="formatCurrency(block.difficultyPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Participantes (<span x-text="block.participants"></span>):</span>
                                                <span x-text="formatCurrency(block.participantsPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Materiales (<span x-text="getMaterialsName(block.materials)"></span>):</span>
                                                <span x-text="formatCurrency(block.materialsPrice)"></span>
                                            </div>
                                            <div class="breakdown-row total">
                                                <span>Subtotal:</span>
                                                <span x-text="formatCurrency(block.subtotal)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <template x-if="block.type === 'software_module'">
                                    <div class="space-y-3">
                                        <div class="field-group">
                                            <label class="field-label">Complejidad del módulo</label>
                                            <select 
                                                x-model="block.complexity"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="simple">Simple</option>
                                                <option value="medium">Medio</option>
                                                <option value="complex">Complejo</option>
                                                <option value="very_complex">Muy Complejo</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Horas estimadas de desarrollo</label>
                                            <input 
                                                type="number" 
                                                x-model="block.hours"
                                                min="1"
                                                @change="updateBlockPrice(block)"
                                                class="field-input"
                                            />
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Integraciones requeridas</label>
                                            <select 
                                                x-model="block.integrations"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="none">Ninguna</option>
                                                <option value="basic">Básicas (1-2 APIs)</option>
                                                <option value="advanced">Avanzadas (3+ APIs)</option>
                                                <option value="custom">Personalizadas</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Pruebas y QA</label>
                                            <select 
                                                x-model="block.testing"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="basic">Básico</option>
                                                <option value="standard">Estándar</option>
                                                <option value="comprehensive">Comprehensivo</option>
                                                <option value="enterprise">Enterprise</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Soporte post-desarrollo</label>
                                            <select 
                                                x-model="block.support"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="none">Sin soporte</option>
                                                <option value="1month">1 mes</option>
                                                <option value="3months">3 meses</option>
                                                <option value="6months">6 meses</option>
                                                <option value="12months">12 meses</option>
                                            </select>
                                        </div>
                                        <div class="price-breakdown" x-show="block.totalPrice > 0">
                                            <div class="breakdown-row">
                                                <span>Precio base:</span>
                                                <span x-text="formatCurrency(block.base_price)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Complejidad (<span x-text="getComplexityName(block.complexity)"></span>):</span>
                                                <span x-text="formatCurrency(block.complexityPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Horas (<span x-text="block.hours"></span> hrs):</span>
                                                <span x-text="formatCurrency(block.hoursPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Integraciones:</span>
                                                <span x-text="formatCurrency(block.integrationsPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Pruebas y QA:</span>
                                                <span x-text="formatCurrency(block.testingPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Soporte:</span>
                                                <span x-text="formatCurrency(block.supportPrice)"></span>
                                            </div>
                                            <div class="breakdown-row total">
                                                <span>Subtotal:</span>
                                                <span x-text="formatCurrency(block.subtotal)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <template x-if="block.type === 'audit'">
                                    <div class="space-y-3">
                                        <div class="field-group">
                                            <label class="field-label">Alcance de auditoría</label>
                                            <select 
                                                x-model="block.scope"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="basic">Básico</option>
                                                <option value="standard">Estándar</option>
                                                <option value="comprehensive">Comprehensivo</option>
                                                <option value="enterprise">Enterprise</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Número de sistemas</label>
                                            <input 
                                                type="number" 
                                                x-model="block.systems"
                                                min="1"
                                                @change="updateBlockPrice(block)"
                                                class="field-input"
                                            />
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Complejidad técnica</label>
                                            <select 
                                                x-model="block.technical_complexity"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="low">Baja</option>
                                                <option value="medium">Media</option>
                                                <option value="high">Alta</option>
                                                <option value="very_high">Muy Alta</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Horas estimadas</label>
                                            <input 
                                                type="number" 
                                                x-model="block.hours"
                                                min="1"
                                                @change="updateBlockPrice(block)"
                                                class="field-input"
                                            />
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Reporte detallado</label>
                                            <select 
                                                x-model="block.report_type"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="summary">Resumen</option>
                                                <option value="detailed">Detallado</option>
                                                <option value="executive">Ejecutivo + Técnico</option>
                                                <option value="complete">Completo con recomendaciones</option>
                                            </select>
                                        </div>
                                        <div class="price-breakdown" x-show="block.totalPrice > 0">
                                            <div class="breakdown-row">
                                                <span>Precio base:</span>
                                                <span x-text="formatCurrency(block.base_price)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Alcance:</span>
                                                <span x-text="formatCurrency(block.scopePrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Sistemas (<span x-text="block.systems"></span>):</span>
                                                <span x-text="formatCurrency(block.systemsPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Complejidad técnica:</span>
                                                <span x-text="formatCurrency(block.technicalPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Horas (<span x-text="block.hours"></span> hrs):</span>
                                                <span x-text="formatCurrency(block.hoursPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Reporte:</span>
                                                <span x-text="formatCurrency(block.reportPrice)"></span>
                                            </div>
                                            <div class="breakdown-row total">
                                                <span>Subtotal:</span>
                                                <span x-text="formatCurrency(block.subtotal)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <!-- Bloque genérico para otros tipos -->
                                <template x-if="['maintenance', 'consulting', 'other'].includes(block.type)">
                                    <div class="space-y-3">
                                        <div class="field-group">
                                            <label class="field-label">Nivel de servicio</label>
                                            <select 
                                                x-model="block.service_level"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="basic">Básico</option>
                                                <option value="standard">Estándar</option>
                                                <option value="premium">Premium</option>
                                                <option value="enterprise">Enterprise</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Horas estimadas</label>
                                            <input 
                                                type="number" 
                                                x-model="block.hours"
                                                min="1"
                                                @change="updateBlockPrice(block)"
                                                class="field-input"
                                            />
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Frecuencia</label>
                                            <select 
                                                x-model="block.frequency"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="one_time">Una vez</option>
                                                <option value="weekly">Semanal</option>
                                                <option value="monthly">Mensual</option>
                                                <option value="quarterly">Trimestral</option>
                                                <option value="yearly">Anual</option>
                                            </select>
                                        </div>
                                        <div class="field-group">
                                            <label class="field-label">Prioridad</label>
                                            <select 
                                                x-model="block.priority"
                                                @change="updateBlockPrice(block)"
                                                class="field-select"
                                            >
                                                <option value="low">Baja</option>
                                                <option value="normal">Normal</option>
                                                <option value="high">Alta</option>
                                                <option value="critical">Crítica</option>
                                            </select>
                                        </div>
                                        <div class="price-breakdown" x-show="block.totalPrice > 0">
                                            <div class="breakdown-row">
                                                <span>Precio base:</span>
                                                <span x-text="formatCurrency(block.base_price)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Nivel de servicio:</span>
                                                <span x-text="formatCurrency(block.serviceLevelPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Horas (<span x-text="block.hours"></span> hrs):</span>
                                                <span x-text="formatCurrency(block.hoursPrice)"></span>
                                            </div>
                                            <div class="breakdown-row">
                                                <span>Frecuencia:</span>
                                                <span x-text="formatCurrency(block.frequencyPrice)"></span>
                                            </div>
                                            <div class="breakdown-row total">
                                                <span>Subtotal:</span>
                                                <span x-text="formatCurrency(block.subtotal)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <!-- Cantidad para todos los bloques -->
                                <div class="field-group mt-4">
                                    <label class="field-label">Cantidad</label>
                                    <input 
                                        type="number" 
                                        x-model="block.quantity"
                                        min="1"
                                        @change="updateBlockPrice(block)"
                                        class="field-input"
                                    />
                                </div>
                            </div>
                            
                            <div class="block-actions">
                                <div class="text-sm font-semibold text-accent">
                                    Total: <span x-text="formatCurrency(block.totalPrice)"></span>
                                    <span class="text-xs text-gray-500 ml-2" x-text="block.hours + ' horas'"></span>
                                </div>
                                <button 
                                    @click="duplicateBlock(block.instanceId)"
                                    class="text-xs text-gray-600 hover:text-accent p-1"
                                    title="Duplicar bloque"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                    
                    <!-- Indicador de ayuda cuando está vacío -->
                    <div 
                        x-show="placedBlocks.length === 0"
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center p-8"
                    >
                        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Comienza a construir tu cotización</h3>
                        <p class="text-gray-600 mb-6 max-w-md">
                            Arrastra bloques desde el panel izquierdo al área de construcción para personalizar tu cotización.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Resumen -->
    <div class="summary-panel">
        <div class="summary-grid">
            <div class="summary-total">
                <div class="summary-label">Total estimado</div>
                <div class="summary-value" x-text="formatCurrency(totalCost)"></div>
                <div class="text-sm text-gray-500" x-text="totalHours + ' horas estimadas'"></div>
            </div>
            
            <div class="summary-breakdown">
                <div class="summary-item">
                    <div class="summary-item-label">Servicios</div>
                    <div class="summary-item-value" x-text="placedBlocks.length"></div>
                </div>
                <div class="summary-item">
                    <div class="summary-item-label">IVA (16%)</div>
                    <div class="summary-item-value" x-text="formatCurrency(totalTax)"></div>
                </div>
                <div class="summary-item">
                    <div class="summary-item-label">Subtotal</div>
                    <div class="summary-item-value" x-text="formatCurrency(subtotal)"></div>
                </div>
            </div>
            
            <div class="summary-actions">
                <button 
                    class="btn btn-secondary"
                    @click="exportPDF"
                    :disabled="placedBlocks.length === 0"
                >
                    Exportar PDF
                </button>
                <button 
                    class="btn btn-primary"
                    @click="showSubmitModal = true"
                    :disabled="placedBlocks.length === 0"
                >
                    Enviar Cotización
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para enviar cotización -->
    <div 
        x-show="showSubmitModal"
        x-transition
        class="modal-overlay"
        @click.self="showSubmitModal = false"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Enviar Cotización</h2>
                <button class="modal-close" @click="showSubmitModal = false">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="space-y-4">
                    <div>
                        <label class="field-label">Nombre completo</label>
                        <input 
                            type="text" 
                            class="field-input" 
                            x-model="clientForm.name" 
                            placeholder="Nombre del cliente"
                        >
                    </div>
                    
                    <div>
                        <label class="field-label">Email</label>
                        <input 
                            type="email" 
                            class="field-input" 
                            x-model="clientForm.email" 
                            placeholder="correo@empresa.com"
                        >
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3">Resumen de la cotización</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span x-text="formatCurrency(subtotal)"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">IVA (16%):</span>
                                <span x-text="formatCurrency(totalTax)"></span>
                            </div>
                            <div class="flex items-center justify-between font-semibold text-lg pt-2 border-t border-gray-200">
                                <span class="text-gray-900">Total:</span>
                                <span class="text-accent" x-text="formatCurrency(totalCost)"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 pt-6">
                        <button 
                            type="button"
                            class="btn btn-secondary flex-1"
                            @click="showSubmitModal = false"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button"
                            class="btn btn-primary flex-1"
                            @click="submitQuote()"
                        >
                            Enviar Cotización
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function quoteBuilder() {
        return {
            // Estado inicial
            categories: [],
            blocks: [],
            placedBlocks: [],
            zoom: 1,
            
            // UI State
            showSubmitModal: false,
            showSuccessModal: false,
            isSubmitting: false,
            isExportingPDF: false,
            
            // Historial
            history: [],
            historyIndex: -1,
            
            // Formulario de cliente
            clientForm: {
                name: '',
                email: '',
                company: '',
                phone: '',
                project_description: ''
            },
            
            // Estado temporal para drag & drop
            draggedBlock: null,
            
            // Propiedades computadas
            get subtotal() {
                return this.placedBlocks.reduce((total, block) => {
                    return total + (block.subtotal || 0);
                }, 0);
            },
            
            get totalTax() {
                return this.subtotal * 0.16;
            },
            
            get totalCost() {
                return this.subtotal + this.totalTax;
            },
            
            get totalHours() {
                return this.placedBlocks.reduce((total, block) => {
                    return total + (block.hours || 0) * (block.quantity || 1);
                }, 0);
            },
            
            // Métodos de inicialización
            async init() {
                await this.loadBlocks();
                this.loadSavedState();
                
                // Inicializar interact.js después de que los elementos estén en el DOM
                this.$nextTick(() => {
                    this.setupInteractJS();
                });
                
                this.setupKeyboardShortcuts();
                this.setupAutoSave();
                
                // Inicializar historial
                this.saveToHistory();
            },
            
            async loadBlocks() {
                try {
                    // Datos de ejemplo
                    this.categories = [
                        { id: 'courses', name: 'Cursos y Capacitación', expanded: true },
                        { id: 'software', name: 'Desarrollo de Software', expanded: true },
                        { id: 'audits', name: 'Auditorías', expanded: true },
                        { id: 'maintenance', name: 'Mantenimiento', expanded: true },
                        { id: 'consulting', name: 'Consultoría', expanded: true }
                    ];
                    
                    this.blocks = [
                        {
                            id: 'course_basic',
                            name: 'Curso Básico',
                            description: 'Curso introductorio',
                            type: 'course',
                            category_id: 'courses',
                            default_hours: 20,
                            base_price: 10000
                        },
                        {
                            id: 'course_advanced',
                            name: 'Curso Avanzado',
                            description: 'Curso especializado',
                            type: 'course',
                            category_id: 'courses',
                            default_hours: 40,
                            base_price: 20000
                        },
                        {
                            id: 'software_module',
                            name: 'Módulo de Software',
                            description: 'Desarrollo personalizado',
                            type: 'software_module',
                            category_id: 'software',
                            default_hours: 80,
                            base_price: 40000
                        },
                        {
                            id: 'security_audit',
                            name: 'Auditoría de Seguridad',
                            description: 'Evaluación completa',
                            type: 'audit',
                            category_id: 'audits',
                            default_hours: 40,
                            base_price: 15000
                        },
                        {
                            id: 'monthly_maintenance',
                            name: 'Mantenimiento Mensual',
                            description: 'Soporte continuo',
                            type: 'maintenance',
                            category_id: 'maintenance',
                            default_hours: 20,
                            base_price: 8000
                        },
                        {
                            id: 'consulting_hours',
                            name: 'Horas de Consultoría',
                            description: 'Asesoría especializada',
                            type: 'consulting',
                            category_id: 'consulting',
                            default_hours: 10,
                            base_price: 5000
                        }
                    ];
                    
                } catch (error) {
                    console.error('Error loading blocks:', error);
                    this.showToast('Error al cargar los bloques', 'error');
                }
            },
            
            getBlocksByCategory(categoryId) {
                return this.blocks.filter(block => block.category_id === categoryId);
            },
            
            toggleCategory(categoryId) {
                const category = this.categories.find(c => c.id === categoryId);
                if (category) {
                    category.expanded = !category.expanded;
                }
            },
            
            // Drag & Drop
            onDragStart(event, block) {
                event.dataTransfer.setData('text/plain', JSON.stringify(block));
                event.dataTransfer.effectAllowed = 'copy';
                this.draggedBlock = block;
                
                // Agregar efecto visual
                event.target.classList.add('dragging');
            },
            
            onDragEnd(event) {
                event.target.classList.remove('dragging');
                this.draggedBlock = null;
            },
            
            onCanvasDragOver(event) {
                event.preventDefault();
                event.dataTransfer.dropEffect = 'copy';
            },
            
            onCanvasDrop(event) {
                event.preventDefault();
                
                try {
                    const blockData = JSON.parse(event.dataTransfer.getData('text/plain'));
                    const canvas = document.getElementById('construction-canvas');
                    const rect = canvas.getBoundingClientRect();
                    
                    const x = (event.clientX - rect.left) / this.zoom - 140;
                    const y = (event.clientY - rect.top) / this.zoom - 50;
                    
                    this.addBlockToCanvas(blockData, x, y);
                } catch (error) {
                    console.error('Error dropping block:', error);
                }
            },
            
            addBlockToCanvas(blockData, x, y) {
                const instanceId = 'block_' + Date.now() + Math.random().toString(36).substr(2, 9);
                
                // Inicializar el bloque con valores por defecto
                const block = {
                    ...this.initializeBlockData(blockData),
                    instanceId,
                    x: Math.max(0, x),
                    y: Math.max(0, y),
                    zIndex: 10,
                    isDragging: false
                };
                
                // Calcular precio inicial
                this.updateBlockPrice(block);
                
                this.placedBlocks.push(block);
                this.saveToHistory();
                
                this.showToast('Bloque agregado', 'success');
            },
            
            initializeBlockData(blockData) {
                const baseBlock = {
                    ...blockData,
                    quantity: 1,
                    hours: blockData.default_hours || 20
                };
                
                // Inicializar propiedades específicas según el tipo
                switch (blockData.type) {
                    case 'course':
                        baseBlock.modality = 'online';
                        baseBlock.difficulty = 'basic';
                        baseBlock.participants = 10;
                        baseBlock.materials = 'basic';
                        break;
                        
                    case 'software_module':
                        baseBlock.complexity = 'medium';
                        baseBlock.hours = blockData.default_hours || 80;
                        baseBlock.integrations = 'none';
                        baseBlock.testing = 'standard';
                        baseBlock.support = '1month';
                        break;
                        
                    case 'audit':
                        baseBlock.scope = 'standard';
                        baseBlock.systems = 1;
                        baseBlock.technical_complexity = 'medium';
                        baseBlock.hours = blockData.default_hours || 40;
                        baseBlock.report_type = 'detailed';
                        break;
                        
                    case 'maintenance':
                    case 'consulting':
                    case 'other':
                        baseBlock.service_level = 'standard';
                        baseBlock.hours = blockData.default_hours || 20;
                        baseBlock.frequency = 'monthly';
                        baseBlock.priority = 'normal';
                        break;
                }
                
                return baseBlock;
            },
            
            // Cálculos de precios con desglose
            updateBlockPrice(block) {
                // Reiniciar precios
                block.subtotal = block.base_price || 0;
                block.totalPrice = 0;
                
                // Calcular según el tipo de bloque
                switch (block.type) {
                    case 'course':
                        this.calculateCoursePrice(block);
                        break;
                    case 'software_module':
                        this.calculateSoftwarePrice(block);
                        break;
                    case 'audit':
                        this.calculateAuditPrice(block);
                        break;
                    default:
                        this.calculateGenericPrice(block);
                }
                
                // Aplicar cantidad
                block.totalPrice = block.subtotal * block.quantity;
                
                // Actualizar historial
                this.saveToHistory();
            },
            
            calculateCoursePrice(block) {
                // Precios base por concepto
                const modalityPrices = {
                    'online': 0,
                    'onsite': block.base_price * 0.3,
                    'hybrid': block.base_price * 0.15
                };
                
                const difficultyPrices = {
                    'basic': 0,
                    'intermediate': block.base_price * 0.2,
                    'advanced': block.base_price * 0.4,
                    'expert': block.base_price * 0.6
                };
                
                const materialsPrices = {
                    'basic': 0,
                    'premium': 2000,
                    'complete': 4000
                };
                
                // Calcular precios individuales
                block.modalityPrice = modalityPrices[block.modality] || 0;
                block.difficultyPrice = difficultyPrices[block.difficulty] || 0;
                block.participantsPrice = Math.max(0, (block.participants - 10) * 500);
                block.materialsPrice = materialsPrices[block.materials] || 0;
                block.hoursPrice = Math.max(0, (block.hours - 20) * 300);
                
                // Calcular subtotal
                block.subtotal = block.base_price + 
                               block.modalityPrice + 
                               block.difficultyPrice + 
                               block.participantsPrice + 
                               block.materialsPrice + 
                               block.hoursPrice;
            },
            
            calculateSoftwarePrice(block) {
                // Factores de complejidad
                const complexityFactors = {
                    'simple': 1.0,
                    'medium': 1.5,
                    'complex': 2.0,
                    'very_complex': 2.5
                };
                
                const integrationPrices = {
                    'none': 0,
                    'basic': 5000,
                    'advanced': 10000,
                    'custom': 20000
                };
                
                const testingPrices = {
                    'basic': 0,
                    'standard': 3000,
                    'comprehensive': 6000,
                    'enterprise': 10000
                };
                
                const supportPrices = {
                    'none': 0,
                    '1month': 2000,
                    '3months': 5000,
                    '6months': 8000,
                    '12months': 12000
                };
                
                // Calcular precios
                const complexityFactor = complexityFactors[block.complexity] || 1.5;
                block.complexityPrice = (block.base_price * (complexityFactor - 1));
                block.hoursPrice = Math.max(0, (block.hours - 80) * 800);
                block.integrationsPrice = integrationPrices[block.integrations] || 0;
                block.testingPrice = testingPrices[block.testing] || 0;
                block.supportPrice = supportPrices[block.support] || 0;
                
                // Calcular subtotal
                block.subtotal = (block.base_price * complexityFactor) + 
                               block.hoursPrice + 
                               block.integrationsPrice + 
                               block.testingPrice + 
                               block.supportPrice;
            },
            
            calculateAuditPrice(block) {
                // Factores de precio
                const scopeFactors = {
                    'basic': 0.7,
                    'standard': 1.0,
                    'comprehensive': 1.4,
                    'enterprise': 1.8
                };
                
                const technicalFactors = {
                    'low': 1.0,
                    'medium': 1.3,
                    'high': 1.6,
                    'very_high': 2.0
                };
                
                const reportPrices = {
                    'summary': 0,
                    'detailed': 2000,
                    'executive': 4000,
                    'complete': 6000
                };
                
                // Calcular precios
                const scopeFactor = scopeFactors[block.scope] || 1.0;
                block.scopePrice = (block.base_price * (scopeFactor - 1));
                block.systemsPrice = Math.max(0, (block.systems - 1) * 2000);
                
                const techFactor = technicalFactors[block.technical_complexity] || 1.0;
                block.technicalPrice = (block.base_price * (techFactor - 1));
                
                block.hoursPrice = Math.max(0, (block.hours - 40) * 500);
                block.reportPrice = reportPrices[block.report_type] || 0;
                
                // Calcular subtotal
                block.subtotal = (block.base_price * scopeFactor * techFactor) + 
                               block.systemsPrice + 
                               block.hoursPrice + 
                               block.reportPrice;
            },
            
            calculateGenericPrice(block) {
                // Para bloques genéricos
                const serviceLevelFactors = {
                    'basic': 0.8,
                    'standard': 1.0,
                    'premium': 1.3,
                    'enterprise': 1.6
                };
                
                const frequencyFactors = {
                    'one_time': 1.0,
                    'weekly': 4.0,
                    'monthly': 1.0,
                    'quarterly': 0.9,
                    'yearly': 10.0
                };
                
                const priorityFactors = {
                    'low': 0.9,
                    'normal': 1.0,
                    'high': 1.2,
                    'critical': 1.5
                };
                
                // Calcular factores
                const serviceFactor = serviceLevelFactors[block.service_level] || 1.0;
                const frequencyFactor = frequencyFactors[block.frequency] || 1.0;
                const priorityFactor = priorityFactors[block.priority] || 1.0;
                
                // Calcular precios
                block.serviceLevelPrice = (block.base_price * (serviceFactor - 1));
                block.hoursPrice = Math.max(0, (block.hours - 20) * 400);
                block.frequencyPrice = (block.base_price * (frequencyFactor - 1));
                
                // Calcular subtotal
                block.subtotal = (block.base_price * serviceFactor * frequencyFactor * priorityFactor) + 
                               block.hoursPrice;
            },
            
            // Helper functions para nombres
            getModalityName(modality) {
                const names = {
                    'online': 'En línea',
                    'onsite': 'Presencial',
                    'hybrid': 'Híbrido'
                };
                return names[modality] || modality;
            },
            
            getDifficultyName(difficulty) {
                const names = {
                    'basic': 'Básico',
                    'intermediate': 'Intermedio',
                    'advanced': 'Avanzado',
                    'expert': 'Experto'
                };
                return names[difficulty] || difficulty;
            },
            
            getMaterialsName(materials) {
                const names = {
                    'basic': 'Básicos',
                    'premium': 'Premium',
                    'complete': 'Completos'
                };
                return names[materials] || materials;
            },
            
            getComplexityName(complexity) {
                const names = {
                    'simple': 'Simple',
                    'medium': 'Medio',
                    'complex': 'Complejo',
                    'very_complex': 'Muy Complejo'
                };
                return names[complexity] || complexity;
            },
            
            // Gestión de bloques
            removeBlock(instanceId) {
                this.placedBlocks = this.placedBlocks.filter(b => b.instanceId !== instanceId);
                this.saveToHistory();
                this.showToast('Bloque eliminado', 'info');
            },
            
            duplicateBlock(instanceId) {
                const original = this.placedBlocks.find(b => b.instanceId === instanceId);
                if (original) {
                    const duplicate = JSON.parse(JSON.stringify(original));
                    duplicate.instanceId = 'block_' + Date.now() + Math.random().toString(36).substr(2, 9);
                    duplicate.x += 20;
                    duplicate.y += 20;
                    
                    this.placedBlocks.push(duplicate);
                    this.saveToHistory();
                    this.showToast('Bloque duplicado', 'success');
                }
            },
            
            // Zoom
            zoomIn() {
                if (this.zoom < 2) {
                    this.zoom += 0.1;
                }
            },
            
            zoomOut() {
                if (this.zoom > 0.5) {
                    this.zoom -= 0.1;
                }
            },
            
            // Historial
            saveToHistory() {
                // Limitar historial a 50 estados
                if (this.history.length >= 50) {
                    this.history.shift();
                }
                
                // Eliminar estados futuros si estamos en medio del historial
                this.history = this.history.slice(0, this.historyIndex + 1);
                
                // Guardar estado actual
                const state = {
                    placedBlocks: JSON.parse(JSON.stringify(this.placedBlocks)),
                    zoom: this.zoom
                };
                
                this.history.push(state);
                this.historyIndex = this.history.length - 1;
            },
            
            undo() {
                if (this.historyIndex > 0) {
                    this.historyIndex--;
                    const state = this.history[this.historyIndex];
                    this.placedBlocks = JSON.parse(JSON.stringify(state.placedBlocks));
                    this.zoom = state.zoom;
                    this.showToast('Cambio deshecho', 'info');
                }
            },
            
            redo() {
                if (this.historyIndex < this.history.length - 1) {
                    this.historyIndex++;
                    const state = this.history[this.historyIndex];
                    this.placedBlocks = JSON.parse(JSON.stringify(state.placedBlocks));
                    this.zoom = state.zoom;
                    this.showToast('Cambio rehecho', 'info');
                }
            },
            
            // Drag & Drop con interact.js
            setupInteractJS() {
                interact('.draggable-block')
                    .draggable({
                        listeners: {
                            start: (event) => {
                                const instanceId = event.target.getAttribute('data-instance-id');
                                const block = this.placedBlocks.find(b => b.instanceId === instanceId);
                                if (block) {
                                    block.isDragging = true;
                                    block.zIndex = 100;
                                }
                            },
                            move: (event) => {
                                const instanceId = event.target.getAttribute('data-instance-id');
                                const block = this.placedBlocks.find(b => b.instanceId === instanceId);
                                if (block) {
                                    block.x += event.dx / this.zoom;
                                    block.y += event.dy / this.zoom;
                                    
                                    // Mantener dentro del canvas
                                    const canvas = document.getElementById('construction-canvas');
                                    const rect = canvas.getBoundingClientRect();
                                    const maxX = rect.width - event.target.offsetWidth;
                                    const maxY = rect.height - event.target.offsetHeight;
                                    
                                    block.x = Math.max(0, Math.min(block.x, maxX));
                                    block.y = Math.max(0, Math.min(block.y, maxY));
                                }
                            },
                            end: (event) => {
                                const instanceId = event.target.getAttribute('data-instance-id');
                                const block = this.placedBlocks.find(b => b.instanceId === instanceId);
                                if (block) {
                                    block.isDragging = false;
                                    block.zIndex = 10;
                                    this.saveToHistory();
                                }
                            }
                        },
                        modifiers: [
                            interact.modifiers.restrictRect({
                                restriction: 'parent',
                                endOnly: true
                            })
                        ]
                    });
            },
            
            // Atajos de teclado
            setupKeyboardShortcuts() {
                document.addEventListener('keydown', (event) => {
                    // Ctrl+Z para deshacer
                    if ((event.ctrlKey || event.metaKey) && event.key === 'z' && !event.shiftKey) {
                        event.preventDefault();
                        this.undo();
                    }
                    
                    // Ctrl+Y o Ctrl+Shift+Z para rehacer
                    if ((event.ctrlKey || event.metaKey) && (event.key === 'y' || (event.key === 'z' && event.shiftKey))) {
                        event.preventDefault();
                        this.redo();
                    }
                });
            },
            
            // Guardado automático
            setupAutoSave() {
                // Guardar cada 30 segundos si hay cambios
                setInterval(() => {
                    if (this.placedBlocks.length > 0) {
                        this.saveState();
                    }
                }, 30000);
            },
            
            loadSavedState() {
                try {
                    const saved = localStorage.getItem('quoteBuilderState');
                    if (saved) {
                        const state = JSON.parse(saved);
                        this.placedBlocks = state.placedBlocks || [];
                        this.zoom = state.zoom || 1;
                        
                        // Recalcular precios para todos los bloques
                        this.placedBlocks.forEach(block => this.updateBlockPrice(block));
                    }
                } catch (error) {
                    console.error('Error loading saved state:', error);
                }
            },
            
            saveState() {
                try {
                    const state = {
                        placedBlocks: this.placedBlocks,
                        zoom: this.zoom
                    };
                    localStorage.setItem('quoteBuilderState', JSON.stringify(state));
                } catch (error) {
                    console.error('Error saving state:', error);
                }
            },
            
            clearCanvas() {
                if (this.placedBlocks.length > 0) {
                    if (confirm('¿Estás seguro de que quieres limpiar todo el canvas? Esta acción no se puede deshacer.')) {
                        this.placedBlocks = [];
                        this.saveToHistory();
                        this.showToast('Canvas limpiado', 'info');
                    }
                }
            },
            
            // Formateo
            formatCurrency(value) {
                return new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: 'MXN',
                    minimumFractionDigits: 2
                }).format(value || 0);
            },
            
            // Toasts
            showToast(message, type = 'info') {
                const container = document.querySelector('.toast-container');
                if (!container) return;
                
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                toast.innerHTML = `
                    <div class="flex-1">
                        <div class="text-sm font-medium">${message}</div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                
                container.appendChild(toast);
                
                // Auto-remover después de 5 segundos
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 5000);
            },
            
            // Funciones de guardado y envío
            async saveQuote() {
                try {
                    const quoteData = {
                        blocks: this.placedBlocks,
                        total: this.totalCost,
                        subtotal: this.subtotal,
                        tax: this.totalTax,
                        hours: this.totalHours
                    };
                    
                    // Aquí iría la llamada a la API
                    this.showToast('Cotización guardada exitosamente', 'success');
                } catch (error) {
                    console.error('Error saving quote:', error);
                    this.showToast('Error al guardar la cotización', 'error');
                }
            },
            
            async submitQuote() {
                this.isSubmitting = true;
                
                try {
                    // Validar formulario
                    if (!this.clientForm.name || !this.clientForm.email) {
                        this.showToast('Por favor completa los campos requeridos', 'error');
                        return;
                    }
                    
                    const quoteData = {
                        client: this.clientForm,
                        quote: {
                            blocks: this.placedBlocks,
                            total: this.totalCost,
                            subtotal: this.subtotal,
                            tax: this.totalTax,
                            hours: this.totalHours
                        }
                    };
                    
                    // Aquí iría la llamada a la API
                    await new Promise(resolve => setTimeout(resolve, 1000)); // Simulación
                    
                    this.showSubmitModal = false;
                    this.showToast('Cotización enviada exitosamente', 'success');
                    
                    // Limpiar formulario
                    this.clientForm = {
                        name: '',
                        email: '',
                        company: '',
                        phone: '',
                        project_description: ''
                    };
                    
                } catch (error) {
                    console.error('Error submitting quote:', error);
                    this.showToast('Error al enviar la cotización', 'error');
                } finally {
                    this.isSubmitting = false;
                }
            },
            
            async exportPDF() {
                this.isExportingPDF = true;
                
                try {
                    // Simulación de generación de PDF
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    
                    // Crear PDF simulado
                    const blob = new Blob(['Simulación de PDF'], { type: 'application/pdf' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `cotizacion-dmi-${Date.now()}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                    
                    this.showToast('PDF generado exitosamente', 'success');
                } catch (error) {
                    console.error('Error generating PDF:', error);
                    this.showToast('Error al generar el PDF', 'error');
                } finally {
                    this.isExportingPDF = false;
                }
            },
            
            startDrag(event, block) {
                // El drag se maneja con interact.js
            }
        }
    }
    </script>

    <!-- Script para la navbar -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
    </script>
</body>
</html>