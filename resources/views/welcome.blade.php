<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Digital Market Intelligence') }}</title>
    
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Variables CSS actualizadas */
        :root {
            --accent: #374151;
            --accent-light: #4B5563;
            --accent-dark: #1F2937;
            --animation-duration: 0.8s;
            --animation-timing: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth scroll con comportamiento suave */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 5rem;
            overflow-x: hidden;
        }

        /* Ajuste para navbar fija */
        body {
            padding-top: 5rem;
            overflow-x: hidden;
        }

        /* Mejores animaciones CSS */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes borderGlow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(55, 65, 81, 0.3);
            }
            50% {
                box-shadow: 0 0 20px 5px rgba(55, 65, 81, 0.3);
            }
        }

        @keyframes textReveal {
            from {
                clip-path: inset(0 100% 0 0);
            }
            to {
                clip-path: inset(0 0 0 0);
            }
        }

        /* Clases de animación */
        .animate-fade-up {
            animation: fadeUp var(--animation-duration) var(--animation-timing) forwards;
            opacity: 0;
        }

        .animate-slide-left {
            animation: slideInLeft var(--animation-duration) var(--animation-timing) forwards;
            opacity: 0;
        }

        .animate-slide-right {
            animation: slideInRight var(--animation-duration) var(--animation-timing) forwards;
            opacity: 0;
        }

        .animate-scale-in {
            animation: scaleIn var(--animation-duration) var(--animation-timing) forwards;
            opacity: 0;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }

        .animate-glow {
            animation: borderGlow 3s ease-in-out infinite;
        }

        .animate-text-reveal {
            animation: textReveal 1.5s var(--animation-timing) forwards;
            clip-path: inset(0 100% 0 0);
        }

        /* Stagger animations */
        .stagger-child > * {
            opacity: 0;
            animation: fadeUp var(--animation-duration) var(--animation-timing) forwards;
        }

        /* Hover effects mejorados */
        .hover-lift {
            transition: transform 0.3s var(--animation-timing);
        }
        .hover-lift:hover {
            transform: translateY(-8px);
        }

        .hover-glow:hover {
            box-shadow: 0 10px 40px -10px rgba(55, 65, 81, 0.2);
        }

        /* Clases de utilidad personalizadas */
        .text-balance {
            text-wrap: balance;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* Smooth transitions */
        .transition-smooth {
            transition: all 0.4s var(--animation-timing);
        }

        /* Mejoras de accesibilidad */
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-up,
            .animate-slide-left,
            .animate-slide-right,
            .animate-scale-in,
            .animate-float,
            .animate-shimmer,
            .animate-gradient,
            .animate-glow,
            .animate-text-reveal {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                clip-path: none !important;
            }
        }

        /* Efecto parallax para el hero */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Gradiente animado para el hero */
        .hero-gradient {
    background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
    /* Eliminar animación del background */
}
    </style>
</head>

<body class="font-sans antialiased text-gray-700 bg-white">
    <!-- NAVBAR con animaciones mejoradas -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/90 border-b border-gray-200/50 py-4 transition-all duration-300 backdrop-blur-sm">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo con animación -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <img src="/images/DMI-logob.png" alt="DMI Logo" class="h-10 w-auto transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-accent opacity-0 group-hover:opacity-10 rounded-lg transition-opacity duration-300"></div>
                    </div>
                   <!--  <span class="text-xl font-bold text-gray-900 whitespace-nowrap transition-all duration-300 group-hover:text-accent">
                        Digital Market Intelligence
                    </span> -->
                </a>

                <!-- Menú Desktop con efectos hover mejorados -->
                <div class="hidden md:flex items-center gap-8">
                    @foreach([
                        ['href' => '#servicios', 'text' => 'Servicios'],
                        ['href' => '#clientes', 'text' => 'Clientes'],
                        ['href' => '#resultados', 'text' => 'Resultados'],
                        ['href' => '#testimonios', 'text' => 'Testimonios']
                    ] as $item)
                    <a href="{{ $item['href'] }}" 
                       class="text-gray-700 font-medium text-sm hover:text-accent transition-all duration-300 relative group">
                        <span class="relative z-10">{{ $item['text'] }}</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-accent transition-all duration-300 group-hover:w-full"></span>
                        <span class="absolute inset-0 bg-accent/5 rounded-md scale-0 group-hover:scale-100 transition-transform duration-300"></span>
                    </a>
                    @endforeach
                    
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 font-medium text-sm hover:text-accent transition-all duration-300 hover:translate-x-1 flex items-center gap-2">
                        <span>Acceso Clientes</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('quote.builder') }}" 
                       class="bg-gradient-to-r from-accent to-accent-dark text-white px-6 py-2 rounded-md font-medium text-sm hover:shadow-lg hover:scale-105 transition-all duration-300 relative overflow-hidden group">
                        <span class="relative z-10 flex items-center gap-2">
                            Contactar
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </span>
                        <span class="absolute inset-0 bg-gradient-to-r from-accent-light to-accent transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></span>
                    </a>
                </div>

                <!-- Botón Menú Móvil con animación -->
                <button id="mobileMenuButton" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-300" aria-label="Abrir menú">
                    <svg class="w-6 h-6 text-gray-700 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menú Móvil con animación -->
        <div id="mobileMenu" class="md:hidden absolute top-full left-0 right-0 bg-white/95 backdrop-blur-sm border-t border-gray-200/50 shadow-xl transform -translate-y-2 opacity-0 transition-all duration-300 pointer-events-none">
            <div class="container mx-auto px-4 py-4 flex flex-col gap-1">
                @foreach([
                    ['href' => '#servicios', 'text' => 'Servicios', 'icon' => 'M9 5l7 7-7 7'],
                    ['href' => '#clientes', 'text' => 'Clientes', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['href' => '#resultados', 'text' => 'Resultados', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['href' => '#testimonios', 'text' => 'Testimonios', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z']
                ] as $item)
                <a href="{{ $item['href'] }}" 
                   class="text-gray-700 font-medium py-3 px-4 rounded-lg hover:bg-gray-50 hover:text-accent transition-all duration-300 transform hover:translate-x-2 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['text'] }}
                </a>
                @endforeach
                
                <div class="pt-2 mt-2 border-t border-gray-200/50">
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 font-medium py-3 px-4 rounded-lg hover:bg-gray-50 hover:text-accent transition-all duration-300 flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Acceso Clientes
                    </a>
                    <a href="{{ route('quote.builder') }}" 
                       class="bg-gradient-to-r from-accent to-accent-dark text-white px-6 py-3 rounded-lg font-medium hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                        Contactar
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

<section class="min-h-[90vh] flex items-center hero-gradient pt-8 md:pt-16 relative overflow-hidden">
    <!-- Elementos decorativos animados -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-accent/5 rounded-full blur-3xl animate-float" style="animation-delay: 0s;"></div>
        <div class="absolute top-60 -left-20 w-60 h-60 bg-accent/5 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-40 right-1/4 w-40 h-40 bg-accent/5 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <!-- IMAGEN DE FONDO para el área azul -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
        style="background-image: url('/images/jun.jpg');">
        <div class="absolute inset-0 bg-gradient-to-r from-white/70 via-white/50 to-white/40"></div>
    </div>

    <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
        <!-- 🔧 TEXTO MÁS ESTRECHO - AJUSTA AQUÍ -->
        <div class="max-w-xl lg:max-w-3xl"> <!-- 👈 ESTO CONTROLA EL ANCHO DEL TEXTO -->
        
            <!-- Badge con animación de brillo -->
            
            
            <!-- Título -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-black leading-tight mb-6">
                <span class="animate-text-reveal inline-block bg-gradient-to-r from-black to-accent bg-clip-text text-transparent">
                    Transformación digital basada en datos e inteligencia de mercado
                </span>
            </h1>
            
            <!-- Descripción -->
            <p class="text-lg md:text-xl text-black mb-10 animate-fade-up" style="animation-delay: 0.2s;">
                Desarrollamos soluciones tecnológicas personalizadas que impulsan el crecimiento empresarial. 
                Combinamos análisis de datos, desarrollo ágil y estrategias digitales para resultados medibles.
            </p>
            
            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-4 animate-fade-up" style="animation-delay: 0.4s;">
                <a href="{{ route('quote.builder') }}" 
                class="group bg-gradient-to-r from-accent to-accent-dark text-white px-10 py-5 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center gap-3 text-center relative overflow-hidden">
                    <span class="relative z-10 text-base">Iniciar Proyecto</span>
                    <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    <div class="absolute inset-0 bg-gradient-to-r from-accent-light to-accent transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                </a>
                
                <a href="#servicios" 
                class="group bg-white/80 backdrop-blur-sm border-2 border-gray-300 text-gray-700 px-10 py-5 rounded-lg font-semibold shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 flex items-center justify-center gap-3 text-center hover:border-accent hover:text-accent">
                    <span class="text-base">Ver Soluciones</span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>


    <!-- SERVICIOS con animaciones escalonadas -->
    <section id="servicios" class="py-16 md:py-24 bg-white relative overflow-hidden">
        <!-- Fondo decorativo -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-50/50 to-transparent"></div>
        
        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <!-- Header con animación -->
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
                <div class="inline-flex items-center gap-2 text-accent font-semibold tracking-wider text-sm uppercase mb-4 animate-slide-left">
                    <span class="w-8 h-0.5 bg-accent"></span>
                    Soluciones Especializadas
                    <span class="w-8 h-0.5 bg-accent"></span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 animate-fade-up">
                    Desarrollo de Software a Medida
                </h2>
                <p class="text-lg text-gray-600 animate-fade-up" style="animation-delay: 0.1s;">
                    Creamos soluciones tecnológicas que resuelven problemas específicos de negocio, 
                    optimizando procesos y maximizando la productividad.
                </p>
            </div>

            <!-- Grid de Servicios con animación escalonada -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto stagger-child">
               <!-- Servicio 1: Aplicaciones Empresariales -->
            <div class="hover-lift bg-white border border-gray-200 rounded-xl p-8 hover-glow transition-smooth group relative overflow-hidden" role="article" aria-labelledby="servicio1-title">
                <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/10 to-accent/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-accent group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 id="servicio1-title" class="text-xl font-bold text-gray-900 mb-4 group-hover:text-accent transition-colors duration-300">
                        Aplicaciones Empresariales
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Sistemas CRM, ERP y gestión interna desarrollados con las mejores prácticas de desarrollo y seguridad empresarial.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">CRM personalizado (gestión de clientes)</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">ERP modular (gestión integral)</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Sistemas de gestión interna</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-accent font-medium mt-3 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Cumplimiento de normas de seguridad</span>
                        </div>
                    </div>
                    <a href="#contacto" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark mt-6 group/link transition-colors duration-300">
                        <span>Solicitar demostración</span>
                        <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Servicio 2: Plataformas Web -->
            <div class="hover-lift bg-white border border-gray-200 rounded-xl p-8 hover-glow transition-smooth group relative overflow-hidden" role="article" aria-labelledby="servicio2-title">
                <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/10 to-accent/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-accent group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 id="servicio2-title" class="text-xl font-bold text-gray-900 mb-4 group-hover:text-accent transition-colors duration-300">
                        Plataformas Web
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Desarrollo de aplicaciones web escalables con arquitecturas modernas, tecnologías de vanguardia y alto rendimiento.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Aplicaciones SPA/MPA de alto rendimiento</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Plataformas E-commerce y Marketplaces</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Sistemas de gestión de contenido</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-accent font-medium mt-3 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                            <span>Arquitecturas escalables (microservicios)</span>
                        </div>
                    </div>
                    <a href="#contacto" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark mt-6 group/link transition-colors duration-300">
                        <span>Ver casos de éxito</span>
                        <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Servicio 3: Integración de Sistemas -->
            <div class="hover-lift bg-white border border-gray-200 rounded-xl p-8 hover-glow transition-smooth group relative overflow-hidden" role="article" aria-labelledby="servicio3-title">
                <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/10 to-accent/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-accent group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 id="servicio3-title" class="text-xl font-bold text-gray-900 mb-4 group-hover:text-accent transition-colors duration-300">
                        Integración de Sistemas
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Conexión segura entre aplicaciones existentes y nuevas soluciones, garantizando flujos de datos óptimos y automatizados.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-700">APIs REST/GraphQL personalizadas</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-700">Middlewares y conectores empresariales</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-700">Migración y sincronización de datos</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-accent font-medium mt-3 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Automatización de procesos (RPA)</span>
                        </div>
                    </div>
                    <a href="#contacto" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark mt-6 group/link transition-colors duration-300">
                        <span>Consultar integraciones</span>
                        <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
                <!-- Servicio 4: Cursos Personalizados -->
            <div class="hover-lift bg-white border border-gray-200 rounded-xl p-8 hover-glow transition-smooth group relative overflow-hidden" role="article" aria-labelledby="servicio4-title">
                <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/10 to-accent/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-accent group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <h3 id="servicio4-title" class="text-xl font-bold text-gray-900 mb-4 group-hover:text-accent transition-colors duration-300">
                        Cursos Personalizados
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Capacitación especializada para equipos de trabajo. Mínimo 10 personas. Modalidad en línea o presencial en nuestras instalaciones.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Ofimática avanzada (Word, Excel, PowerPoint)</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Mantenimiento de Hardware/Software</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Ciberseguridad básica para equipos</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-accent font-medium mt-3 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Certificación incluida | Flexibilidad horaria</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <a href="#contacto" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark group/link transition-colors duration-300">
                            <span>Solicitar programa</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <span class="text-xs font-medium px-3 py-1 bg-green-50 text-green-700 rounded-full">
                            Desde 10 personas
                        </span>
                    </div>
                </div>
            </div>

            <!-- Servicio 5: Mantenimiento Tecnológico -->
            <div class="hover-lift bg-white border border-gray-200 rounded-xl p-8 hover-glow transition-smooth group relative overflow-hidden" role="article" aria-labelledby="servicio5-title">
                <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/10 to-accent/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-accent group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 id="servicio5-title" class="text-xl font-bold text-gray-900 mb-4 group-hover:text-accent transition-colors duration-300">
                        Mantenimiento Tecnológico
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Servicio preventivo y correctivo para mantener tu infraestructura tecnológica operando al 100% con mínimas interrupciones.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Mantenimiento Preventivo programado</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Mantenimiento Correctivo 24/7</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">Soporte Técnico Remoto prioritario</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-accent font-medium mt-3 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Respuesta en menos de 2 horas</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <a href="#contacto" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark group/link transition-colors duration-300">
                            <span>Consultar planes</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <span class="text-xs font-medium px-3 py-1 bg-blue-50 text-blue-700 rounded-full">
                            Soporte 24/7
                        </span>
                    </div>
                </div>
            </div>

            <!-- Servicio 6: Consultoría IT -->
            <div class="hover-lift bg-white border border-gray-200 rounded-xl p-8 hover-glow transition-smooth group relative overflow-hidden" role="article" aria-labelledby="servicio6-title">
                <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/10 to-accent/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-accent group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 id="servicio6-title" class="text-xl font-bold text-gray-900 mb-4 group-hover:text-accent transition-colors duration-300">
                        Consultoría IT
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Asesoramiento especializado para optimizar tu infraestructura tecnológica, procesos digitales y maximizar ROI tecnológico.
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-700">Auditoría Tecnológica integral</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-700">Estrategia Digital y Transformación</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-700">Plan de Migración y Modernización</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-accent font-medium mt-3 pt-3 border-t border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Reporte detallado con roadmap</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <a href="#contacto" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-dark group/link transition-colors duration-300">
                            <span>Agendar diagnóstico</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- CLIENTES con animación de aparición -->
    <section id="clientes" class="py-16 md:py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
        <!-- Elemento decorativo -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-accent/20 to-transparent"></div>
        
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 text-accent font-semibold tracking-wider text-sm uppercase mb-4 animate-slide-right">
                    <span class="w-8 h-0.5 bg-accent"></span>
                    Confianza Empresarial
                    <span class="w-8 h-0.5 bg-accent"></span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 animate-fade-up">
                    Empresas que Confían en Nosotros
                </h2>
                <p class="text-lg text-gray-600 animate-fade-up" style="animation-delay: 0.1s;">
                    Colaboramos con organizaciones líderes que buscan innovación tecnológica y soluciones robustas.
                </p>
            </div>

            <!-- Grid de Clientes con animación de escala -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 max-w-5xl mx-auto">
                @foreach(['TESI', 'Gisena', 'TESCHA', 'AMCID', 'EVOBIKE'] as $client)
                <div class="bg-white border border-gray-200 rounded-xl p-6 flex items-center justify-center hover-lift hover-glow transition-smooth group animate-scale-in" >
                    <img 
                        src="/images/empresas/{{ $client }}.png" 
                        alt="{{ $client }}" 
                        class="h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-br from-accent/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- MÉTRICAS con animación de conteo -->
    <section id="resultados" class="py-16 md:py-24 bg-gradient-to-br from-gray-900 to-accent-dark text-white relative overflow-hidden">
        <!-- Elementos decorativos animados -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/5 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 animate-slide-left">
                    Resultados Comprobados
                </h2>
                <p class="text-lg text-gray-300 animate-slide-right">
                    Impacto tangible en el crecimiento y eficiencia de nuestros clientes
                </p>
            </div>

            <!-- Grid de Métricas con animación de conteo -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <!-- Métrica 1 -->
                <div class="text-center animate-scale-in" style="animation-delay: 0s">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="75" data-suffix="%">
                        0%
                    </div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Satisfacción Cliente</div>
                </div>

                <!-- Métrica 2 -->
                <div class="text-center animate-scale-in" style="animation-delay: 0.2s">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="40" data-suffix="%">
                        0%
                    </div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Eficiencia Operativa</div>
                </div>

                <!-- Métrica 3 -->
                <div class="text-center animate-scale-in" style="animation-delay: 0.4s">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="132" data-suffix="+">
                        0+
                    </div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Proyectos Entregados</div>
                </div>

                <!-- Métrica 4 -->
                <div class="text-center animate-scale-in" style="animation-delay: 0.6s">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-2" data-count="100" data-suffix="%">
                        0%
                    </div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Cumplimiento de Plazos</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIOS con animación de flip -->
    <section id="testimonios" class="py-16 md:py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 text-accent font-semibold tracking-wider text-sm uppercase mb-4 animate-slide-left">
                    <span class="w-8 h-0.5 bg-accent"></span>
                    Testimonios
                    <span class="w-8 h-0.5 bg-accent"></span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 animate-fade-up">
                    Lo que Dicen Nuestros Clientes
                </h2>
                <p class="text-lg text-gray-600 animate-fade-up" style="animation-delay: 0.1s;">
                    Experiencias reales de empresas que han transformado sus operaciones con nuestras soluciones
                </p>
            </div>

            <!-- Grid de Testimonios con animación 3D -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto stagger-child">
                <!-- Testimonio 1 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 hover-lift hover-glow transition-smooth group animate-scale-in" style="animation-delay: 0s">
                    <div class="relative mb-6">
                        <div class="text-6xl text-gray-200 absolute -top-4 -left-2">"</div>
                        <p class="text-gray-600 italic relative z-10 group-hover:text-gray-800 transition-colors duration-300">
                            El equipo de desarrollo entregó una solución que superó nuestras expectativas. 
                            La plataforma ha optimizado nuestros procesos en un 60%.
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="group-hover:translate-x-2 transition-transform duration-300">
                            <h4 class="font-bold text-gray-900">Carlos Mendoza</h4>
                            <p class="text-sm text-gray-500">Director TI - TESI</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonio 2 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 hover-lift hover-glow transition-smooth group animate-scale-in" style="animation-delay: 0.2s">
                    <div class="relative mb-6">
                        <div class="text-6xl text-gray-200 absolute -top-4 -left-2">"</div>
                        <p class="text-gray-600 italic relative z-10 group-hover:text-gray-800 transition-colors duration-300">
                            Profesionalismo y calidad técnica excepcional. El sistema desarrollado 
                            se integra perfectamente con nuestra infraestructura existente.
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="group-hover:translate-x-2 transition-transform duration-300">
                            <h4 class="font-bold text-gray-900">Ana Rodríguez</h4>
                            <p class="text-sm text-gray-500">Gerente de Operaciones - Gisena</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonio 3 -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 hover-lift hover-glow transition-smooth group animate-scale-in" style="animation-delay: 0.4s">
                    <div class="relative mb-6">
                        <div class="text-6xl text-gray-200 absolute -top-4 -left-2">"</div>
                        <p class="text-gray-600 italic relative z-10 group-hover:text-gray-800 transition-colors duration-300">
                            Implementación impecable y soporte continuo. Han sido un partner tecnológico 
                            confiable para nuestro crecimiento digital.
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="group-hover:translate-x-2 transition-transform duration-300">
                            <h4 class="font-bold text-gray-900">Miguel Torres</h4>
                            <p class="text-sm text-gray-500">CEO - EVOBIKE</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA con animación de pulso -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
        <!-- Elemento decorativo -->
        <div class="absolute inset-0 bg-gradient-to-r from-accent/5 via-transparent to-accent/5 animate-gradient"></div>
        
        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 animate-fade-up">
                    ¿Listo para Transformar Tu Negocio?
                </h2>
                <p class="text-lg text-gray-600 mb-10 animate-fade-up" style="animation-delay: 0.1s;">
                    Agenda una consulta técnica gratuita y descubre cómo podemos desarrollar la solución perfecta para sus necesidades.
                </p>
                <a href="{{ route('quote.builder') }}" 
                   class="inline-block bg-gradient-to-r from-accent to-accent-dark text-white px-8 py-4 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-glow relative overflow-hidden group">
                    <span class="relative z-10">Solicitar Consulta Técnica</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-accent-light to-accent transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></div>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER con animaciones sutiles -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <!-- Grid Footer -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <!-- Columna 1 -->
                <div>
                    <!-- <h3 class="text-lg font-bold mb-6 animate-slide-left">Digital Market Intelligence</h3> -->
                    <p class="text-gray-400 text-sm leading-relaxed animate-fade-up" style="animation-delay: 0.1s">
                        Desarrollo de software empresarial y consultoría tecnológica especializada.
                    </p>
                </div>

                <!-- Columna 2 -->
                <div>
                    <h3 class="text-lg font-bold mb-6 animate-slide-left" style="animation-delay: 0.2s">Servicios</h3>
                    <ul class="space-y-3">
                        <li><a href="#servicios" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:translate-x-1 inline-block">Aplicaciones Empresariales</a></li>
                        <li><a href="#servicios" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:translate-x-1 inline-block">Plataformas Web</a></li>
                        <li><a href="#servicios" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:translate-x-1 inline-block">Integración de Sistemas</a></li>
                    </ul>
                </div>

                <!-- Columna 3 -->
                <div>
                    <h3 class="text-lg font-bold mb-6 animate-slide-left" style="animation-delay: 0.3s">Contacto</h3>
                    <div class="text-gray-400 text-sm space-y-2">
                        <p class="hover:text-white transition-colors duration-300 cursor-default">contacto@dmi.mx</p>
                        <p class="hover:text-white transition-colors duration-300 cursor-default">+52 55 1234 5678</p>
                        <p class="hover:text-white transition-colors duration-300 cursor-default">Ciudad de México</p>
                    </div>
                </div>

                <!-- Columna 4 -->
                <div>
                    <h3 class="text-lg font-bold mb-6 animate-slide-left" style="animation-delay: 0.4s">Recursos</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:translate-x-1 inline-block">Blog Técnico</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:translate-x-1 inline-block">Casos de Estudio</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:translate-x-1 inline-block">Documentación</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-gray-500 text-sm text-center md:text-left animate-fade-up">
                    © {{ date('Y') }} Digital Market Intelligence. Todos los derechos reservados.
                </div>
                <div class="flex gap-6 animate-fade-up" style="animation-delay: 0.1s">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:scale-110">LinkedIn</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:scale-110">GitHub</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:scale-110">Twitter</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript mejorado -->
    <script>
        // Navbar scroll effect mejorado
        const navbar = document.getElementById('navbar');
        let lastScroll = 0;
        let ticking = false;

        const updateNavbar = () => {
            const currentScroll = window.pageYOffset;
            
            // Añadir efectos al hacer scroll
            if (currentScroll > 50) {
                navbar.classList.add('shadow-lg', 'bg-white/95', 'backdrop-blur-sm');
                navbar.style.backdropFilter = 'blur(8px)';
            } else {
                navbar.classList.remove('shadow-lg', 'bg-white/95', 'backdrop-blur-sm');
                navbar.style.backdropFilter = 'none';
            }
            
            // Animación de hide/show con suavidad
            if (window.innerWidth < 768 && currentScroll > 100) {
                if (currentScroll > lastScroll) {
                    navbar.style.transform = 'translateY(-100%)';
                    navbar.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                    navbar.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                }
            }
            
            lastScroll = currentScroll;
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        });

        // Mobile menu toggle mejorado
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        const toggleMobileMenu = () => {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            const svg = mobileMenuButton.querySelector('svg');
            
            if (!isExpanded) {
                // Abrir menú
                mobileMenuButton.setAttribute('aria-expanded', 'true');
                mobileMenu.classList.remove('pointer-events-none');
                mobileMenu.style.transform = 'translateY(0)';
                mobileMenu.style.opacity = '1';
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
                
                // Animar elementos del menú
                const menuItems = mobileMenu.querySelectorAll('a');
                menuItems.forEach((item, index) => {
                    item.style.transitionDelay = `${index * 50}ms`;
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                });
            } else {
                // Cerrar menú
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenu.style.transform = 'translateY(-10px)';
                mobileMenu.style.opacity = '0';
                setTimeout(() => {
                    mobileMenu.classList.add('pointer-events-none');
                }, 300);
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        };

        mobileMenuButton.addEventListener('click', toggleMobileMenu);

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                if (mobileMenuButton.getAttribute('aria-expanded') === 'true') {
                    toggleMobileMenu();
                }
            }
        });

        // Cerrar menú al hacer clic en enlace
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (mobileMenuButton.getAttribute('aria-expanded') === 'true') {
                    toggleMobileMenu();
                }
            });
        });

        // Intersection Observer mejorado
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    
                    // Para elementos con animación escalonada
                    if (entry.target.classList.contains('stagger-child')) {
                        const children = entry.target.children;
                        Array.from(children).forEach((child, index) => {
                            child.style.animationDelay = `${index * 100}ms`;
                            child.style.animationPlayState = 'running';
                        });
                    }
                }
            });
        }, observerOptions);

        // Observar todos los elementos animados
        document.querySelectorAll('.animate-fade-up, .animate-slide-left, .animate-slide-right, .animate-scale-in, .stagger-child').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });

        // Contador animado para métricas
        const animateCounters = () => {
            const counters = document.querySelectorAll('[data-count]');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const suffix = counter.getAttribute('data-suffix') || '';
                const duration = 1500; // ms
                const step = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current) + suffix;
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target + suffix;
                    }
                };
                
                updateCounter();
            });
        };

        // Observar sección de métricas para iniciar conteo
        const metricsSection = document.getElementById('resultados');
        const metricsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(animateCounters, 300); // Retraso para sincronizar con animación
                }
            });
        }, { threshold: 0.5 });

        if (metricsSection) {
            metricsObserver.observe(metricsSection);
        }

        // Smooth scroll mejorado con easing
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offset = 80;
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
                        
                        window.scrollTo({
                            top: targetPosition - offset,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Efecto parallax para elementos de fondo
        const parallaxElements = document.querySelectorAll('.parallax-bg');
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            parallaxElements.forEach(element => {
                const rate = element.getAttribute('data-rate') || 0.5;
                element.style.transform = `translateY(${scrolled * rate}px)`;
            });
        });

        // Inicializar animaciones al cargar
        document.addEventListener('DOMContentLoaded', () => {
            // Añadir delays escalonados a los elementos del menú móvil
            const mobileMenuItems = mobileMenu.querySelectorAll('a');
            mobileMenuItems.forEach((item, index) => {
                item.style.transitionDelay = `${index * 50}ms`;
                item.style.opacity = '0';
                item.style.transform = 'translateX(-10px)';
            });

            // Animación inicial para el hero
            const heroTitle = document.querySelector('.hero-gradient h1');
            if (heroTitle) {
                heroTitle.style.animationDelay = '0s';
            }
        });

        // Prevenir animaciones durante el resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            document.body.classList.add('resize-animation-stopper');
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                document.body.classList.remove('resize-animation-stopper');
            }, 400);
        });
    </script>

    <style>
        .resize-animation-stopper * {
            animation: none !important;
            transition: none !important;
        }
    </style>
</body>
</html>