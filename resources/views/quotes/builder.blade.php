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
    
    <!-- jsPDF para generar PDFs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <style>
        /* ===== VARIABLES OPTIMIZADAS ===== */
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

        /* ===== RESET OPTIMIZADO ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 14px;
        }

        body {
            font-family: var(--font-body);
            background: var(--off-white);
            color: var(--gray-800);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== NAVBAR MEJORADA ===== */
        .navbar-meliora {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0.75rem 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--gray-900);
            flex-shrink: 0;
        }

        .navbar-logo img {
            height: 2.5rem;
            width: auto;
        }

        .nav-button {
            padding: 0.5rem 1.25rem;
            background: var(--accent);
            color: white;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all var(--transition-fast);
            border: 1px solid var(--accent);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .nav-button:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* ===== LAYOUT OPTIMIZADO ===== */
        .main-container {
            margin-top: 70px;
            padding: 1.5rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            min-height: calc(100vh - 70px);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 1.5rem;
            height: calc(100vh - 120px);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== SIDEBAR COMPACTO ===== */
        .blocks-sidebar {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            flex-shrink: 0;
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            scrollbar-width: thin;
            scrollbar-color: var(--gray-300) transparent;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background-color: var(--gray-300);
            border-radius: 3px;
        }

        .category-section {
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            overflow: hidden;
            background: white;
        }
        
        .category-header {
            padding: 0.75rem 1rem;
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
            transition: background var(--transition-fast);
        }
        
        .category-header:hover {
            background: var(--gray-100);
        }
        
        .category-content {
            padding: 0.75rem;
            background: white;
            display: grid;
            gap: 0.5rem;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .block-item-sidebar {
            padding: 0.75rem;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            cursor: grab;
            user-select: none;
            transition: all var(--transition-fast);
        }
        
        .block-item-sidebar:hover {
            border-color: var(--accent);
            background: var(--gray-50);
            transform: translateX(2px);
        }
        
        .block-item-sidebar:active {
            cursor: grabbing;
        }

        /* ===== CANVAS Y BLOQUES ===== */
        .construction-area {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .construction-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
            flex-wrap: wrap;
            gap: 1rem;
            flex-shrink: 0;
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
            gap: 0.375rem;
            background: var(--gray-100);
            padding: 0.375rem;
            border-radius: var(--radius-md);
        }

        .zoom-btn {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            background: var(--white);
            border: 1px solid var(--gray-300);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
            color: var(--gray-700);
            font-size: 0.75rem;
        }

        .zoom-btn:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .zoom-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .zoom-level {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--gray-700);
            min-width: 2.5rem;
            text-align: center;
        }

        .canvas-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            font-size: 0.8125rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            outline: none;
            white-space: nowrap;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
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

        /* ===== ÁREA DEL CANVAS CON ZOOM EN LOS BLOQUES ===== */
        .construction-canvas {
            flex: 1;
            position: relative;
            background: var(--gray-50);
            overflow: auto;
            min-height: 400px;
        }

        .construction-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 2000px;
            height: 2000px;
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            background-position: -1px -1px;
            pointer-events: none;
            z-index: 1;
            transform-origin: 0 0;
            transform: scale(var(--zoom-level, 1));
        }

        /* ===== CONTENEDOR DE BLOQUES CON ZOOM ===== */
        .blocks-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 2000px;
            height: 2000px;
            transform-origin: 0 0;
            pointer-events: none;
        }

        .blocks-container * {
            pointer-events: auto;
        }

        /* ===== BLOQUES DRAGGABLE MEJORADOS ===== */
        .draggable-block {
            position: absolute;
            background: white;
            border-radius: var(--radius-md);
            border: 1px solid var(--gray-300);
            box-shadow: var(--shadow-sm);
            cursor: move;
            user-select: none;
            transition: all var(--transition-fast);
            z-index: 10;
            width: 260px;
            min-height: 120px;
            touch-action: none;
            transform-origin: 0 0;
            transform: scale(var(--zoom-level, 1));
        }
        
        .draggable-block:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--accent);
        }
        
        .draggable-block.dragging {
            opacity: 0.95;
            cursor: grabbing;
            box-shadow: var(--shadow-xl);
            z-index: 100;
        }
        
        .block-header {
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            border-bottom: 1px solid var(--gray-200);
            border-radius: var(--radius-md) var(--radius-md) 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: move;
            flex-shrink: 0;
        }
        
        .block-content {
            padding: 1rem;
            overflow-y: auto;
            max-height: 300px;
        }
        
        .block-actions {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        /* ===== CAMPOS DE FORMULARIO OPTIMIZADOS ===== */
        .field-group {
            margin-bottom: 0.75rem;
        }

        .field-label {
            display: block;
            margin-bottom: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .field-input, .field-select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-size: 0.8125rem;
            transition: all var(--transition-fast);
            background: white;
            line-height: 1.4;
        }

        .field-input:focus, .field-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
        }

        .price-breakdown {
            margin-top: 0.75rem;
            padding: 0.75rem;
            background: var(--gray-50);
            border-radius: var(--radius-sm);
            border: 1px solid var(--gray-200);
            font-size: 0.75rem;
        }

        .breakdown-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }

        .breakdown-row.total {
            font-weight: 600;
            border-top: 1px solid var(--gray-300);
            padding-top: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.8125rem;
        }

        /* ===== PANEL INFERIOR COMPACTO ===== */
        .summary-panel {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            box-shadow: var(--shadow-xl);
            padding: 1rem 1.5rem;
            z-index: 900;
            backdrop-filter: blur(8px);
        }

        .summary-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 2rem;
            align-items: center;
        }

        .summary-total {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
            min-width: 160px;
        }

        .summary-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
        }

        .summary-breakdown {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
            text-align: center;
        }

        .summary-item-label {
            font-size: 0.6875rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .summary-item-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .summary-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            min-width: 250px;
        }

        /* ===== MODALES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 1rem;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                backdrop-filter: blur(0);
            }
            to {
                opacity: 1;
                backdrop-filter: blur(8px);
            }
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--radius-xl);
            width: 100%;
            max-width: 500px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: var(--shadow-2xl);
            animation: modalSlideIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .modal-close {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gray-100);
            color: var(--gray-600);
            cursor: pointer;
            transition: all var(--transition-fast);
            border: none;
            padding: 0;
            flex-shrink: 0;
        }

        .modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .modal-body {
            padding: 1.5rem;
        }

        /* ===== TUTORIAL MODAL ===== */
        .tutorial-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5000;
            animation: fadeIn 0.3s ease-out;
        }

        .tutorial-container {
            max-width: 640px;
            width: 90%;
            border-radius: 1rem;
            background: white;
            padding: 2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
            animation: tutorialPop 0.45s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
        }

        @keyframes tutorialPop {
            0% { transform: scale(0.85); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* ===== Steps ===== */
        .tutorial-steps {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .tutorial-step {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: 0.2s;
        }

        .tutorial-step:hover {
            transform: translateX(4px);
        }

        .step-number {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .step-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.4rem;
        }

        .step-description {
            font-size: 0.9rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .tutorial-video-container {
            width: 100%;
            margin-bottom: 1.5rem;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: var(--gray-100);
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tutorial-video-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
            color: var(--gray-600);
        }

        /* ===== TOASTS ===== */
        .toast-container {
            position: fixed;
            top: 5rem;
            right: 1rem;
            z-index: 2500;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            max-width: 320px;
        }

        .toast {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            border-left: 4px solid;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            animation: toastSlideIn 0.3s ease-out forwards;
            transform: translateX(100%);
            font-size: 0.8125rem;
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
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 260px 1fr;
                gap: 1rem;
            }
            
            .summary-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: center;
            }
            
            .summary-actions {
                justify-content: center;
            }
        }

        @media (max-width: 992px) {
            html {
                font-size: 13px;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
                height: auto;
                min-height: calc(100vh - 120px);
            }
            
            .blocks-sidebar {
                max-height: 280px;
                order: 2;
            }
            
            .construction-area {
                order: 1;
                min-height: 500px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
                margin-top: 60px;
            }
            
            .navbar-container {
                padding: 0 1rem;
            }
            
            .navbar-logo span {
                display: none;
            }
            
            .construction-header {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }
            
            .canvas-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }
            
            .canvas-actions {
                justify-content: center;
            }
            
            .zoom-controls {
                justify-content: center;
            }
            
            .draggable-block {
                width: 240px;
            }
        }

        @media (max-width: 576px) {
            html {
                font-size: 12px;
            }
            
            .dashboard-grid {
                gap: 0.75rem;
            }
            
            .blocks-sidebar {
                max-height: 250px;
            }
            
            .construction-header {
                padding: 0.75rem 1rem;
            }
            
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
            
            .canvas-actions {
                justify-content: space-between;
            }
            
            .summary-panel {
                padding: 0.75rem 1rem;
            }
            
            .summary-actions {
                flex-direction: column;
                gap: 0.5rem;
                min-width: auto;
            }
        }

        /* ===== UTILIDADES ===== */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .flex-1 {
            flex: 1;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar-meliora">
        <div class="navbar-container">
            <a href="/" class="navbar-logo">
                <img src="/images/DMI-logob.png" alt="DMI Logo">
                <span>Cotizador DMI</span>
            </a>
            <a href="/" class="nav-button">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Inicio
            </a>
        </div>
    </nav>

    <!-- Toasts Container -->
    <div class="toast-container"></div>

    <!-- Modal de Tutorial -->
    <div 
        x-data="{ openTutorial: true }"
        x-show="openTutorial"
        x-transition.opacity
        class="tutorial-modal-backdrop"
    >
        <div class="tutorial-container">
            <!-- Cerrar -->
            <button 
                @click="openTutorial = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 transition p-2"
                aria-label="Cerrar tutorial"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Título -->
            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-4">
                ¿Cómo usar el Cotizador?
            </h2>

            <!-- Video/GIF Placeholder -->
            <div class="tutorial-video-container">
                <div class="tutorial-video-placeholder">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">Demostración del Cotizador DMI</span>
                </div>
            </div>

            <!-- Steps -->
            <div class="tutorial-steps">
                <div class="tutorial-step">
                    <div class="step-number">1</div>
                    <div>
                        <div class="step-title">Arrastra los bloques</div>
                        <p class="step-description">
                            Desde las categorías de la izquierda selecciona los bloques que necesites y suéltalos sobre la pizarra.
                        </p>
                    </div>
                </div>

                <div class="tutorial-step">
                    <div class="step-number">2</div>
                    <div>
                        <div class="step-title">Organiza y conecta</div>
                        <p class="step-description">
                            Puedes moverlos, alinearlos y visualizar cómo se conectan entre sí con enlaces suaves.
                        </p>
                    </div>
                </div>

                <div class="tutorial-step">
                    <div class="step-number">3</div>
                    <div>
                        <div class="step-title">Genera o envía tu cotización</div>
                        <p class="step-description">
                            Guarda, exporta a PDF o envía directamente al cliente cuando estés listo.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Botón continuar -->
            <div class="text-center mt-6">
                <button 
                    @click="openTutorial = false"
                    class="px-5 py-2.5 rounded-lg bg-[var(--accent)] text-white font-medium shadow hover:shadow-md transition"
                >
                    Entendido, ¡comenzar!
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="dashboard-grid">
            <!-- Sidebar de Bloques -->
            <div class="blocks-sidebar">
                <div class="sidebar-header">
                    <h2 class="text-base font-semibold text-gray-900">Servicios</h2>
                    <p class="text-xs text-gray-600 mt-0.5">Arrastra al área de trabajo</p>
                </div>
                
                <div class="sidebar-content">
                    <template x-for="category in categories" :key="category.id">
                        <div class="category-section">
                            <div 
                                class="category-header"
                                @click="toggleCategory(category.id)"
                            >
                                <span class="font-medium text-gray-900 text-sm" x-text="category.name"></span>
                                <svg 
                                    class="w-3 h-3 text-gray-500 transition-transform"
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
                                        class="block-item-sidebar"
                                        :data-block-id="block.id"
                                        draggable="true"
                                        @dragstart="onDragStart($event, block)"
                                        @dragend="onDragEnd($event)"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-medium text-gray-900 text-sm truncate" x-text="block.name"></h4>
                                                <p class="text-xs text-gray-600 mt-0.5 truncate" x-text="block.description"></p>
                                            </div>
                                            <div class="text-right pl-2 flex-shrink-0">
                                                <div class="text-xs font-semibold text-accent" 
                                                     x-text="formatCurrency(block.base_price)"></div>
                                                <div class="text-xs text-gray-500" x-text="block.default_hours + 'h'"></div>
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
                    <div class="min-w-0">
                        <h1 class="text-lg font-semibold text-gray-900 truncate">Cotizador DMI</h1>
                        <p class="text-xs text-gray-600 mt-0.5 truncate" 
                           x-text="'Total: ' + formatCurrency(totalCost) + ' • ' + placedBlocks.length + ' servicios'"></p>
                    </div>
                    
                    <div class="canvas-controls">
                        <div class="zoom-controls">
                            <button 
                                class="zoom-btn" 
                                @click="zoomOut"
                                :disabled="zoom <= 0.5"
                                title="Alejar"
                                aria-label="Alejar"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <span class="zoom-level" x-text="Math.round(zoom * 100) + '%'"></span>
                            <button 
                                class="zoom-btn" 
                                @click="zoomIn"
                                :disabled="zoom >= 2"
                                title="Acercar"
                                aria-label="Acercar"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                aria-label="Deshacer"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                                <span class="hidden sm:inline">Deshacer</span>
                            </button>
                            <button 
                                @click="redo()"
                                :disabled="historyIndex >= history.length - 1"
                                class="btn btn-secondary"
                                title="Rehacer (Ctrl+Y)"
                                aria-label="Rehacer"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
                                </svg>
                                <span class="hidden sm:inline">Rehacer</span>
                            </button>
                            <button 
                                @click="clearCanvas"
                                :disabled="placedBlocks.length === 0"
                                class="btn btn-secondary"
                                title="Limpiar todo"
                                aria-label="Limpiar"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="hidden sm:inline">Limpiar</span>
                            </button>
                            <button @click="showSubmitModal = true" class="btn btn-primary" title="Enviar cotización" aria-label="Enviar">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span class="hidden sm:inline">Enviar</span>
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
                    <div class="construction-grid" :style="{ transform: 'scale(' + zoom + ')' }"></div>
                    
                    <!-- Contenedor para los bloques -->
                    <div class="blocks-container">
                        <!-- Bloques colocados -->
                        <template x-for="(block, index) in placedBlocks" :key="block.instanceId">
                            <div 
                                class="draggable-block"
                                :class="{ 'dragging': block.isDragging }"
                                :style="{
                                    left: block.x + 'px',
                                    top: block.y + 'px',
                                    zIndex: block.zIndex || 10,
                                    transform: 'scale(' + zoom + ')',
                                    transformOrigin: '0 0'
                                }"
                                :data-instance-id="block.instanceId"
                            >
                                <div 
                                    class="block-header"
                                    @mousedown="startDrag($event, block)"
                                    @touchstart="startDrag($event, block)"
                                >
                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-medium text-gray-900 text-sm truncate" x-text="block.name"></h3>
                                            <p class="text-xs text-gray-600 mt-0.5 truncate" x-text="block.description"></p>
                                        </div>
                                        <button 
                                            @click="removeBlock(block.instanceId)"
                                            class="p-1 hover:bg-red-50 text-red-600 rounded flex-shrink-0"
                                            title="Eliminar bloque"
                                            aria-label="Eliminar"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="block-content">
                                    <!-- Campos específicos por tipo de bloque -->
                                    <template x-if="block.type === 'course'">
                                        <div class="space-y-2">
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
                                                <label class="field-label">Dificultad</label>
                                                <select 
                                                    x-model="block.difficulty"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-select"
                                                >
                                                    <option value="basic">Básico</option>
                                                    <option value="intermediate">Intermedio</option>
                                                    <option value="advanced">Avanzado</option>
                                                </select>
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Participantes</label>
                                                <input 
                                                    type="number" 
                                                    x-model="block.participants"
                                                    min="1"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-input"
                                                />
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Horas</label>
                                                <input 
                                                    type="number" 
                                                    x-model="block.hours"
                                                    min="1"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-input"
                                                />
                                            </div>
                                            <div class="price-breakdown" x-show="block.subtotal > 0">
                                                <div class="breakdown-row">
                                                    <span>Base:</span>
                                                    <span x-text="formatCurrency(block.base_price)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Modalidad:</span>
                                                    <span x-text="formatCurrency(block.modalityPrice)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Dificultad:</span>
                                                    <span x-text="formatCurrency(block.difficultyPrice)"></span>
                                                </div>
                                                <div class="breakdown-row total">
                                                    <span>Subtotal:</span>
                                                    <span x-text="formatCurrency(block.subtotal)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <template x-if="block.type === 'software_module'">
                                        <div class="space-y-2">
                                            <div class="field-group">
                                                <label class="field-label">Complejidad</label>
                                                <select 
                                                    x-model="block.complexity"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-select"
                                                >
                                                    <option value="simple">Simple</option>
                                                    <option value="medium">Media</option>
                                                    <option value="complex">Compleja</option>
                                                </select>
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Horas</label>
                                                <input 
                                                    type="number" 
                                                    x-model="block.hours"
                                                    min="1"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-input"
                                                />
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Integraciones</label>
                                                <select 
                                                    x-model="block.integrations"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-select"
                                                >
                                                    <option value="none">Ninguna</option>
                                                    <option value="basic">Básicas</option>
                                                    <option value="advanced">Avanzadas</option>
                                                </select>
                                            </div>
                                            <div class="price-breakdown" x-show="block.subtotal > 0">
                                                <div class="breakdown-row">
                                                    <span>Base:</span>
                                                    <span x-text="formatCurrency(block.base_price)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Complejidad:</span>
                                                    <span x-text="formatCurrency(block.complexityPrice)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Horas extra:</span>
                                                    <span x-text="formatCurrency(block.hoursPrice)"></span>
                                                </div>
                                                <div class="breakdown-row total">
                                                    <span>Subtotal:</span>
                                                    <span x-text="formatCurrency(block.subtotal)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <template x-if="block.type === 'audit'">
                                        <div class="space-y-2">
                                            <div class="field-group">
                                                <label class="field-label">Alcance</label>
                                                <select 
                                                    x-model="block.scope"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-select"
                                                >
                                                    <option value="basic">Básico</option>
                                                    <option value="standard">Estándar</option>
                                                    <option value="comprehensive">Completo</option>
                                                </select>
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Sistemas</label>
                                                <input 
                                                    type="number" 
                                                    x-model="block.systems"
                                                    min="1"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-input"
                                                />
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Horas</label>
                                                <input 
                                                    type="number" 
                                                    x-model="block.hours"
                                                    min="1"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-input"
                                                />
                                            </div>
                                            <div class="price-breakdown" x-show="block.subtotal > 0">
                                                <div class="breakdown-row">
                                                    <span>Base:</span>
                                                    <span x-text="formatCurrency(block.base_price)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Alcance:</span>
                                                    <span x-text="formatCurrency(block.scopePrice)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Sistemas extra:</span>
                                                    <span x-text="formatCurrency(block.systemsPrice)"></span>
                                                </div>
                                                <div class="breakdown-row total">
                                                    <span>Subtotal:</span>
                                                    <span x-text="formatCurrency(block.subtotal)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <!-- Bloques genéricos -->
                                    <template x-if="['maintenance', 'consulting'].includes(block.type)">
                                        <div class="space-y-2">
                                            <div class="field-group">
                                                <label class="field-label">Nivel</label>
                                                <select 
                                                    x-model="block.service_level"
                                                    @change="updateBlockPrice(block)"
                                                    class="field-select"
                                                >
                                                    <option value="basic">Básico</option>
                                                    <option value="standard">Estándar</option>
                                                    <option value="premium">Premium</option>
                                                </select>
                                            </div>
                                            <div class="field-group">
                                                <label class="field-label">Horas</label>
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
                                                    <option value="monthly">Mensual</option>
                                                    <option value="quarterly">Trimestral</option>
                                                </select>
                                            </div>
                                            <div class="price-breakdown" x-show="block.subtotal > 0">
                                                <div class="breakdown-row">
                                                    <span>Base:</span>
                                                    <span x-text="formatCurrency(block.base_price)"></span>
                                                </div>
                                                <div class="breakdown-row">
                                                    <span>Nivel:</span>
                                                    <span x-text="formatCurrency(block.serviceLevelPrice)"></span>
                                                </div>
                                                <div class="breakdown-row total">
                                                    <span>Subtotal:</span>
                                                    <span x-text="formatCurrency(block.subtotal)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <!-- Cantidad -->
                                    <div class="field-group mt-3">
                                        <label class="field-label">Cantidad</label>
                                        <input 
                                            type="number" 
                                            x-model="block.quantity"
                                            min="1"
                                            max="99"
                                            @change="updateBlockPrice(block)"
                                            class="field-input"
                                        />
                                    </div>
                                </div>
                                
                                <div class="block-actions">
                                    <div class="text-xs font-semibold text-accent">
                                        Total: <span x-text="formatCurrency(block.totalPrice)"></span>
                                        <span class="text-xs text-gray-500 ml-2" x-text="block.hours + 'h'"></span>
                                    </div>
                                    <button 
                                        @click="duplicateBlock(block.instanceId)"
                                        class="text-xs text-gray-600 hover:text-accent p-1"
                                        title="Duplicar bloque"
                                        aria-label="Duplicar"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Estado vacío -->
                        <div 
                            x-show="placedBlocks.length === 0"
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center p-8"
                        >
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Comienza tu cotización</h3>
                            <p class="text-gray-600 text-sm mb-4 max-w-xs">
                                Arrastra servicios desde el panel izquierdo para construir tu cotización personalizada.
                            </p>
                        </div>
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
                <div class="text-xs text-gray-500" x-text="totalHours + ' horas'"></div>
            </div>
            
            <div class="summary-breakdown">
                <div class="summary-item">
                    <div class="summary-item-label">Servicios</div>
                    <div class="summary-item-value" x-text="placedBlocks.length"></div>
                </div>
                <div class="summary-item">
                    <div class="summary-item-label">Subtotal</div>
                    <div class="summary-item-value" x-text="formatCurrency(subtotal)"></div>
                </div>
                <div class="summary-item">
                    <div class="summary-item-label">IVA 16%</div>
                    <div class="summary-item-value" x-text="formatCurrency(totalTax)"></div>
                </div>
            </div>
            
            <div class="summary-actions">
                <button 
                    class="btn btn-secondary"
                    @click="exportPDF()"
                    :disabled="isExportingPDF || placedBlocks.length === 0"
                    :class="{ 'opacity-50': isExportingPDF }"
                    title="Exportar PDF"
                    aria-label="Exportar PDF"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-text="isExportingPDF ? 'Generando...' : 'Exportar PDF'"></span>
                </button>
                <button 
                    class="btn btn-primary"
                    @click="showSubmitModal = true"
                    :disabled="placedBlocks.length === 0"
                    title="Enviar cotización"
                    aria-label="Enviar"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
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
        @keydown.escape.window="showSubmitModal = false"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Enviar Cotización</h2>
                <button class="modal-close" @click="showSubmitModal = false" aria-label="Cerrar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="space-y-4">
                    <div>
                        <label class="field-label">Nombre completo *</label>
                        <input 
                            type="text" 
                            class="field-input" 
                            x-model="clientForm.name" 
                            placeholder="Nombre del cliente o empresa"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="field-label">Correo electrónico *</label>
                        <input 
                            type="email" 
                            class="field-input" 
                            x-model="clientForm.email" 
                            placeholder="ejemplo@empresa.com"
                            required
                        >
                    </div>

                    <div>
                        <label class="field-label">Teléfono</label>
                        <input 
                            type="tel" 
                            class="field-input" 
                            x-model="clientForm.phone" 
                            placeholder="+52 123 456 7890"
                        >
                    </div>

                    <div>
                        <label class="field-label">Empresa</label>
                        <input 
                            type="text" 
                            class="field-input" 
                            x-model="clientForm.company" 
                            placeholder="Nombre de la empresa"
                        >
                    </div>

                    <div>
                        <label class="field-label">Notas adicionales</label>
                        <textarea 
                            class="field-input" 
                            rows="2"
                            x-model="clientForm.notes"
                            placeholder="Información adicional o requerimientos especiales..."
                        ></textarea>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 text-sm mb-3">Resumen de la cotización</h3>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Servicios:</span>
                                <span x-text="placedBlocks.length"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Horas totales:</span>
                                <span x-text="totalHours"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span x-text="formatCurrency(subtotal)"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">IVA (16%):</span>
                                <span x-text="formatCurrency(totalTax)"></span>
                            </div>
                            <div class="flex items-center justify-between font-semibold text-base pt-2 border-t border-gray-200">
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
                            :disabled="isSubmitting || !clientForm.name || !clientForm.email"
                            :class="{ 'opacity-50': isSubmitting || !clientForm.name || !clientForm.email }"
                        >
                            <span x-show="!isSubmitting">Enviar Cotización</span>
                            <span x-show="isSubmitting">Enviando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de éxito -->
    <div 
        x-show="showSuccessModal"
        x-transition
        class="modal-overlay"
    >
        <div class="modal-content">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-xl font-semibold text-gray-900 mb-2">¡Cotización enviada!</h2>
                <p class="text-gray-600 text-sm mb-4">
                    Hemos recibido tu solicitud. Te contactaremos en menos de 24 horas.
                </p>
                
                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                    <div class="text-xs text-gray-600 mb-1">Número de referencia:</div>
                    <div class="font-mono font-semibold text-accent text-base" x-text="'DMI-' + quoteReference"></div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-2">
                    <button 
                        type="button"
                        class="btn btn-secondary"
                        @click="downloadPDF()"
                        x-show="pdfGenerated"
                    >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Descargar PDF
                    </button>
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
            pdfGenerated: false,
            
            // Historial
            history: [],
            historyIndex: -1,
            
            // Formulario de cliente
            clientForm: {
                name: '',
                email: '',
                phone: '',
                company: '',
                notes: ''
            },
            
            // Referencia
            quoteReference: '',
            pdfUrl: '',
            
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
            init() {
                this.loadBlocks();
                this.loadSavedState();
                
                // Inicializar interact.js
                this.$nextTick(() => {
                    this.setupInteractJS();
                });
                
                this.setupKeyboardShortcuts();
                this.setupAutoSave();
                this.saveToHistory();
            },
            
            // Cargar bloques
            loadBlocks() {
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
                        description: 'Introducción especializada',
                        type: 'course',
                        category_id: 'courses',
                        default_hours: 20,
                        base_price: 10000
                    },
                    {
                        id: 'course_advanced',
                        name: 'Curso Avanzado',
                        description: 'Capacitación experta',
                        type: 'course',
                        category_id: 'courses',
                        default_hours: 40,
                        base_price: 20000
                    },
                    {
                        id: 'software_module',
                        name: 'Módulo Software',
                        description: 'Desarrollo personalizado',
                        type: 'software_module',
                        category_id: 'software',
                        default_hours: 80,
                        base_price: 40000
                    },
                    {
                        id: 'security_audit',
                        name: 'Auditoría Seguridad',
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
                        name: 'Horas Consultoría',
                        description: 'Asesoría especializada',
                        type: 'consulting',
                        category_id: 'consulting',
                        default_hours: 10,
                        base_price: 5000
                    }
                ];
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
            
            // Drag & Drop mejorado
            onDragStart(event, block) {
                event.dataTransfer.setData('text/plain', JSON.stringify(block));
                event.dataTransfer.effectAllowed = 'copy';
                event.target.classList.add('dragging');
            },
            
            onDragEnd(event) {
                event.target.classList.remove('dragging');
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
                    
                    // Calcular posición EXACTA donde se soltó (ajustada por zoom)
                    const x = (event.clientX - rect.left) / this.zoom;
                    const y = (event.clientY - rect.top) / this.zoom;
                    
                    // Ajustar para que el bloque quede centrado en el cursor
                    const blockWidth = 260;
                    const blockHeight = 120;
                    
                    this.addBlockToCanvas(blockData, x - (blockWidth / 2), y - 30);
                } catch (error) {
                    console.error('Error dropping block:', error);
                }
            },
            
            addBlockToCanvas(blockData, x, y) {
                const instanceId = 'block_' + Date.now() + '_' + Math.random().toString(36).substr(2, 6);
                
                const block = {
                    ...this.initializeBlockData(blockData),
                    instanceId,
                    x: Math.max(0, x),
                    y: Math.max(0, y),
                    zIndex: 10 + this.placedBlocks.length,
                    isDragging: false
                };
                
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
                
                // Configuración por tipo
                switch (blockData.type) {
                    case 'course':
                        baseBlock.modality = 'online';
                        baseBlock.difficulty = 'basic';
                        baseBlock.participants = 10;
                        break;
                    case 'software_module':
                        baseBlock.complexity = 'medium';
                        baseBlock.integrations = 'none';
                        break;
                    case 'audit':
                        baseBlock.scope = 'standard';
                        baseBlock.systems = 1;
                        break;
                    case 'maintenance':
                    case 'consulting':
                        baseBlock.service_level = 'standard';
                        baseBlock.frequency = 'monthly';
                        break;
                }
                
                return baseBlock;
            },
            
            // Cálculos de precios
            updateBlockPrice(block) {
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
                
                block.totalPrice = (block.subtotal || 0) * block.quantity;
                this.saveToHistory();
            },
            
            calculateCoursePrice(block) {
                const modalityPrices = { online: 0, onsite: 0.3, hybrid: 0.15 };
                const difficultyPrices = { basic: 0, intermediate: 0.2, advanced: 0.4 };
                
                block.modalityPrice = block.base_price * (modalityPrices[block.modality] || 0);
                block.difficultyPrice = block.base_price * (difficultyPrices[block.difficulty] || 0);
                block.participantsPrice = Math.max(0, (block.participants - 10) * 500);
                block.hoursPrice = Math.max(0, (block.hours - 20) * 300);
                
                block.subtotal = block.base_price + block.modalityPrice + block.difficultyPrice + 
                               block.participantsPrice + block.hoursPrice;
            },
            
            calculateSoftwarePrice(block) {
                const complexityFactors = { simple: 1.0, medium: 1.5, complex: 2.0 };
                const integrationPrices = { none: 0, basic: 5000, advanced: 10000 };
                
                const factor = complexityFactors[block.complexity] || 1.5;
                block.complexityPrice = block.base_price * (factor - 1);
                block.hoursPrice = Math.max(0, (block.hours - 80) * 800);
                block.integrationsPrice = integrationPrices[block.integrations] || 0;
                
                block.subtotal = (block.base_price * factor) + block.hoursPrice + block.integrationsPrice;
            },
            
            calculateAuditPrice(block) {
                const scopeFactors = { basic: 0.7, standard: 1.0, comprehensive: 1.4 };
                
                const factor = scopeFactors[block.scope] || 1.0;
                block.scopePrice = block.base_price * (factor - 1);
                block.systemsPrice = Math.max(0, (block.systems - 1) * 2000);
                block.hoursPrice = Math.max(0, (block.hours - 40) * 500);
                
                block.subtotal = (block.base_price * factor) + block.systemsPrice + block.hoursPrice;
            },
            
            calculateGenericPrice(block) {
                const serviceLevelFactors = { basic: 0.8, standard: 1.0, premium: 1.3 };
                
                const factor = serviceLevelFactors[block.service_level] || 1.0;
                block.serviceLevelPrice = block.base_price * (factor - 1);
                block.hoursPrice = Math.max(0, (block.hours - 20) * 400);
                
                block.subtotal = (block.base_price * factor) + block.hoursPrice;
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
                    duplicate.instanceId = 'block_' + Date.now() + '_' + Math.random().toString(36).substr(2, 6);
                    duplicate.x += 20;
                    duplicate.y += 20;
                    duplicate.zIndex = 10 + this.placedBlocks.length;
                    
                    this.placedBlocks.push(duplicate);
                    this.saveToHistory();
                    this.showToast('Bloque duplicado', 'success');
                }
            },
            
            // Zoom (aplica a los bloques individualmente)
            zoomIn() {
                if (this.zoom < 2) {
                    this.zoom = Math.round((this.zoom + 0.1) * 10) / 10;
                    this.updateCanvasZoom();
                }
            },
            
            zoomOut() {
                if (this.zoom > 0.5) {
                    this.zoom = Math.round((this.zoom - 0.1) * 10) / 10;
                    this.updateCanvasZoom();
                }
            },
            
            updateCanvasZoom() {
                // Actualizar CSS variable para los bloques
                document.documentElement.style.setProperty('--zoom-level', this.zoom);
            },
            
            // Historial
            saveToHistory() {
                // Limitar historial
                if (this.history.length >= 30) {
                    this.history.shift();
                    this.historyIndex = Math.max(0, this.historyIndex - 1);
                }
                
                this.history = this.history.slice(0, this.historyIndex + 1);
                
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
                    this.updateCanvasZoom();
                    this.showToast('Cambio deshecho', 'info');
                }
            },
            
            redo() {
                if (this.historyIndex < this.history.length - 1) {
                    this.historyIndex++;
                    const state = this.history[this.historyIndex];
                    this.placedBlocks = JSON.parse(JSON.stringify(state.placedBlocks));
                    this.zoom = state.zoom;
                    this.updateCanvasZoom();
                    this.showToast('Cambio rehecho', 'info');
                }
            },
            
            // Interact.js con zoom en cuenta
            setupInteractJS() {
                const canvas = document.getElementById('construction-canvas');
                if (!canvas || !interact) return;
                
                interact('.draggable-block', {
                    context: canvas
                }).draggable({
                    listeners: {
                        start: (event) => {
                            const instanceId = event.target.getAttribute('data-instance-id');
                            const block = this.placedBlocks.find(b => b.instanceId === instanceId);
                            if (block) {
                                block.isDragging = true;
                                block.zIndex = 100 + this.placedBlocks.length;
                            }
                        },
                        move: (event) => {
                            const instanceId = event.target.getAttribute('data-instance-id');
                            const block = this.placedBlocks.find(b => b.instanceId === instanceId);
                            if (block) {
                                // Ajustar movimiento por el zoom
                                block.x += event.dx / this.zoom;
                                block.y += event.dy / this.zoom;
                                
                                // Mantener dentro del canvas
                                const maxX = 2000 - 260;
                                const maxY = 2000 - 120;
                                
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
                    }
                });
            },
            
            // Atajos de teclado
            setupKeyboardShortcuts() {
                document.addEventListener('keydown', (event) => {
                    if ((event.ctrlKey || event.metaKey) && event.key === 'z' && !event.shiftKey) {
                        event.preventDefault();
                        this.undo();
                    }
                    if ((event.ctrlKey || event.metaKey) && (event.key === 'y' || (event.key === 'z' && event.shiftKey))) {
                        event.preventDefault();
                        this.redo();
                    }
                });
            },
            
            // Guardado automático
            setupAutoSave() {
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
                        this.updateCanvasZoom();
                        
                        // Recalcular precios
                        this.placedBlocks.forEach(block => this.updateBlockPrice(block));
                    }
                } catch (error) {
                    console.warn('Error loading saved state:', error);
                }
            },
            
            saveState() {
                try {
                    const state = {
                        placedBlocks: this.placedBlocks,
                        zoom: this.zoom,
                        timestamp: Date.now()
                    };
                    localStorage.setItem('quoteBuilderState', JSON.stringify(state));
                } catch (error) {
                    console.warn('Error saving state:', error);
                }
            },
            
            clearCanvas() {
                if (this.placedBlocks.length > 0 && confirm('¿Limpiar toda la cotización? Esta acción no se puede deshacer.')) {
                    this.placedBlocks = [];
                    this.saveToHistory();
                    this.showToast('Canvas limpiado', 'info');
                }
            },
            
            // Formateo
            formatCurrency(value) {
                return new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: 'MXN',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
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
                        <div class="text-xs font-medium">${message}</div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 text-xs" onclick="this.parentElement.remove()">
                        ✕
                    </button>
                `;
                
                container.appendChild(toast);
                
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 4000);
            },
            
            // Funciones de envío mejoradas
            async submitQuote() {
                if (!this.clientForm.name || !this.clientForm.email) {
                    this.showToast('Completa los campos requeridos', 'error');
                    return;
                }
                
                this.isSubmitting = true;
                
                try {
                    // Generar PDF primero
                    await this.generatePDF(true);
                    
                    // Simular envío exitoso
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    
                    // Generar referencia única
                    this.quoteReference = Date.now().toString().substr(-6);
                    this.pdfGenerated = true;
                    
                    // Mostrar éxito
                    this.showSubmitModal = false;
                    this.showSuccessModal = true;
                    
                    // Limpiar formulario
                    this.clientForm = {
                        name: '',
                        email: '',
                        phone: '',
                        company: '',
                        notes: ''
                    };
                    
                    // Guardar en localStorage para historial
                    this.saveQuoteToHistory();
                    
                    this.showToast('Cotización enviada exitosamente', 'success');
                    
                } catch (error) {
                    console.error('Error submitting quote:', error);
                    this.showToast('Error al enviar la cotización', 'error');
                } finally {
                    this.isSubmitting = false;
                }
            },
            
            saveQuoteToHistory() {
                try {
                    const quoteHistory = JSON.parse(localStorage.getItem('quoteHistory') || '[]');
                    
                    const quote = {
                        id: this.quoteReference,
                        date: new Date().toISOString(),
                        client: { ...this.clientForm },
                        total: this.totalCost,
                        services: this.placedBlocks.map(b => ({
                            name: b.name,
                            quantity: b.quantity,
                            price: b.totalPrice
                        }))
                    };
                    
                    quoteHistory.unshift(quote);
                    if (quoteHistory.length > 50) quoteHistory.pop();
                    
                    localStorage.setItem('quoteHistory', JSON.stringify(quoteHistory));
                } catch (error) {
                    console.warn('Error saving quote to history:', error);
                }
            },
            
            async exportPDF() {
                if (this.placedBlocks.length === 0) {
                    this.showToast('Agrega servicios primero', 'warning');
                    return;
                }
                
                this.isExportingPDF = true;
                
                try {
                    await this.generatePDF(false);
                    this.showToast('PDF generado exitosamente', 'success');
                } catch (error) {
                    console.error('Error generating PDF:', error);
                    this.showToast('Error al generar PDF', 'error');
                } finally {
                    this.isExportingPDF = false;
                }
            },
            
            async generatePDF(silent = false) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                // Configuración de márgenes
                const margin = 20;
                let y = margin;
                
                // Encabezado
                doc.setFontSize(20);
                doc.text('COTIZACIÓN PROFESIONAL', 105, y, { align: 'center' });
                y += 15;
                
                // Información de referencia
                this.quoteReference = this.quoteReference || 'DMI-' + Date.now().toString().substr(-6);
                doc.setFontSize(10);
                doc.text(`Referencia: ${this.quoteReference}`, margin, y);
                doc.text(`Fecha: ${new Date().toLocaleDateString('es-MX')}`, margin, y + 6);
                doc.text(`Página: 1/1`, 200 - margin, y, { align: 'right' });
                y += 15;
                
                // Línea separadora
                doc.setDrawColor(200, 200, 200);
                doc.line(margin, y, 200 - margin, y);
                y += 10;
                
                // Información del cliente
                if (this.clientForm.name || this.clientForm.company) {
                    doc.setFontSize(12);
                    doc.text('INFORMACIÓN DEL CLIENTE', margin, y);
                    y += 8;
                    
                    doc.setFontSize(10);
                    if (this.clientForm.name) {
                        doc.text(`Nombre: ${this.clientForm.name}`, margin, y);
                        y += 6;
                    }
                    if (this.clientForm.company) {
                        doc.text(`Empresa: ${this.clientForm.company}`, margin, y);
                        y += 6;
                    }
                    if (this.clientForm.email) {
                        doc.text(`Email: ${this.clientForm.email}`, margin, y);
                        y += 6;
                    }
                    if (this.clientForm.phone) {
                        doc.text(`Teléfono: ${this.clientForm.phone}`, margin, y);
                        y += 6;
                    }
                    y += 8;
                }
                
                // Tabla de servicios
                doc.setFontSize(12);
                doc.text('DETALLE DE SERVICIOS', margin, y);
                y += 10;
                
                // Encabezados de tabla
                doc.setFontSize(10);
                doc.setFillColor(240, 240, 240);
                const colWidths = [100, 20, 20, 30];
                const colPositions = [margin, margin + colWidths[0], margin + colWidths[0] + colWidths[1], margin + colWidths[0] + colWidths[1] + colWidths[2]];
                
                doc.rect(colPositions[0], y, colWidths[0], 8, 'F');
                doc.rect(colPositions[1], y, colWidths[1], 8, 'F');
                doc.rect(colPositions[2], y, colWidths[2], 8, 'F');
                doc.rect(colPositions[3], y, colWidths[3], 8, 'F');
                
                doc.text('Descripción', colPositions[0] + 2, y + 6);
                doc.text('Cant.', colPositions[1] + 2, y + 6);
                doc.text('Horas', colPositions[2] + 2, y + 6);
                doc.text('Precio', colPositions[3] + 2, y + 6);
                
                y += 8;
                
                // Servicios
                let rowHeight = 8;
                for (let block of this.placedBlocks) {
                    // Verificar si necesitamos nueva página
                    if (y > 250) {
                        doc.addPage();
                        y = margin;
                    }
                    
                    // Descripción
                    doc.text(block.name.substring(0, 30), colPositions[0] + 2, y + 6);
                    doc.text(block.quantity.toString(), colPositions[1] + 2, y + 6);
                    doc.text(block.hours.toString(), colPositions[2] + 2, y + 6);
                    doc.text(this.formatCurrency(block.totalPrice), colPositions[3] + 2, y + 6);
                    y += rowHeight;
                    
                    // Descripción adicional si cabe
                    if (block.description && y <= 250) {
                        doc.text(`  ${block.description.substring(0, 40)}`, colPositions[0] + 2, y + 6);
                        y += rowHeight;
                    }
                }
                
                // Totales
                y += 10;
                doc.setDrawColor(200, 200, 200);
                doc.line(colPositions[3], y, colPositions[3] + colWidths[3], y);
                y += 5;
                
                doc.text('Subtotal:', colPositions[2] + 2, y + 6);
                doc.text(this.formatCurrency(this.subtotal), colPositions[3] + 2, y + 6);
                y += 8;
                
                doc.text('IVA (16%):', colPositions[2] + 2, y + 6);
                doc.text(this.formatCurrency(this.totalTax), colPositions[3] + 2, y + 6);
                y += 8;
                
                doc.setFontSize(11);
                doc.setFont(undefined, 'bold');
                doc.text('TOTAL:', colPositions[2] + 2, y + 6);
                doc.text(this.formatCurrency(this.totalCost), colPositions[3] + 2, y + 6);
                
                // Notas
                y += 15;
                if (this.clientForm.notes) {
                    doc.setFontSize(9);
                    doc.setFont(undefined, 'normal');
                    doc.text('Notas:', margin, y);
                    y += 6;
                    doc.text(this.clientForm.notes.substring(0, 150), margin, y, { maxWidth: 160 });
                }
                
                // Pie de página
                doc.setFontSize(8);
                doc.text('Digital Market Intelligence', 105, 285, { align: 'center' });
                doc.text('www.dmi.com.mx | contacto@dmi.com.mx', 105, 290, { align: 'center' });
                doc.text('Esta cotización es válida por 30 días naturales', 105, 295, { align: 'center' });
                
                // Guardar PDF
                const pdfBlob = doc.output('blob');
                const url = URL.createObjectURL(pdfBlob);
                
                if (!silent) {
                    // Descargar PDF
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `cotizacion-dmi-${this.quoteReference}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                } else {
                    // Guardar para descarga posterior
                    this.pdfUrl = url;
                    this.pdfGenerated = true;
                }
            },
            
            downloadPDF() {
                if (this.pdfUrl) {
                    const a = document.createElement('a');
                    a.href = this.pdfUrl;
                    a.download = `cotizacion-dmi-${this.quoteReference}.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            },
            
            startDrag(event) {
                // Manejo por interact.js
            }
        }
    }
    </script>
</body>
</html>