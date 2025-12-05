<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cotizador Modular - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- SortableJS para drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <style>
        /* Variables y estilos base inspirados en Linear.app */
        :root {
            /* Palette Linear/Vercel */
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #0ea5e9;
            --accent: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            
            /* Neutros */
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
            
            /* Fondo glassmorphism */
            --glass-bg: rgba(255, 255, 255, 0.72);
            --glass-border: rgba(255, 255, 255, 0.16);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            
            /* Animaciones */
            --transition-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Estilos base */
        body {
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            min-height: 100vh;
            color: var(--gray-800);
            overflow-x: hidden;
        }
        
        /* Navbar minimalista */
        .navbar-quote {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: var(--glass-bg);
            border-bottom: 1px solid var(--glass-border);
        }
        
        /* Card glassmorphism */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
        }
        
        /* Bloques drag & drop */
        .block-item {
            transition: all 0.3s var(--transition-smooth);
            cursor: grab;
            user-select: none;
        }
        
        .block-item:active {
            cursor: grabbing;
        }
        
        .block-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        
        .block-item.dragging {
            opacity: 0.8;
            transform: rotate(2deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Categorías de bloques */
        .category-badge {
            transition: all 0.2s ease;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        
        .category-badge:hover {
            transform: scale(1.05);
        }
        
        /* Input elegante */
        .elegant-input {
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.8);
            border: 1.5px solid var(--gray-200);
        }
        
        .elegant-input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        /* Botón estilo Linear */
        .btn-linear {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-linear:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }
        
        .btn-linear::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }
        
        .btn-linear:hover::after {
            left: 100%;
        }
        
        /* Animaciones personalizadas */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.5s var(--transition-smooth);
        }
        
        .animate-slide-in-up {
            animation: slideInUp 0.5s var(--transition-smooth);
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        
        /* Estado de carga */
        .loading-shimmer {
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.8) 50%, 
                rgba(255, 255, 255, 0) 100%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Overlay modal */
        .modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
    </style>
</head>

<body x-data="quoteBuilder()" x-init="init()" class="min-h-screen">
    
    <!-- Navbar Minimalista -->
    <nav class="navbar-quote fixed top-0 left-0 right-0 z-50 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center">
                        <span class="text-white font-bold text-lg">QB</span>
                    </div>
                    <span class="text-gray-800 font-semibold text-lg">QuoteBuilder</span>
                </a>
                
                <!-- Acciones -->
                <div class="flex items-center space-x-4">
                    <button @click="resetQuote" class="px-4 py-2 text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                        Reiniciar
                    </button>
                    <a href="/" class="px-4 py-2 text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="pt-24 pb-16">
        <div class="container mx-auto px-6">
            
            <!-- Header Hero -->
            <div class="text-center mb-12 animate-slide-in-up">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-primary/10 to-secondary/10 text-primary font-medium text-sm mb-6">
                    ✨ Construye tu solución ideal
                </div>
                <h1 class="text-5xl font-bold text-gray-900 mb-4">
                    Cotizador <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Modular</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Arma tu proyecto como un profesional. Selecciona, ajusta y organiza los bloques que necesitas.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Panel Izquierdo: Librería de Bloques -->
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-2xl p-6 sticky top-32">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">📦 Librería de Bloques</h2>
                        
                        <!-- Filtros por Categoría -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            <template x-for="category in categories" :key="category.id">
                                <button 
                                    @click="activeCategory = category.id"
                                    :class="{
                                        'bg-primary text-white': activeCategory === category.id,
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200': activeCategory !== category.id
                                    }"
                                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all"
                                >
                                    <span x-text="category.name"></span>
                                </button>
                            </template>
                        </div>
                        
                        <!-- Lista de Bloques Disponibles -->
                        <div class="space-y-3">
                            <template x-for="block in filteredBlocks" :key="block.id">
                                <div 
                                    @click="addBlock(block)"
                                    class="block-item glass-card rounded-xl p-4 hover:border-primary/30 cursor-pointer transition-all group"
                                >
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2">
                                                <span x-text="block.icon" class="text-lg"></span>
                                                <h3 x-text="block.name" class="font-semibold text-gray-900"></h3>
                                            </div>
                                            <p x-text="block.description" class="text-sm text-gray-600 mb-3"></p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="text-primary font-medium" x-text="'$' + (block.hours * 500) + ' MXN'"></span>
                                                <span class="text-gray-500" x-text="block.hours + ' horas'"></span>
                                            </div>
                                        </div>
                                        <button class="opacity-0 group-hover:opacity-100 text-primary transition-opacity">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Estadísticas Rápidas -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900" x-text="totalBlocks"></div>
                                    <div class="text-sm text-gray-500">Bloques</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary" x-text="'$' + totalCost"></div>
                                    <div class="text-sm text-gray-500">Costo total</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel Central: Constructor de Cotización -->
                <div class="lg:col-span-2">
                    <div class="glass-card rounded-2xl p-8">
                        <!-- Encabezado del Constructor -->
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Tu Cotización</h2>
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-gray-500" x-text="selectedBlocks.length + ' bloques seleccionados'"></span>
                                <button 
                                    @click="showPreview = true"
                                    class="btn-linear px-6 py-3 rounded-lg font-medium"
                                >
                                    Vista Previa
                                </button>
                            </div>
                        </div>
                        
                        <!-- Área de Construcción (Drag & Drop) -->
                        <div 
                            id="construction-area"
                            class="min-h-[400px] border-2 border-dashed border-gray-300 rounded-2xl p-6 transition-colors hover:border-primary/30"
                            :class="{ 'bg-gray-50': selectedBlocks.length === 0 }"
                        >
                            <!-- Estado Vacío -->
                            <div 
                                x-show="selectedBlocks.length === 0" 
                                class="h-full flex flex-col items-center justify-center text-center py-12"
                            >
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center mb-6">
                                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Comienza a construir</h3>
                                <p class="text-gray-600 max-w-sm">
                                    Arrastra bloques desde la librería o haz clic para agregarlos. Organízalos según tu flujo de trabajo.
                                </p>
                            </div>
                            
                            <!-- Bloques Seleccionados -->
                            <div 
                                id="selected-blocks"
                                class="space-y-4"
                                x-show="selectedBlocks.length > 0"
                            >
                                <template x-for="(block, index) in selectedBlocks" :key="block.id + '-' + index">
                                    <div 
                                        :data-id="block.id"
                                        class="block-item glass-card rounded-xl p-5 transition-all"
                                        :class="{ 'border-primary/50': block.customHours }"
                                    >
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <span x-text="block.icon" class="text-xl"></span>
                                                    <div>
                                                        <h4 x-text="block.name" class="font-semibold text-gray-900"></h4>
                                                        <p x-text="block.description" class="text-sm text-gray-600 mt-1"></p>
                                                    </div>
                                                </div>
                                                
                                                <!-- Controles del Bloque -->
                                                <div class="flex items-center justify-between mt-4">
                                                    <div class="flex items-center gap-4">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-sm text-gray-500">Duración:</span>
                                                            <div class="flex items-center gap-2">
                                                                <button 
                                                                    @click="decreaseHours(index)"
                                                                    class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100"
                                                                >
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                                    </svg>
                                                                </button>
                                                                <input 
                                                                    type="number" 
                                                                    x-model="block.customHours || block.hours"
                                                                    @change="updateBlockHours(index, $event.target.value)"
                                                                    min="1" 
                                                                    max="200"
                                                                    class="w-16 elegant-input text-center py-1 rounded-lg"
                                                                />
                                                                <button 
                                                                    @click="increaseHours(index)"
                                                                    class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100"
                                                                >
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                                    </svg>
                                                                </button>
                                                                <span class="text-sm text-gray-500 ml-2">horas</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-primary font-semibold">
                                                            <span x-text="'$' + ((block.customHours || block.hours) * 500)"></span>
                                                            <span class="text-sm text-gray-500"> MXN</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-2">
                                                        <button 
                                                            @click="moveBlockUp(index)"
                                                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg"
                                                            :disabled="index === 0"
                                                            :class="{ 'opacity-30 cursor-not-allowed': index === 0 }"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                            </svg>
                                                        </button>
                                                        <button 
                                                            @click="moveBlockDown(index)"
                                                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg"
                                                            :disabled="index === selectedBlocks.length - 1"
                                                            :class="{ 'opacity-30 cursor-not-allowed': index === selectedBlocks.length - 1 }"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                        <button 
                                                            @click="removeBlock(index)"
                                                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        
                        <!-- Resumen y Acciones -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                                <!-- Total -->
                                <div class="text-center lg:text-left">
                                    <div class="text-sm text-gray-500 mb-1">Total estimado</div>
                                    <div class="text-4xl font-bold text-gray-900" x-text="'$' + totalCost"></div>
                                    <div class="text-sm text-gray-500 mt-1" x-text="totalHours + ' horas de trabajo'"></div>
                                </div>
                                
                                <!-- Acciones -->
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button 
                                        @click="exportQuote"
                                        class="px-6 py-3 border-2 border-gray-300 rounded-lg font-medium text-gray-700 hover:border-gray-400 hover:bg-gray-50 transition-all"
                                    >
                                        Exportar PDF
                                    </button>
                                    <button 
                                        @click="showContactForm = true"
                                        class="btn-linear px-8 py-3 rounded-lg font-medium"
                                    >
                                        Continuar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: Formulario de Contacto -->
    <div 
        x-show="showContactForm" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay"
        @click.self="showContactForm = false"
    >
        <div 
            class="glass-card rounded-2xl p-8 w-full max-w-lg animate-slide-in-up"
            @click.stop
        >
            <h2 class="text-2xl font-bold text-gray-900 mb-2">📝 Información de contacto</h2>
            <p class="text-gray-600 mb-6">Completa tus datos para recibir la cotización formal.</p>
            
            <form @submit.prevent="submitQuote" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre completo *</label>
                    <input 
                        type="text" 
                        x-model="contactForm.name"
                        required
                        class="w-full elegant-input rounded-lg px-4 py-3"
                        placeholder="Tu nombre"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input 
                        type="email" 
                        x-model="contactForm.email"
                        required
                        class="w-full elegant-input rounded-lg px-4 py-3"
                        placeholder="tucorreo@ejemplo.com"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción del proyecto</label>
                    <textarea 
                        x-model="contactForm.project_description"
                        rows="4"
                        class="w-full elegant-input rounded-lg px-4 py-3 resize-none"
                        placeholder="Describe brevemente los objetivos de tu proyecto..."
                    ></textarea>
                </div>
                
                <div class="flex items-center gap-4 pt-4">
                    <button 
                        type="button"
                        @click="showContactForm = false"
                        class="flex-1 px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="submit"
                        class="flex-1 btn-linear px-6 py-3 rounded-lg font-medium"
                        :disabled="isSubmitting"
                    >
                        <span x-show="!isSubmitting">Enviar cotización</span>
                        <span x-show="isSubmitting" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Enviando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Vista Previa -->
    <div 
        x-show="showPreview" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay"
        @click.self="showPreview = false"
    >
        <div 
            class="glass-card rounded-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto"
            @click.stop
        >
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Vista previa de la cotización</h2>
                <button @click="showPreview = false" class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="space-y-6">
                <template x-for="(block, index) in selectedBlocks" :key="index">
                    <div class="border border-gray-200 rounded-xl p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-900" x-text="block.name"></h3>
                                <p class="text-gray-600 mt-1" x-text="block.description"></p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-primary" x-text="'$' + ((block.customHours || block.hours) * 500)"></div>
                                <div class="text-sm text-gray-500" x-text="(block.customHours || block.hours) + ' horas'"></div>
                            </div>
                        </div>
                    </div>
                </template>
                
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-500">Total de horas</div>
                            <div class="text-2xl font-bold text-gray-900" x-text="totalHours"></div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Costo total</div>
                            <div class="text-4xl font-bold text-primary" x-text="'$' + totalCost"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Confirmación de Envío -->
    <div 
        x-show="showSuccess"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay"
    >
        <div class="glass-card rounded-2xl p-10 text-center max-w-md">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-success/10 to-success/20 flex items-center justify-center mx-auto mb-6 animate-pulse-glow">
                <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-4">¡Cotización enviada!</h2>
            <p class="text-gray-600 mb-6">
                Hemos recibido tu solicitud. Te contactaremos en menos de 24 horas para discutir los detalles de tu proyecto.
            </p>
            
            <div class="space-y-4">
                <div class="text-sm text-gray-500">
                    Número de referencia: <span class="font-mono text-primary" x-text="'#' + Math.random().toString(36).substr(2, 9).toUpperCase()"></span>
                </div>
                <a 
                    href="/"
                    class="inline-block btn-linear px-8 py-3 rounded-lg font-medium"
                >
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript Alpine -->
    <script>
        function quoteBuilder() {
            return {
                // Estado
                categories: [
                    { id: 'all', name: 'Todos' },
                    { id: 'development', name: 'Desarrollo' },
                    { id: 'design', name: 'Diseño' },
                    { id: 'consulting', name: 'Consultoría' },
                    { id: 'security', name: 'Seguridad' }
                ],
                
                blocks: [
                    {
                        id: 1,
                        name: 'Auditoría de Código',
                        description: 'Revisión exhaustiva de código existente para identificar problemas de seguridad, performance y buenas prácticas.',
                        icon: '🔍',
                        hours: 8,
                        category: 'security'
                    },
                    {
                        id: 2,
                        name: 'Pruebas de Penetración',
                        description: 'Simulación de ataques controlados para identificar vulnerabilidades en tu aplicación.',
                        icon: '🛡️',
                        hours: 16,
                        category: 'security'
                    },
                    {
                        id: 3,
                        name: 'Refactorización',
                        description: 'Mejora la estructura del código sin cambiar su comportamiento externo.',
                        icon: '🔄',
                        hours: 12,
                        category: 'development'
                    },
                    {
                        id: 4,
                        name: 'Diseño de Arquitectura',
                        description: 'Diseño de la arquitectura de software escalable y mantenible para tu proyecto.',
                        icon: '🏗️',
                        hours: 20,
                        category: 'development'
                    },
                    {
                        id: 5,
                        name: 'Integración de API',
                        description: 'Conexión de tu aplicación con servicios externos y APIs de terceros.',
                        icon: '🔌',
                        hours: 10,
                        category: 'development'
                    },
                    {
                        id: 6,
                        name: 'Investigación UX/UI',
                        description: 'Análisis de usuarios y diseño de interfaces optimizadas para experiencia de usuario.',
                        icon: '🎨',
                        hours: 15,
                        category: 'design'
                    },
                    {
                        id: 7,
                        name: 'Consultoría de IA',
                        description: 'Implementación de soluciones de inteligencia artificial y machine learning.',
                        icon: '🧠',
                        hours: 25,
                        category: 'consulting'
                    },
                    {
                        id: 8,
                        name: 'Desarrollo de MVP',
                        description: 'Creación de un Producto Mínimo Viable para validar tu idea de negocio.',
                        icon: '🚀',
                        hours: 40,
                        category: 'development'
                    },
                    {
                        id: 9,
                        name: 'Documentación técnica',
                        description: 'Creación de documentación completa para desarrolladores y usuarios finales.',
                        icon: '📚',
                        hours: 10,
                        category: 'consulting'
                    }
                ],
                
                selectedBlocks: [],
                activeCategory: 'all',
                showContactForm: false,
                showPreview: false,
                showSuccess: false,
                isSubmitting: false,
                
                contactForm: {
                    name: '',
                    email: '',
                    project_description: ''
                },
                
                // Computed
                get filteredBlocks() {
                    if (this.activeCategory === 'all') {
                        return this.blocks;
                    }
                    return this.blocks.filter(block => block.category === this.activeCategory);
                },
                
                get totalBlocks() {
                    return this.selectedBlocks.length;
                },
                
                get totalHours() {
                    return this.selectedBlocks.reduce((sum, block) => {
                        return sum + (block.customHours || block.hours);
                    }, 0);
                },
                
                get totalCost() {
                    return this.totalHours * 500;
                },
                
                // Métodos
                init() {
                    this.setupDragAndDrop();
                    this.loadSavedQuote();
                },
                
                setupDragAndDrop() {
                    const self = this;
                    const selectedBlocksEl = document.getElementById('selected-blocks');
                    
                    if (selectedBlocksEl) {
                        new Sortable(selectedBlocksEl, {
                            animation: 150,
                            ghostClass: 'dragging',
                            onEnd: function(evt) {
                                const oldIndex = evt.oldIndex;
                                const newIndex = evt.newIndex;
                                
                                // Reorganizar el array
                                const [removed] = self.selectedBlocks.splice(oldIndex, 1);
                                self.selectedBlocks.splice(newIndex, 0, removed);
                            }
                        });
                    }
                },
                
                addBlock(block) {
                    // Crear copia del bloque para evitar referencias
                    const newBlock = {
                        ...block,
                        id: Date.now() + Math.random(), // ID único
                        customHours: null
                    };
                    
                    this.selectedBlocks.push(newBlock);
                    
                    // Feedback visual
                    this.showNotification('Bloque agregado: ' + block.name);
                    this.saveQuote();
                },
                
                removeBlock(index) {
                    const blockName = this.selectedBlocks[index].name;
                    this.selectedBlocks.splice(index, 1);
                    this.showNotification('Bloque eliminado: ' + blockName);
                    this.saveQuote();
                },
                
                updateBlockHours(index, hours) {
                    hours = parseInt(hours);
                    if (hours < 1) hours = 1;
                    if (hours > 200) hours = 200;
                    
                    if (hours !== this.selectedBlocks[index].hours) {
                        this.selectedBlocks[index].customHours = hours;
                    } else {
                        this.selectedBlocks[index].customHours = null;
                    }
                    
                    this.saveQuote();
                },
                
                increaseHours(index) {
                    const block = this.selectedBlocks[index];
                    const currentHours = block.customHours || block.hours;
                    if (currentHours < 200) {
                        this.selectedBlocks[index].customHours = currentHours + 1;
                        this.saveQuote();
                    }
                },
                
                decreaseHours(index) {
                    const block = this.selectedBlocks[index];
                    const currentHours = block.customHours || block.hours;
                    if (currentHours > 1) {
                        this.selectedBlocks[index].customHours = currentHours - 1;
                        this.saveQuote();
                    }
                },
                
                moveBlockUp(index) {
                    if (index > 0) {
                        const temp = this.selectedBlocks[index];
                        this.selectedBlocks[index] = this.selectedBlocks[index - 1];
                        this.selectedBlocks[index - 1] = temp;
                        this.saveQuote();
                    }
                },
                
                moveBlockDown(index) {
                    if (index < this.selectedBlocks.length - 1) {
                        const temp = this.selectedBlocks[index];
                        this.selectedBlocks[index] = this.selectedBlocks[index + 1];
                        this.selectedBlocks[index + 1] = temp;
                        this.saveQuote();
                    }
                },
                
                resetQuote() {
                    if (confirm('¿Estás seguro de que quieres reiniciar la cotización? Se perderán todos los cambios.')) {
                        this.selectedBlocks = [];
                        this.contactForm = {
                            name: '',
                            email: '',
                            project_description: ''
                        };
                        localStorage.removeItem('quoteBuilderData');
                        this.showNotification('Cotización reiniciada');
                    }
                },
                
                exportQuote() {
                    const quoteData = {
                        blocks: this.selectedBlocks,
                        totalHours: this.totalHours,
                        totalCost: this.totalCost,
                        date: new Date().toLocaleDateString()
                    };
                    
                    // En una implementación real, esto generaría un PDF
                    // Por ahora mostramos una alerta
                    this.showNotification('Funcionalidad de exportación en desarrollo');
                },
                
                async submitQuote() {
                    if (!this.contactForm.name || !this.contactForm.email) {
                        this.showNotification('Por favor, completa todos los campos obligatorios', 'error');
                        return;
                    }
                    
                    this.isSubmitting = true;
                    
                    try {
                        // Datos a enviar
                        const formData = {
                            ...this.contactForm,
                            blocks: this.selectedBlocks,
                            total_hours: this.totalHours,
                            total_cost: this.totalCost
                        };
                        
                        // En una implementación real, aquí iría la llamada AJAX a Laravel
                        // Simulamos una petición
                        await new Promise(resolve => setTimeout(resolve, 1500));
                        
                        // Mostrar éxito
                        this.showSuccess = true;
                        this.showContactForm = false;
                        this.isSubmitting = false;
                        
                        // Limpiar localStorage
                        localStorage.removeItem('quoteBuilderData');
                        
                    } catch (error) {
                        this.showNotification('Error al enviar la cotización', 'error');
                        this.isSubmitting = false;
                    }
                },
                
                saveQuote() {
                    const data = {
                        selectedBlocks: this.selectedBlocks,
                        contactForm: this.contactForm
                    };
                    localStorage.setItem('quoteBuilderData', JSON.stringify(data));
                },
                
                loadSavedQuote() {
                    const saved = localStorage.getItem('quoteBuilderData');
                    if (saved) {
                        try {
                            const data = JSON.parse(saved);
                            this.selectedBlocks = data.selectedBlocks || [];
                            this.contactForm = data.contactForm || this.contactForm;
                            this.showNotification('Cotización cargada desde tu última sesión');
                        } catch (e) {
                            console.error('Error loading saved quote:', e);
                        }
                    }
                },
                
                showNotification(message, type = 'success') {
                    // Crear notificación
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 glass-card rounded-lg p-4 animate-slide-in-right z-50 ${
                        type === 'error' ? 'border-l-4 border-error' : 'border-l-4 border-success'
                    }`;
                    notification.innerHTML = `
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full ${
                                type === 'error' ? 'bg-error/10' : 'bg-success/10'
                            } flex items-center justify-center">
                                <svg class="w-5 h-5 ${
                                    type === 'error' ? 'text-error' : 'text-success'
                                }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                                        type === 'error' ? 'M6 18L18 6M6 6l12 12' : 'M5 13l4 4L19 7'
                                    }" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">${message}</p>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(notification);
                    
                    // Remover después de 3 segundos
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => notification.remove(), 300);
                    }, 3000);
                }
            }
        }
    </script>
</body>
</html>