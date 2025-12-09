<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="quoteBuilder()" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cotizador Profesional - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Interact.js para drag & drop avanzado como Tinkercad -->
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    
    <style>
        /* Variables de diseño profesional */
        :root {
            /* Paleta profesional */
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --primary-800: #1e40af;
            --primary-900: #1e3a8a;
            
            /* Neutrales para interfaz profesional */
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-400: #a3a3a3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
            
            /* Estados */
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #3b82f6;
            
            /* Sombras y profundidad */
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            /* Animaciones */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
            
            /* Z-index */
            --z-drop-area: 10;
            --z-block-dragging: 100;
            --z-modal: 1000;
            --z-toast: 2000;
        }
        
        /* Reset y base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--neutral-50);
            color: var(--neutral-800);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
        }
        
        /* Layout principal */
        .layout-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 24px;
            height: calc(100vh - 80px);
            padding: 24px;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Sidebar de bloques */
        .blocks-sidebar {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--neutral-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--neutral-200);
            background: linear-gradient(135deg, var(--primary-50) 0%, white 100%);
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        
        /* Área de construcción principal */
        .construction-area {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--neutral-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .construction-header {
            padding: 20px;
            border-bottom: 1px solid var(--neutral-200);
            background: white;
        }
        
        .construction-canvas {
            flex: 1;
            position: relative;
            background: var(--neutral-50);
            overflow: auto;
            min-height: 500px;
        }
        
        /* Canvas de construcción - estilo Tinkercad */
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
        
        /* Bloques draggable */
        .draggable-block {
            position: absolute;
            background: white;
            border-radius: 8px;
            border: 1px solid var(--neutral-300);
            box-shadow: var(--shadow-sm);
            cursor: grab;
            user-select: none;
            transition: all var(--transition-fast);
            z-index: var(--z-drop-area);
            min-width: 240px;
            max-width: 320px;
            transform-origin: center;
        }
        
        .draggable-block:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--primary-300);
        }
        
        .draggable-block.dragging {
            opacity: 0.9;
            cursor: grabbing;
            box-shadow: var(--shadow-2xl);
            transform: rotate(1deg) scale(1.02);
            z-index: var(--z-block-dragging);
        }
        
        .draggable-block.dropped {
            animation: dropAnimation 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        @keyframes dropAnimation {
            0% { transform: scale(0.95); opacity: 0.8; }
            70% { transform: scale(1.02); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .block-header {
            padding: 12px 16px;
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--primary-100) 100%);
            border-bottom: 1px solid var(--neutral-200);
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .block-content {
            padding: 16px;
        }
        
        .block-actions {
            padding: 12px 16px;
            border-top: 1px solid var(--neutral-200);
            display: flex;
            gap: 8px;
        }
        
        /* Categorías expandibles */
        .category-section {
            margin-bottom: 16px;
            border: 1px solid var(--neutral-200);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .category-header {
            padding: 12px 16px;
            background: var(--neutral-50);
            border-bottom: 1px solid var(--neutral-200);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
        }
        
        .category-header:hover {
            background: var(--neutral-100);
        }
        
        .category-content {
            padding: 8px;
            background: white;
            display: grid;
            gap: 8px;
        }
        
        /* Items de bloque en sidebar */
        .block-item-sidebar {
            padding: 12px;
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: 6px;
            cursor: grab;
            user-select: none;
            transition: all var(--transition-fast);
        }
        
        .block-item-sidebar:hover {
            border-color: var(--primary-300);
            background: var(--primary-50);
            transform: translateX(4px);
        }
        
        .block-item-sidebar:active {
            cursor: grabbing;
        }
        
        /* Secciones desplegables en canvas */
        .section-container {
            position: absolute;
            min-width: 300px;
            border: 2px solid var(--neutral-300);
            border-radius: 12px;
            background: white;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
        }
        
        .section-container:hover {
            border-color: var(--primary-400);
            box-shadow: var(--shadow-lg);
        }
        
        .section-header {
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-50) 0%, white 100%);
            border-bottom: 1px solid var(--neutral-200);
            border-radius: 12px 12px 0 0;
            cursor: move;
            user-select: none;
        }
        
        .section-content {
            padding: 16px;
            display: grid;
            gap: 12px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        /* Modificadores y campos dinámicos */
        .modifier-group {
            margin-top: 12px;
            padding: 12px;
            background: var(--neutral-50);
            border-radius: 6px;
            border: 1px solid var(--neutral-200);
        }
        
        .field-group {
            margin-bottom: 12px;
        }
        
        .field-label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--neutral-700);
        }
        
        .field-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--neutral-300);
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all var(--transition-fast);
        }
        
        .field-input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Resumen y totales */
        .summary-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid var(--neutral-200);
            box-shadow: var(--shadow-lg);
            padding: 20px;
            z-index: 100;
            transform: translateY(0);
            transition: transform var(--transition-normal);
        }
        
        .summary-panel.hidden {
            transform: translateY(100%);
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Botones y controles */
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-fast);
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-700) 0%, var(--primary-800) 100%);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-secondary {
            background: white;
            color: var(--neutral-700);
            border-color: var(--neutral-300);
        }
        
        .btn-secondary:hover {
            border-color: var(--neutral-400);
            background: var(--neutral-50);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
            color: white;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }
        
        /* Modal de configuración */
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
            z-index: var(--z-modal);
            padding: 20px;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-2xl);
            animation: modalEnter 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Toasts y notificaciones */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: var(--z-toast);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .toast {
            background: white;
            border-radius: 8px;
            padding: 12px 16px;
            border-left: 4px solid;
            box-shadow: var(--shadow-lg);
            min-width: 300px;
            animation: toastEnter 0.3s ease-out;
        }
        
        @keyframes toastEnter {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .toast-success {
            border-left-color: var(--success);
        }
        
        .toast-error {
            border-left-color: var(--error);
        }
        
        .toast-warning {
            border-left-color: var(--warning);
        }
        
        .toast-info {
            border-left-color: var(--info);
        }
        
        /* Utilidades */
        .draggable {
            cursor: move;
        }
        
        .resizable {
            resize: both;
            overflow: auto;
        }
        
        .selectable {
            user-select: none;
        }
        
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .layout-grid {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .blocks-sidebar {
                max-height: 300px;
            }
        }
        
        @media (max-width: 640px) {
            .layout-grid {
                padding: 12px;
            }
            
            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Estados de validación */
        .valid {
            border-color: var(--success);
        }
        
        .invalid {
            border-color: var(--error);
        }
        
        .required::after {
            content: " *";
            color: var(--error);
        }
        
        /* Indicador de carga */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }
        
        .loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--neutral-300);
            border-top-color: var(--primary-500);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Tooltips */
        .tooltip {
            position: relative;
        }
        
        .tooltip:hover::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 6px 12px;
            background: var(--neutral-900);
            color: white;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 8px;
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--neutral-100);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--neutral-400);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--neutral-500);
        }
    </style>
</head>

<body>
    <!-- Toasts Container -->
    <div class="toast-container"></div>
    
    <!-- Layout Principal -->
    <div class="layout-grid">
        
        <!-- Sidebar de Bloques -->
        <div class="blocks-sidebar">
            <div class="sidebar-header">
                <h2 class="text-lg font-semibold text-neutral-900">Componentes</h2>
                <p class="text-sm text-neutral-600 mt-1">Arrastra bloques al área de construcción</p>
            </div>
            
            <div class="sidebar-content">
                <!-- Categorías de Bloques -->
                <template x-for="category in categories" :key="category.id">
                    <div class="category-section">
                        <div 
                            class="category-header"
                            @click="toggleCategory(category.id)"
                        >
                            <span class="font-medium text-neutral-900" x-text="category.name"></span>
                            <svg 
                                class="w-4 h-4 text-neutral-500 transition-transform"
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
                                            <h4 class="font-medium text-neutral-900" x-text="block.name"></h4>
                                            <p class="text-xs text-neutral-600 mt-1 truncate" x-text="block.description"></p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-semibold text-primary-600" 
                                                 x-text="formatCurrency(calculateBlockPrice(block))"></div>
                                            <div class="text-xs text-neutral-500" x-text="block.default_hours + ' horas'"></div>
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
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-neutral-900">Cotización</h1>
                        <p class="text-sm text-neutral-600 mt-1" x-text="'Total: ' + formatCurrency(totalCost)"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button 
                            @click="undo()"
                            :disabled="historyIndex === 0"
                            class="btn btn-secondary"
                            :class="{ 'opacity-50 cursor-not-allowed': historyIndex === 0 }"
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
                            :class="{ 'opacity-50 cursor-not-allowed': historyIndex >= history.length - 1 }"
                            title="Rehacer (Ctrl+Y)"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
                            </svg>
                            Rehacer
                        </button>
                        <button @click="saveQuote()" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Guardar
                        </button>
                        <button @click="showSubmitModal = true" class="btn btn-primary">
                            Generar Cotización
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
                        :class="{ 'dragging': block.isDragging, 'dropped': block.isDropped }"
                        :style="{
                            left: block.x + 'px',
                            top: block.y + 'px',
                            zIndex: block.zIndex || 10
                        }"
                        :data-instance-id="block.instanceId"
                    >
                        <!-- Sección (categorías principales) -->
                        <template x-if="block.type === 'section'">
                            <div class="section-container">
                                <div 
                                    class="section-header draggable"
                                    @mousedown="startDrag($event, block, true)"
                                >
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-neutral-900" x-text="block.name"></h3>
                                        <div class="flex items-center gap-2">
                                            <button 
                                                @click="toggleSection(block.instanceId)"
                                                class="p-1 hover:bg-neutral-100 rounded"
                                            >
                                                <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path x-show="!block.collapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    <path x-show="block.collapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                            <button 
                                                @click="removeBlock(block.instanceId)"
                                                class="p-1 hover:bg-red-50 text-red-600 rounded"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="section-content" x-show="!block.collapsed">
                                    <!-- Bloques dentro de la sección -->
                                    <template x-for="nestedBlock in block.nestedBlocks" :key="nestedBlock.instanceId">
                                        <div 
                                            class="draggable-block nested"
                                            :class="{ 'dragging': nestedBlock.isDragging }"
                                            :data-instance-id="nestedBlock.instanceId"
                                        >
                                            <div class="block-header">
                                                <h4 class="font-medium text-neutral-900" x-text="nestedBlock.name"></h4>
                                                <button 
                                                    @click="removeNestedBlock(block.instanceId, nestedBlock.instanceId)"
                                                    class="p-1 hover:bg-red-50 text-red-600 rounded"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="block-content">
                                                <!-- Campos dinámicos según el tipo de bloque -->
                                                <template x-if="nestedBlock.type === 'course'">
                                                    <div class="space-y-3">
                                                        <div class="field-group">
                                                            <label class="field-label">Modalidad</label>
                                                            <select 
                                                                x-model="nestedBlock.modality"
                                                                @change="updateBlockPrice(nestedBlock)"
                                                                class="field-input"
                                                            >
                                                                <option value="online">En línea</option>
                                                                <option value="onsite">En instalaciones</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Número de participantes</label>
                                                            <input 
                                                                type="number" 
                                                                x-model="nestedBlock.participants"
                                                                min="10"
                                                                @change="updateBlockPrice(nestedBlock)"
                                                                class="field-input"
                                                            />
                                                            <p class="text-xs text-neutral-500 mt-1">Mínimo 10 participantes</p>
                                                        </div>
                                                        <div class="modifier-group">
                                                            <div class="flex items-center justify-between text-sm">
                                                                <span>Precio por participante:</span>
                                                                <span x-text="formatCurrency(nestedBlock.pricePerParticipant)"></span>
                                                            </div>
                                                            <div class="flex items-center justify-between text-sm mt-1">
                                                                <span>Recargo instalaciones:</span>
                                                                <span x-text="formatCurrency(nestedBlock.onsiteSurcharge)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                
                                                <template x-if="nestedBlock.type === 'software_module'">
                                                    <div class="space-y-3">
                                                        <div class="field-group">
                                                            <label class="field-label">Complejidad</label>
                                                            <select 
                                                                x-model="nestedBlock.complexity"
                                                                @change="updateBlockPrice(nestedBlock)"
                                                                class="field-input"
                                                            >
                                                                <option value="low">Baja</option>
                                                                <option value="medium">Media</option>
                                                                <option value="high">Alta</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Horas estimadas</label>
                                                            <input 
                                                                type="number" 
                                                                x-model="nestedBlock.estimatedHours"
                                                                min="1"
                                                                @change="updateBlockPrice(nestedBlock)"
                                                                class="field-input"
                                                            />
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">
                                                                <input 
                                                                    type="checkbox" 
                                                                    x-model="nestedBlock.requiresIntegration"
                                                                    @change="updateBlockPrice(nestedBlock)"
                                                                />
                                                                <span class="ml-2">Requiere integración API</span>
                                                            </label>
                                                        </div>
                                                        <div class="modifier-group">
                                                            <div class="space-y-1 text-sm">
                                                                <div class="flex items-center justify-between">
                                                                    <span>Horas base:</span>
                                                                    <span x-text="nestedBlock.baseHours"></span>
                                                                </div>
                                                                <div class="flex items-center justify-between">
                                                                    <span>Factor complejidad:</span>
                                                                    <span x-text="nestedBlock.complexityFactor"></span>
                                                                </div>
                                                                <div class="flex items-center justify-between">
                                                                    <span>Horas integración:</span>
                                                                    <span x-text="nestedBlock.integrationHours"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                
                                                <!-- Campos comunes -->
                                                <div class="mt-3">
                                                    <label class="field-label">Cantidad</label>
                                                    <input 
                                                        type="number" 
                                                        x-model="nestedBlock.quantity"
                                                        min="1"
                                                        @change="updateBlockPrice(nestedBlock)"
                                                        class="field-input"
                                                    />
                                                </div>
                                            </div>
                                            <div class="block-actions">
                                                <div class="text-sm font-semibold text-primary-600">
                                                    Total: <span x-text="formatCurrency(nestedBlock.totalPrice)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <!-- Área para soltar bloques dentro de la sección -->
                                    <div 
                                        class="border-2 border-dashed border-neutral-300 rounded-lg p-4 text-center text-neutral-500 hover:border-primary-400 hover:text-primary-600 transition-colors cursor-pointer"
                                        @dragover.prevent
                                        @drop.prevent="onSectionDrop($event, block.instanceId)"
                                    >
                                        <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <p class="text-sm">Suelta bloques aquí</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Bloques individuales (fuera de secciones) -->
                        <template x-if="block.type !== 'section'">
                            <div>
                                <div 
                                    class="block-header draggable"
                                    @mousedown="startDrag($event, block)"
                                >
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-neutral-900" x-text="block.name"></h3>
                                            <p class="text-xs text-neutral-600 mt-1" x-text="block.description"></p>
                                        </div>
                                        <button 
                                            @click="removeBlock(block.instanceId)"
                                            class="p-1 hover:bg-red-50 text-red-600 rounded"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="block-content">
                                    <!-- Campos específicos por tipo de bloque -->
                                    <template x-if="block.type === 'audit'">
                                        <div class="space-y-3">
                                            <div class="field-group">
                                                <label class="field-label">Alcance de auditoría</label>
                                                <select 
                                                    x-model="block.scope"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-input"
                                                >
                                                    <option value="basic">Básica</option>
                                                    <option value="standard">Estándar</option>
                                                    <option value="comprehensive">Integral</option>
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
                                            <div class="modifier-group">
                                                <div class="space-y-1 text-sm">
                                                    <div class="flex items-center justify-between">
                                                        <span>Tarifa base:</span>
                                                        <span x-text="formatCurrency(block.basePrice)"></span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <span>Factor alcance:</span>
                                                        <span x-text="block.scopeFactor"></span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <span>Costo por sistema:</span>
                                                        <span x-text="formatCurrency(block.costPerSystem)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <div class="block-actions">
                                    <div class="flex items-center justify-between w-full">
                                        <div class="text-sm font-semibold text-primary-600">
                                            Total: <span x-text="formatCurrency(block.totalPrice)"></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button 
                                                @click="duplicateBlock(block.instanceId)"
                                                class="text-xs text-neutral-600 hover:text-primary-600"
                                                title="Duplicar bloque"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                
                <!-- Indicador de ayuda cuando está vacío -->
                <div 
                    x-show="placedBlocks.length === 0"
                    class="absolute inset-0 flex flex-col items-center justify-center text-center p-8"
                >
                    <div class="w-24 h-24 rounded-full bg-primary-50 flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-900 mb-2">Comienza a construir tu cotización</h3>
                    <p class="text-neutral-600 max-w-md">
                        Arrastra bloques desde el panel izquierdo o comienza con una plantilla predefinida.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <button 
                            @click="loadTemplate('basic')"
                            class="btn btn-secondary"
                        >
                            Plantilla Básica
                        </button>
                        <button 
                            @click="loadTemplate('complete')"
                            class="btn btn-primary"
                        >
                            Plantilla Completa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Panel de Resumen (fijo en la parte inferior) -->
    <div class="summary-panel" :class="{ 'hidden': !showSummary }">
        <div class="summary-grid">
            <div>
                <div class="text-sm text-neutral-600">Total estimado</div>
                <div class="text-2xl font-bold text-neutral-900" x-text="formatCurrency(totalCost)"></div>
                <div class="text-sm text-neutral-500 mt-1" x-text="totalHours + ' horas estimadas'"></div>
            </div>
            <div>
                <div class="text-sm text-neutral-600">Desglose</div>
                <div class="flex items-center gap-4 mt-1">
                    <div>
                        <div class="text-xs text-neutral-500">Servicios</div>
                        <div class="font-medium" x-text="serviceCount"></div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500">Bloques</div>
                        <div class="font-medium" x-text="totalBlocks"></div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500">IVA (16%)</div>
                        <div class="font-medium" x-text="formatCurrency(totalTax)"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3">
                <button 
                    @click="exportPDF()"
                    class="btn btn-secondary"
                    :class="{ 'loading': isExportingPDF }"
                    :disabled="isExportingPDF"
                >
                    Exportar PDF
                </button>
                <button 
                    @click="showSubmitModal = true"
                    class="btn btn-primary"
                >
                    Enviar Cotización
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal de Envío -->
    <div 
        x-show="showSubmitModal"
        x-transition
        class="modal-overlay"
        @click.self="showSubmitModal = false"
    >
        <div class="modal-content">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-neutral-900 mb-4">Enviar Cotización</h2>
                
                <form @submit.prevent="submitQuote" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label required">Nombre completo</label>
                            <input 
                                type="text" 
                                x-model="clientForm.name"
                                required
                                class="field-input"
                                placeholder="Nombre del cliente o empresa"
                            />
                        </div>
                        <div>
                            <label class="field-label required">Email</label>
                            <input 
                                type="email" 
                                x-model="clientForm.email"
                                required
                                class="field-input"
                                placeholder="correo@empresa.com"
                            />
                        </div>
                    </div>
                    
                    <div>
                        <label class="field-label required">Empresa</label>
                        <input 
                            type="text" 
                            x-model="clientForm.company"
                            required
                            class="field-input"
                            placeholder="Nombre de la empresa"
                        />
                    </div>
                    
                    <div>
                        <label class="field-label required">Teléfono</label>
                        <input 
                            type="tel" 
                            x-model="clientForm.phone"
                            required
                            class="field-input"
                            placeholder="+52 123 456 7890"
                        />
                    </div>
                    
                    <div>
                        <label class="field-label">Descripción del proyecto</label>
                        <textarea 
                            x-model="clientForm.project_description"
                            rows="4"
                            class="field-input resize-none"
                            placeholder="Describe los objetivos y requerimientos específicos de tu proyecto..."
                        ></textarea>
                    </div>
                    
                    <div>
                        <label class="field-label">Requerimientos adicionales</label>
                        <textarea 
                            x-model="clientForm.additional_requirements"
                            rows="3"
                            class="field-input resize-none"
                            placeholder="Alguna consideración especial, fechas límite, etc."
                        ></textarea>
                    </div>
                    
                    <div class="pt-4 border-t border-neutral-200">
                        <h3 class="font-medium text-neutral-900 mb-3">Resumen de la cotización</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-600">Subtotal:</span>
                                <span x-text="formatCurrency(subtotal)"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-600">IVA (16%):</span>
                                <span x-text="formatCurrency(totalTax)"></span>
                            </div>
                            <div class="flex items-center justify-between font-medium text-lg pt-2 border-t border-neutral-200">
                                <span class="text-neutral-900">Total:</span>
                                <span class="text-primary-600" x-text="formatCurrency(totalCost)"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 pt-6">
                        <button 
                            type="button"
                            @click="showSubmitModal = false"
                            class="btn btn-secondary flex-1"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="btn btn-primary flex-1"
                            :class="{ 'loading': isSubmitting }"
                            :disabled="isSubmitting"
                        >
                            <span x-show="!isSubmitting">Enviar Cotización</span>
                            <span x-show="isSubmitting">Enviando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal de Confirmación de Envío Exitoso -->
    <div 
        x-show="showSuccessModal"
        x-transition
        class="modal-overlay"
    >
        <div class="modal-content">
            <div class="p-8 text-center">
                <div class="w-20 h-20 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-semibold text-neutral-900 mb-3">Cotización enviada exitosamente</h2>
                <p class="text-neutral-600 mb-6">
                    Hemos recibido tu solicitud. Te contactaremos en menos de 24 horas para discutir los detalles de tu proyecto.
                </p>
                
                <div class="space-y-4">
                    <div class="bg-neutral-50 rounded-lg p-4">
                        <div class="text-sm text-neutral-600">Número de referencia:</div>
                        <div class="font-mono font-semibold text-primary-600" x-text="quoteReference"></div>
                    </div>
                    
                    <div class="flex items-center justify-center gap-3">
                        <a 
                            :href="pdfDownloadUrl"
                            class="btn btn-secondary"
                        >
                            Descargar PDF
                        </a>
                        <a 
                            href="/"
                            class="btn btn-primary"
                        >
                            Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Alpine.js -->
    <script>
    function quoteBuilder() {
        return {
            // Estado inicial
            categories: [],
            blocks: [],
            placedBlocks: [],
            clientForm: {
                name: '',
                email: '',
                company: '',
                phone: '',
                project_description: '',
                additional_requirements: ''
            },
            history: [],
            historyIndex: -1,
            
            // UI State
            showSubmitModal: false,
            showSuccessModal: false,
            showSummary: true,
            isSubmitting: false,
            isExportingPDF: false,
            quoteReference: '',
            pdfDownloadUrl: '',
            
            // Estado temporal para drag & drop
            draggedBlock: null,
            dragOffset: { x: 0, y: 0 },
            
            // Propiedades computadas
            get totalBlocks() {
                return this.placedBlocks.reduce((total, block) => {
                    if (block.type === 'section') {
                        return total + block.nestedBlocks.length;
                    }
                    return total + 1;
                }, 0);
            },
            
            get serviceCount() {
                return this.placedBlocks.length;
            },
            
            get subtotal() {
                return this.placedBlocks.reduce((total, block) => {
                    if (block.type === 'section') {
                        return total + block.nestedBlocks.reduce((sub, nested) => sub + nested.totalPrice, 0);
                    }
                    return total + block.totalPrice;
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
                    if (block.type === 'section') {
                        return total + block.nestedBlocks.reduce((sub, nested) => sub + nested.estimatedHours, 0);
                    }
                    return total + (block.estimatedHours || 0);
                }, 0);
            },
            
            // Métodos de inicialización
            async init() {
                // Primero obtener el token CSRF
                await this.getCsrfToken();
                await this.loadBlocks();
                this.loadSavedState();
                
                // Inicializar interact.js después de que los elementos estén en el DOM
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.setupInteractJS();
                    }, 100);
                });
                
                this.setupKeyboardShortcuts();
                this.setupAutoSave();
                
                // Inicializar historial
                this.saveToHistory();
            },
            
            // Método para obtener token CSRF
            async getCsrfToken() {
                try {
                    // Primero intentar obtener de la meta tag
                    const tokenFromMeta = document.querySelector('meta[name="csrf-token"]')?.content;
                    
                    if (!tokenFromMeta) {
                        // Si no existe, hacer una solicitud para obtener la cookie CSRF
                        await fetch('/sanctum/csrf-cookie', {
                            method: 'GET',
                            credentials: 'include'
                        });
                    }
                } catch (error) {
                    console.warn('Error obteniendo token CSRF:', error);
                }
            },
            
            // Función helper para obtener el token CSRF
            getCsrfTokenFromMeta() {
                return document.querySelector('meta[name="csrf-token"]')?.content || '';
            },
            
            async loadBlocks() {
                try {
                    const response = await fetch('/api/quote-blocks', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include'
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    // Expandir todas las categorías por defecto
                    this.categories = (data.categories || []).map(cat => ({
                        ...cat,
                        expanded: true
                    }));
                    this.blocks = data.blocks || [];
                    
                    // Si no hay datos, cargar datos de ejemplo
                    if (this.categories.length === 0) {
                        this.loadSampleData();
                        this.showToast('Usando datos de ejemplo', 'info');
                    }
                } catch (error) {
                    console.error('Error loading blocks:', error);
                    // Cargar datos de ejemplo en caso de error
                    this.loadSampleData();
                    this.showToast('Error al cargar los bloques. Usando datos de ejemplo.', 'error');
                }
            },
            
            // Datos de ejemplo para desarrollo
            loadSampleData() {
                this.categories = [
                    { id: 'courses', name: 'Cursos y Capacitación', expanded: true },
                    { id: 'software', name: 'Desarrollo de Software', expanded: true },
                    { id: 'audits', name: 'Auditorías', expanded: true },
                    { id: 'maintenance', name: 'Mantenimiento', expanded: true },
                    { id: 'consulting', name: 'Consultoría', expanded: true },
                    { id: 'all', name: 'Todos los Bloques', expanded: true }
                ];
                
                this.blocks = [
                    {
                        id: 'course_basic',
                        name: 'Curso Básico',
                        description: 'Curso introductorio de 20 horas',
                        type: 'course',
                        category_id: 'courses',
                        default_hours: 20,
                        base_price: 10000
                    },
                    {
                        id: 'course_advanced',
                        name: 'Curso Avanzado',
                        description: 'Curso especializado de 40 horas',
                        type: 'course',
                        category_id: 'courses',
                        default_hours: 40,
                        base_price: 20000
                    },
                    {
                        id: 'software_module',
                        name: 'Módulo Software',
                        description: 'Desarrollo de módulo personalizado',
                        type: 'software_module',
                        category_id: 'software',
                        default_hours: 80,
                        base_price: 40000
                    },
                    {
                        id: 'security_audit',
                        name: 'Auditoría de Seguridad',
                        description: 'Evaluación completa de seguridad',
                        type: 'audit',
                        category_id: 'audits',
                        default_hours: 40,
                        base_price: 15000
                    },
                    {
                        id: 'monthly_maintenance',
                        name: 'Mantenimiento Mensual',
                        description: 'Soporte y mantenimiento mensual',
                        type: 'maintenance',
                        category_id: 'maintenance',
                        default_hours: 20,
                        base_price: 8000
                    },
                    {
                        id: 'consulting_hours',
                        name: 'Horas de Consultoría',
                        description: 'Paquete de horas de consultoría',
                        type: 'consulting',
                        category_id: 'consulting',
                        default_hours: 40,
                        base_price: 20000
                    },
                    {
                        id: 'section_template',
                        name: 'Sección',
                        description: 'Contenedor para agrupar bloques',
                        type: 'section',
                        category_id: 'all',
                        default_hours: 0,
                        base_price: 0
                    }
                ];
            },
            
            setupInteractJS() {
                // Esperar a que los elementos estén en el DOM
                this.$nextTick(() => {
                    setTimeout(() => {
                        // Configurar interact.js para bloques draggable
                        interact('.draggable-block')
                            .draggable({
                                inertia: true,
                                modifiers: [
                                    interact.modifiers.restrictRect({
                                        restriction: 'parent',
                                        endOnly: true
                                    })
                                ],
                                autoScroll: true,
                                listeners: {
                                    start: (event) => {
                                        const instanceId = event.target.getAttribute('data-instance-id');
                                        if (instanceId) {
                                            const block = this.getBlockByInstanceId(instanceId);
                                            if (block) {
                                                block.isDragging = true;
                                                block.zIndex = 1000;
                                            }
                                        }
                                    },
                                    move: (event) => {
                                        const instanceId = event.target.getAttribute('data-instance-id');
                                        if (instanceId) {
                                            const block = this.getBlockByInstanceId(instanceId);
                                            if (block) {
                                                block.x += event.dx;
                                                block.y += event.dy;
                                            }
                                        }
                                    },
                                    end: (event) => {
                                        const instanceId = event.target.getAttribute('data-instance-id');
                                        if (instanceId) {
                                            const block = this.getBlockByInstanceId(instanceId);
                                            if (block) {
                                                block.isDragging = false;
                                                block.zIndex = 10;
                                                block.isDropped = true;
                                                setTimeout(() => {
                                                    block.isDropped = false;
                                                }, 300);
                                                this.saveToHistory();
                                            }
                                        }
                                    }
                                }
                            });
                            
                        // Configurar resizable para secciones
                        interact('.section-container')
                            .resizable({
                                edges: { left: true, right: true, bottom: true, top: true },
                                modifiers: [
                                    interact.modifiers.restrictSize({
                                        min: { width: 300, height: 200 }
                                    })
                                ],
                                inertia: true,
                                listeners: {
                                    move: function (event) {
                                        const target = event.target;
                                        target.style.width = event.rect.width + 'px';
                                        target.style.height = event.rect.height + 'px';
                                    }
                                }
                            });
                    }, 200);
                });
            },
            
            setupKeyboardShortcuts() {
                document.addEventListener('keydown', (e) => {
                    // Ctrl+Z para deshacer
                    if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
                        e.preventDefault();
                        this.undo();
                    }
                    
                    // Ctrl+Y o Ctrl+Shift+Z para rehacer
                    if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) {
                        e.preventDefault();
                        this.redo();
                    }
                    
                    // Ctrl+S para guardar
                    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                        e.preventDefault();
                        this.saveQuote();
                    }
                    
                    // Escape para cerrar modales
                    if (e.key === 'Escape') {
                        this.showSubmitModal = false;
                        this.showSuccessModal = false;
                    }
                });
            },
            
            setupAutoSave() {
                // Auto-guardar cada 30 segundos
                setInterval(() => {
                    if (this.placedBlocks.length > 0) {
                        this.saveState();
                    }
                }, 30000);
                
                // Prevenir pérdida de datos al salir
                window.addEventListener('beforeunload', (e) => {
                    if (this.placedBlocks.length > 0) {
                        e.preventDefault();
                        e.returnValue = '';
                    }
                });
            },
            
            // Métodos de bloques
            getBlocksByCategory(categoryId) {
                if (categoryId === 'all') return this.blocks;
                return this.blocks.filter(block => block.category_id === categoryId);
            },
            
            toggleCategory(categoryId) {
                const category = this.categories.find(c => c.id === categoryId);
                if (category) {
                    category.expanded = !category.expanded;
                }
            },
            
            onDragStart(event, block) {
                event.dataTransfer.setData('application/json', JSON.stringify(block));
                event.dataTransfer.effectAllowed = 'copy';
                this.draggedBlock = block;
            },
            
            onDragEnd(event) {
                this.draggedBlock = null;
            },
            
            onCanvasDragOver(event) {
                event.preventDefault();
                event.dataTransfer.dropEffect = 'copy';
            },
            
            onCanvasDrop(event) {
                event.preventDefault();
                
                try {
                    const data = JSON.parse(event.dataTransfer.getData('application/json'));
                    const canvas = document.getElementById('construction-canvas');
                    const rect = canvas.getBoundingClientRect();
                    const x = event.clientX - rect.left - 120;
                    const y = event.clientY - rect.top - 60;
                    
                    this.addBlockToCanvas(data, x, y);
                } catch (error) {
                    console.error('Error dropping block:', error);
                    this.showToast('Error al colocar el bloque', 'error');
                }
            },
            
            onSectionDrop(event, sectionId) {
                event.preventDefault();
                
                try {
                    const data = JSON.parse(event.dataTransfer.getData('application/json'));
                    const section = this.getBlockByInstanceId(sectionId);
                    
                    if (section && section.type === 'section') {
                        this.addNestedBlock(sectionId, data);
                    }
                } catch (error) {
                    console.error('Error dropping block in section:', error);
                    this.showToast('Error al agregar bloque a la sección', 'error');
                }
            },
            
            addBlockToCanvas(blockData, x = 100, y = 100) {
                // Verificar si ya existe un bloque similar
                const existingBlock = this.findSimilarBlock(blockData);
                if (existingBlock) {
                    if (confirm('Ya existe un bloque similar. ¿Deseas duplicarlo?')) {
                        this.duplicateBlock(existingBlock.instanceId);
                    }
                    return;
                }
                
                const newBlock = {
                    ...this.createBlockInstance(blockData),
                    x: Math.max(0, x),
                    y: Math.max(0, y),
                    zIndex: 10
                };
                
                this.placedBlocks.push(newBlock);
                this.saveToHistory();
                this.showToast(`Bloque "${blockData.name}" agregado`, 'success');
            },
            
            createBlockInstance(blockData) {
                const instanceId = 'block_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                
                const baseInstance = {
                    instanceId,
                    id: blockData.id,
                    name: blockData.name,
                    description: blockData.description,
                    type: blockData.type,
                    category_id: blockData.category_id,
                    isDragging: false,
                    isDropped: false
                };
                
                // Configurar según el tipo de bloque
                switch (blockData.type) {
                    case 'course':
                        return {
                            ...baseInstance,
                            modality: 'online',
                            participants: 10,
                            pricePerParticipant: 500,
                            onsiteSurcharge: 2000,
                            quantity: 1,
                            get totalPrice() {
                                let price = this.pricePerParticipant * this.participants;
                                if (this.modality === 'onsite') {
                                    price += this.onsiteSurcharge;
                                }
                                return price * this.quantity;
                            },
                            get estimatedHours() {
                                return blockData.default_hours || 20;
                            }
                        };
                        
                    case 'software_module':
                        return {
                            ...baseInstance,
                            complexity: 'medium',
                            requiresIntegration: false,
                            quantity: 1,
                            get baseHours() {
                                return blockData.default_hours || 40;
                            },
                            get complexityFactor() {
                                const factors = { low: 0.8, medium: 1, high: 1.5 };
                                return factors[this.complexity] || 1;
                            },
                            get integrationHours() {
                                return this.requiresIntegration ? 20 : 0;
                            },
                            get estimatedHours() {
                                return (this.baseHours * this.complexityFactor) + this.integrationHours;
                            },
                            get totalPrice() {
                                return (this.estimatedHours * 500) * this.quantity;
                            }
                        };
                        
                    case 'audit':
                        return {
                            ...baseInstance,
                            scope: 'standard',
                            systems: 1,
                            quantity: 1,
                            get basePrice() {
                                return blockData.base_price || 5000;
                            },
                            get scopeFactor() {
                                const factors = { basic: 0.7, standard: 1, comprehensive: 1.5 };
                                return factors[this.scope] || 1;
                            },
                            get costPerSystem() {
                                return 1000;
                            },
                            get estimatedHours() {
                                return blockData.default_hours || 40;
                            },
                            get totalPrice() {
                                return (this.basePrice * this.scopeFactor + (this.systems * this.costPerSystem)) * this.quantity;
                            }
                        };
                        
                    case 'section':
                        return {
                            ...baseInstance,
                            collapsed: false,
                            nestedBlocks: [],
                            get totalPrice() {
                                return this.nestedBlocks.reduce((sum, block) => sum + (block.totalPrice || 0), 0);
                            },
                            get estimatedHours() {
                                return this.nestedBlocks.reduce((sum, block) => sum + (block.estimatedHours || 0), 0);
                            }
                        };
                        
                    default:
                        return {
                            ...baseInstance,
                            quantity: 1,
                            get totalPrice() {
                                return (blockData.base_price || 0) * this.quantity;
                            },
                            get estimatedHours() {
                                return blockData.default_hours || 0;
                            }
                        };
                }
            },
            
            findSimilarBlock(blockData) {
                return this.placedBlocks.find(block => 
                    block.type === blockData.type && 
                    block.name === blockData.name
                );
            },
            
            getBlockByInstanceId(instanceId) {
                if (!instanceId) return null;
                
                // Buscar en bloques principales
                let block = this.placedBlocks.find(b => b.instanceId === instanceId);
                if (block) return block;
                
                // Buscar en bloques anidados dentro de secciones
                for (const section of this.placedBlocks) {
                    if (section.type === 'section' && section.nestedBlocks) {
                        const nestedBlock = section.nestedBlocks.find(b => b.instanceId === instanceId);
                        if (nestedBlock) return nestedBlock;
                    }
                }
                
                return null;
            },
            
            addNestedBlock(sectionId, blockData) {
                const section = this.getBlockByInstanceId(sectionId);
                if (section && section.type === 'section') {
                    const newBlock = this.createBlockInstance(blockData);
                    section.nestedBlocks.push(newBlock);
                    this.saveToHistory();
                    this.showToast(`Bloque agregado a "${section.name}"`, 'success');
                }
            },
            
            removeBlock(instanceId) {
                if (confirm('¿Estás seguro de eliminar este bloque?')) {
                    this.placedBlocks = this.placedBlocks.filter(block => block.instanceId !== instanceId);
                    this.saveToHistory();
                    this.showToast('Bloque eliminado', 'success');
                }
            },
            
            removeNestedBlock(sectionId, nestedBlockId) {
                const section = this.getBlockByInstanceId(sectionId);
                if (section && section.type === 'section') {
                    if (confirm('¿Estás seguro de eliminar este bloque?')) {
                        section.nestedBlocks = section.nestedBlocks.filter(b => b.instanceId !== nestedBlockId);
                        this.saveToHistory();
                        this.showToast('Bloque eliminado', 'success');
                    }
                }
            },
            
            duplicateBlock(instanceId) {
                const original = this.getBlockByInstanceId(instanceId);
                if (original) {
                    const duplicated = {
                        ...JSON.parse(JSON.stringify(original)),
                        instanceId: 'block_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                        x: (original.x || 0) + 20,
                        y: (original.y || 0) + 20
                    };
                    
                    // Si es un bloque anidado, encontrar la sección
                    const isNested = this.placedBlocks.some(section => 
                        section.type === 'section' && 
                        section.nestedBlocks?.some(b => b.instanceId === instanceId)
                    );
                    
                    if (isNested) {
                        const section = this.placedBlocks.find(s => 
                            s.nestedBlocks?.some(b => b.instanceId === instanceId)
                        );
                        if (section) {
                            section.nestedBlocks.push(duplicated);
                        }
                    } else {
                        this.placedBlocks.push(duplicated);
                    }
                    
                    this.saveToHistory();
                    this.showToast('Bloque duplicado', 'success');
                }
            },
            
            toggleSection(sectionId) {
                const section = this.getBlockByInstanceId(sectionId);
                if (section && section.type === 'section') {
                    section.collapsed = !section.collapsed;
                }
            },
            
            updateBlockPrice(block) {
                // Forzar actualización de la UI
                this.$nextTick(() => {
                    // Esto actualizará los getters computados
                });
            },
            
            // Métodos de historial (undo/redo)
            saveToHistory() {
                // Crear una copia profunda sin getters
                const state = {
                    placedBlocks: JSON.parse(JSON.stringify(this.placedBlocks)),
                    clientForm: { ...this.clientForm }
                };
                
                const stateString = JSON.stringify(state);
                
                // Eliminar estados futuros si hemos hecho undo
                this.history = this.history.slice(0, this.historyIndex + 1);
                this.history.push(stateString);
                this.historyIndex = this.history.length - 1;
                
                // Limitar historial a 50 estados
                if (this.history.length > 50) {
                    this.history.shift();
                    this.historyIndex--;
                }
            },
            
            undo() {
                if (this.historyIndex > 0) {
                    this.historyIndex--;
                    this.restoreState(this.history[this.historyIndex]);
                }
            },
            
            redo() {
                if (this.historyIndex < this.history.length - 1) {
                    this.historyIndex++;
                    this.restoreState(this.history[this.historyIndex]);
                }
            },
            
            restoreState(stateString) {
                try {
                    const state = JSON.parse(stateString);
                    
                    // Limpiar bloques actuales
                    this.placedBlocks = [];
                    
                    // Recrear cada bloque con su instancia apropiada
                    if (state.placedBlocks && Array.isArray(state.placedBlocks)) {
                        state.placedBlocks.forEach(savedBlock => {
                            // Buscar el bloque base en la lista de bloques disponibles
                            const blockData = this.blocks.find(b => b.id === savedBlock.id);
                            if (blockData) {
                                const newInstance = this.createBlockInstance(blockData);
                                
                                // Copiar propiedades específicas de la instancia
                                Object.keys(savedBlock).forEach(key => {
                                    if (!['instanceId', 'totalPrice', 'baseHours', 'complexityFactor', 'integrationHours', 'estimatedHours'].includes(key)) {
                                        newInstance[key] = savedBlock[key];
                                    }
                                });
                                
                                // Mantener la posición y estado
                                newInstance.x = savedBlock.x || 0;
                                newInstance.y = savedBlock.y || 0;
                                newInstance.zIndex = savedBlock.zIndex || 10;
                                
                                // Para secciones, recrear bloques anidados
                                if (savedBlock.type === 'section' && savedBlock.nestedBlocks) {
                                    newInstance.nestedBlocks = [];
                                    savedBlock.nestedBlocks.forEach(nested => {
                                        const nestedBlockData = this.blocks.find(b => b.id === nested.id);
                                        if (nestedBlockData) {
                                            const nestedInstance = this.createBlockInstance(nestedBlockData);
                                            Object.keys(nested).forEach(key => {
                                                if (!['instanceId', 'totalPrice', 'baseHours', 'complexityFactor', 'integrationHours', 'estimatedHours'].includes(key)) {
                                                    nestedInstance[key] = nested[key];
                                                }
                                            });
                                            newInstance.nestedBlocks.push(nestedInstance);
                                        }
                                    });
                                }
                                
                                this.placedBlocks.push(newInstance);
                            }
                        });
                    }
                    
                    this.clientForm = state.clientForm || this.clientForm;
                } catch (error) {
                    console.error('Error restoring state:', error);
                    this.showToast('Error al restaurar el estado', 'error');
                }
            },
            
            // Métodos de plantillas
            loadTemplate(templateName) {
                const templates = {
                    basic: () => {
                        this.placedBlocks = [];
                        // Agregar secciones básicas
                        const sections = [
                            { name: 'Cursos Personalizados', type: 'section', category: 'courses', id: 'section_courses' },
                            { name: 'Desarrollo de Software', type: 'section', category: 'software', id: 'section_software' }
                        ];
                        
                        sections.forEach((section, index) => {
                            const sectionBlock = this.createBlockInstance({
                                ...section,
                                name: section.name,
                                type: 'section',
                                description: 'Agrega bloques aquí',
                                category_id: section.category
                            });
                            sectionBlock.x = 100 + (index * 350);
                            sectionBlock.y = 100;
                            this.placedBlocks.push(sectionBlock);
                        });
                    },
                    complete: () => {
                        this.placedBlocks = [];
                        // Plantilla completa con todas las secciones
                        const sections = [
                            { name: 'Cursos Personalizados', type: 'section', category: 'courses', id: 'section_courses' },
                            { name: 'Auditorías', type: 'section', category: 'audits', id: 'section_audits' },
                            { name: 'Mantenimiento', type: 'section', category: 'maintenance', id: 'section_maintenance' },
                            { name: 'Desarrollo de Software', type: 'section', category: 'software', id: 'section_software' }
                        ];
                        
                        sections.forEach((section, index) => {
                            const sectionBlock = this.createBlockInstance({
                                ...section,
                                name: section.name,
                                type: 'section',
                                description: 'Agrega bloques aquí',
                                category_id: section.category
                            });
                            sectionBlock.x = 100 + (index * 320);
                            sectionBlock.y = 100;
                            this.placedBlocks.push(sectionBlock);
                        });
                    }
                };
                
                if (templates[templateName]) {
                    templates[templateName]();
                    this.saveToHistory();
                    this.showToast(`Plantilla "${templateName}" cargada`, 'success');
                }
            },
            
            // Métodos de persistencia
            saveState() {
                const state = {
                    placedBlocks: JSON.parse(JSON.stringify(this.placedBlocks)),
                    clientForm: { ...this.clientForm },
                    timestamp: Date.now()
                };
                
                localStorage.setItem('quoteBuilderState', JSON.stringify(state));
            },
            
            loadSavedState() {
                try {
                    const saved = localStorage.getItem('quoteBuilderState');
                    if (saved) {
                        const state = JSON.parse(saved);
                        this.restoreState(JSON.stringify({
                            placedBlocks: state.placedBlocks || [],
                            clientForm: state.clientForm || this.clientForm
                        }));
                        this.showToast('Estado recuperado de la última sesión', 'info');
                    }
                } catch (error) {
                    console.error('Error loading saved state:', error);
                }
            },
            
            // Métodos de exportación y envío - CORREGIDOS PARA CSRF
            async saveQuote() {
                try {
                    const quoteData = this.prepareQuoteData();
                    const csrfToken = this.getCsrfTokenFromMeta();
                    
                    const response = await fetch('/api/quotes/save-draft', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include',
                        body: JSON.stringify(quoteData)
                    });
                    
                    if (response.ok) {
                        const result = await response.json();
                        this.showToast('Cotización guardada exitosamente', 'success');
                        return result;
                    } else if (response.status === 419) {
                        // Token CSRF expirado, refrescar la página
                        this.showToast('Sesión expirada. Por favor, recarga la página.', 'error');
                        return null;
                    } else {
                        const errorText = await response.text();
                        throw new Error(`Error ${response.status}: ${errorText}`);
                    }
                } catch (error) {
                    console.error('Error saving quote:', error);
                    this.showToast('Error al guardar la cotización: ' + error.message, 'error');
                    return null;
                }
            },
            
            async exportPDF() {
                this.isExportingPDF = true;
                
                try {
                    const quoteData = this.prepareQuoteData();
                    const csrfToken = this.getCsrfTokenFromMeta();
                    
                    const response = await fetch('/api/quotes/generate-pdf', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/pdf',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include',
                        body: JSON.stringify(quoteData)
                    });
                    
                    if (response.ok) {
                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `cotizacion-${Date.now()}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                        
                        this.showToast('PDF generado exitosamente', 'success');
                    } else if (response.status === 419) {
                        this.showToast('Sesión expirada. Por favor, recarga la página.', 'error');
                    } else {
                        const errorText = await response.text();
                        throw new Error(`Error ${response.status}: ${errorText}`);
                    }
                } catch (error) {
                    console.error('Error exporting PDF:', error);
                    this.showToast('Error al generar el PDF: ' + error.message, 'error');
                } finally {
                    this.isExportingPDF = false;
                }
            },
            
            async submitQuote() {
                this.isSubmitting = true;
                
                try {
                    const quoteData = this.prepareQuoteData();
                    const csrfToken = this.getCsrfTokenFromMeta();
                    
                    const response = await fetch('/api/quotes/submit', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include',
                        body: JSON.stringify(quoteData)
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        
                        if (data.success) {
                            this.quoteReference = data.reference || `COT-${Date.now()}`;
                            this.pdfDownloadUrl = data.pdf_url || '#';
                            this.showSubmitModal = false;
                            this.showSuccessModal = true;
                            
                            // Limpiar estado después del envío exitoso
                            localStorage.removeItem('quoteBuilderState');
                            this.placedBlocks = [];
                            this.clientForm = {
                                name: '',
                                email: '',
                                company: '',
                                phone: '',
                                project_description: '',
                                additional_requirements: ''
                            };
                            this.history = [];
                            this.historyIndex = -1;
                            
                            this.showToast('Cotización enviada exitosamente', 'success');
                        } else {
                            throw new Error(data.message || 'Error al enviar la cotización');
                        }
                    } else if (response.status === 419) {
                        this.showToast('Sesión expirada. Por favor, recarga la página.', 'error');
                    } else {
                        const errorText = await response.text();
                        throw new Error(`Error ${response.status}: ${errorText}`);
                    }
                } catch (error) {
                    console.error('Error submitting quote:', error);
                    this.showToast('Error al enviar la cotización: ' + error.message, 'error');
                } finally {
                    this.isSubmitting = false;
                }
            },
            
            prepareQuoteData() {
                return {
                    client: this.clientForm,
                    blocks: this.placedBlocks.map(block => {
                        if (block.type === 'section') {
                            return {
                                type: 'section',
                                name: block.name,
                                description: block.description,
                                nestedBlocks: block.nestedBlocks.map(nested => ({
                                    id: nested.id,
                                    name: nested.name,
                                    type: nested.type,
                                    description: nested.description,
                                    quantity: nested.quantity || 1,
                                    modality: nested.modality,
                                    participants: nested.participants,
                                    complexity: nested.complexity,
                                    scope: nested.scope,
                                    systems: nested.systems,
                                    requiresIntegration: nested.requiresIntegration,
                                    totalPrice: nested.totalPrice,
                                    estimatedHours: nested.estimatedHours
                                }))
                            };
                        }
                        return {
                            id: block.id,
                            name: block.name,
                            type: block.type,
                            description: block.description,
                            quantity: block.quantity || 1,
                            modality: block.modality,
                            participants: block.participants,
                            complexity: block.complexity,
                            scope: block.scope,
                            systems: block.systems,
                            requiresIntegration: block.requiresIntegration,
                            totalPrice: block.totalPrice,
                            estimatedHours: block.estimatedHours
                        };
                    }),
                    summary: {
                        subtotal: this.subtotal,
                        tax: this.totalTax,
                        total: this.totalCost,
                        hours: this.totalHours,
                        blocks: this.totalBlocks
                    },
                    metadata: {
                        created_at: new Date().toISOString(),
                        version: '1.0'
                    }
                };
            },
            
            // Métodos de utilidad
            formatCurrency(amount) {
                return new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: 'MXN',
                    minimumFractionDigits: 2
                }).format(amount || 0);
            },
            
            showToast(message, type = 'info') {
                const container = document.querySelector('.toast-container');
                if (!container) {
                    console.warn('Toast container no encontrado');
                    return;
                }
                
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                toast.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${this.getToastIcon(type)}
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-neutral-900">${message}</p>
                        </div>
                        <button class="ml-4 flex-shrink-0" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                
                container.appendChild(toast);
                
                // Auto-remover después de 5 segundos
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(100%)';
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000);
            },
            
            getToastIcon(type) {
                const icons = {
                    success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
                    error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />',
                    warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />',
                    info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                };
                return icons[type] || icons.info;
            },
            
            calculateBlockPrice(block) {
                if (!block) return 0;
                
                switch (block.type) {
                    case 'course':
                        return block.base_price || 10000;
                    case 'software_module':
                        return block.base_price || 40000;
                    case 'audit':
                        return block.base_price || 15000;
                    case 'maintenance':
                        return block.base_price || 8000;
                    case 'consulting':
                        return block.base_price || 20000;
                    default:
                        return block.base_price || 0;
                }
            },
            
            // Método para limpiar todo
            clearAll() {
                if (confirm('¿Estás seguro de querer limpiar todo el canvas? Se perderán todos los bloques.')) {
                    this.placedBlocks = [];
                    this.history = [];
                    this.historyIndex = -1;
                    this.saveToHistory();
                    this.showToast('Canvas limpiado', 'success');
                }
            }
        }
    }
</script>
</body>
</html>