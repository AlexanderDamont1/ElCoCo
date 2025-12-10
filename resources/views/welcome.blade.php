<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Digital Market Intelligence') }}</title>
    
    <!-- Fuente especificada -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* PALETA DE CONSULTORÍA PROFESIONAL */
        :root {
            /* Colores neutros y elegantes */
            --black: #000000;
            --gray-900: #111827;
            --gray-800: #1F2937;
            --gray-700: #374151;
            --gray-600: #4B5563;
            --gray-500: #6B7280;
            --gray-400: #9CA3AF;
            --gray-300: #D1D5DB;
            --gray-200: #E5E7EB;
            --gray-100: #F3F4F6;
            --gray-50: #F9FAFB;
            --white: #FFFFFF;
            
            /* Acento profesional (gris oscuro como acento) */
            --accent: #374151;
            --accent-light: #4B5563;
            --accent-dark: #1F2937;
            
            /* Tipografía uniforme */
            --font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            
            /* Espaciado consistente */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
            --space-24: 6rem;
            
            /* Breakpoints claros */
            --screen-sm: 640px;
            --screen-md: 768px;
            --screen-lg: 1024px;
            --screen-xl: 1280px;
            --screen-2xl: 1536px;
        }

        /* RESET CONSISTENTE */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: var(--font-family);
            font-weight: 400;
            line-height: 1.6;
            color: var(--gray-700);
            background-color: var(--white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            width: 100%;
        }

        /* TIPOGRAFÍA RESPONSIVA */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-family);
            font-weight: 600;
            line-height: 1.2;
            color: var(--gray-900);
            margin-bottom: var(--space-4);
        }

        h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        h2 {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 600;
        }

        h3 {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 600;
        }

        p {
            font-size: clamp(1rem, 2vw, 1.125rem);
            line-height: 1.7;
            margin-bottom: var(--space-4);
        }

        .text-lead {
            font-size: clamp(1.125rem, 2.5vw, 1.25rem);
            font-weight: 400;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .text-caption {
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--accent);
            display: inline-block;
            margin-bottom: var(--space-4);
        }

        /* CONTENEDORES RESPONSIVOS */
        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 var(--space-4);
        }

        @media (min-width: 640px) {
            .container {
                padding: 0 var(--space-6);
            }
        }

        @media (min-width: 1024px) {
            .container {
                padding: 0 var(--space-8);
            }
        }

        /* NAVBAR PROFESIONAL Y RESPONSIVE */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: var(--space-4) 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            text-decoration: none;
        }

        .navbar-logo {
            height: 2.5rem;
            width: auto;
        }

        .brand-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            white-space: nowrap;
        }

        /* Menú desktop */
        .navbar-menu {
            display: none;
            align-items: center;
            gap: var(--space-8);
        }

        @media (min-width: 768px) {
            .navbar-menu {
                display: flex;
            }
        }

        .nav-link {
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.95rem;
            padding: var(--space-2) 0;
            position: relative;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--accent);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-button {
            padding: 0.625rem 1.5rem;
            background: var(--accent);
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .nav-button:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
        }

        /* Menú móvil */
        .mobile-menu-button {
            display: block;
            background: none;
            border: none;
            cursor: pointer;
            padding: var(--space-2);
        }

        @media (min-width: 768px) {
            .mobile-menu-button {
                display: none;
            }
        }

        .mobile-menu {
            position: fixed;
            top: 73px; /* Altura del navbar */
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: var(--space-4);
            display: none;
            flex-direction: column;
            gap: var(--space-4);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.active {
            display: flex;
        }

        .mobile-nav-link {
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 500;
            padding: var(--space-3) 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .mobile-nav-link:last-child {
            border-bottom: none;
        }

        /* HERO SECTION - PERFECTAMENTE RESPONSIVE */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: calc(var(--space-24) + 1rem) var(--space-4) var(--space-16);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
        }

        @media (min-width: 768px) {
            .hero {
                padding: var(--space-24) var(--space-6) var(--space-16);
            }
        }

        .hero-content {
            width: 100%;
            max-width: 48rem;
        }

        .hero-badge {
            display: inline-block;
            padding: var(--space-2) var(--space-4);
            background: var(--gray-100);
            color: var(--accent);
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-radius: 9999px;
            margin-bottom: var(--space-6);
        }

        .hero-title {
            margin-bottom: var(--space-6);
            line-height: 1.1;
        }

        .hero-description {
            font-size: clamp(1.125rem, 2.5vw, 1.25rem);
            color: var(--gray-600);
            margin-bottom: var(--space-8);
            max-width: 40rem;
        }

        .hero-actions {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        @media (min-width: 640px) {
            .hero-actions {
                flex-direction: row;
                flex-wrap: wrap;
            }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            font-family: var(--font-family);
            font-weight: 500;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
            gap: var(--space-3);
            text-align: center;
            width: 100%;
        }

        @media (min-width: 640px) {
            .btn {
                width: auto;
            }
        }

        .btn-primary {
            background: var(--accent);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--gray-700);
            border-color: var(--gray-300);
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-1px);
        }

        /* SECCIÓN DE SERVICIOS */
        .section {
            padding: var(--space-16) var(--space-4);
        }

        @media (min-width: 768px) {
            .section {
                padding: var(--space-20) var(--space-6);
            }
        }

        @media (min-width: 1024px) {
            .section {
                padding: var(--space-24) var(--space-8);
            }
        }

        .section-header {
            text-align: center;
            max-width: 48rem;
            margin: 0 auto var(--space-12);
        }

        .services-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-8);
            max-width: 72rem;
            margin: 0 auto;
        }

        @media (min-width: 640px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .service-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            padding: var(--space-6);
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--accent);
        }

        .service-icon {
            width: 3rem;
            height: 3rem;
            background: var(--gray-100);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
        }

        .service-icon svg {
            width: 1.5rem;
            height: 1.5rem;
            color: var(--accent);
        }

        /* SECCIÓN DE CLIENTES */
        .clients {
            background: var(--gray-50);
        }

        .clients-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-8);
            align-items: center;
            max-width: 72rem;
            margin: 0 auto;
        }

        @media (min-width: 640px) {
            .clients-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .clients-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        .client-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .client-logo:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .client-logo img {
            max-height: 2.5rem;
            width: auto;
            object-fit: contain;
        }

        /* SECCIÓN DE MÉTRICAS */
        .metrics {
            background: var(--gray-900);
            color: var(--white);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-8);
            text-align: center;
        }

        @media (min-width: 768px) {
            .metrics-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .metric-item {
            padding: var(--space-4);
        }

        .metric-value {
            font-size: clamp(2rem, 5vw, 2.5rem);
            font-weight: 700;
            color: var(--white);
            margin-bottom: var(--space-2);
        }

        .metric-label {
            font-size: 0.875rem;
            color: var(--gray-300);
        }

        /* TESTIMONIOS */
        .testimonials-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-8);
            max-width: 72rem;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .testimonials-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .testimonials-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .testimonial-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            padding: var(--space-6);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .testimonial-text {
            font-style: italic;
            color: var(--gray-600);
            margin-bottom: var(--space-4);
            position: relative;
            padding-left: var(--space-4);
        }

        .testimonial-text::before {
            content: '"';
            position: absolute;
            left: 0;
            top: -0.5rem;
            font-size: 2rem;
            color: var(--gray-300);
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .author-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--gray-200);
            border-radius: 9999px;
        }

        .author-info h4 {
            font-size: 0.875rem;
            margin-bottom: 0.125rem;
        }

        .author-info p {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin: 0;
        }

        /* CTA SECTION */
        .cta {
            background: var(--gray-100);
            text-align: center;
        }

        .cta-content {
            max-width: 48rem;
            margin: 0 auto;
        }

        .cta-title {
            margin-bottom: var(--space-4);
        }

        .cta-description {
            color: var(--gray-600);
            margin-bottom: var(--space-8);
        }

        /* FOOTER */
        .footer {
            background: var(--gray-900);
            color: var(--white);
            padding: var(--space-12) var(--space-4);
        }

        @media (min-width: 768px) {
            .footer {
                padding: var(--space-16) var(--space-6);
            }
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-8);
            max-width: 72rem;
            margin: 0 auto var(--space-8);
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-column h3 {
            color: var(--white);
            font-size: 1rem;
            margin-bottom: var(--space-4);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: var(--space-2);
        }

        .footer-links a {
            color: var(--gray-400);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .contact-info {
            color: var(--gray-400);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .footer-bottom {
            max-width: 72rem;
            margin: 0 auto;
            padding-top: var(--space-8);
            border-top: 1px solid var(--gray-800);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-4);
            text-align: center;
        }

        @media (min-width: 640px) {
            .footer-bottom {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                text-align: left;
            }
        }

        .copyright {
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        .footer-social {
            display: flex;
            gap: var(--space-4);
        }

        .social-link {
            color: var(--gray-400);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .social-link:hover {
            color: var(--white);
        }

        /* UTILIDADES RESPONSIVAS */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* ANIMACIONES SUTILES */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="container navbar-container">
            <a href="/" class="navbar-brand">
                <img src="/images/DMI-logob.png" alt="DMI Logo" class="navbar-logo">
                <span class="brand-name">Digital Market Intelligence</span>
            </a>

            <!-- Menú Desktop -->
            <div class="navbar-menu">
                <a href="#servicios" class="nav-link">Servicios</a>
                <a href="#clientes" class="nav-link">Clientes</a>
                <a href="#resultados" class="nav-link">Resultados</a>
                <a href="#testimonios" class="nav-link">Testimonios</a>
                <a href="{{ route('login') }}" class="nav-link">Acceso Clientes</a>
                <a href="{{ route('quote.builder') }}" class="nav-button">Contactar</a>
            </div>

            <!-- Botón Menú Móvil -->
            <button class="mobile-menu-button" id="mobileMenuButton" aria-label="Abrir menú">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Menú Móvil -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="#servicios" class="mobile-nav-link">Servicios</a>
            <a href="#clientes" class="mobile-nav-link">Clientes</a>
            <a href="#resultados" class="mobile-nav-link">Resultados</a>
            <a href="#testimonios" class="mobile-nav-link">Testimonios</a>
            <a href="{{ route('login') }}" class="mobile-nav-link">Acceso Clientes</a>
            <a href="{{ route('quote.builder') }}" class="mobile-nav-link">Contactar</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge fade-up">Consultoría Especializada</span>
                <h1 class="hero-title fade-up delay-100">
                    Transformación digital basada en datos e inteligencia de mercado
                </h1>
                <p class="hero-description fade-up delay-200">
                    Desarrollamos soluciones tecnológicas personalizadas que impulsan el crecimiento empresarial. 
                    Combinamos análisis de datos, desarrollo ágil y estrategias digitales para resultados medibles.
                </p>
                <div class="hero-actions fade-up delay-300">
                    <a href="{{ route('quote.builder') }}" class="btn btn-primary">
                        Iniciar Proyecto
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#servicios" class="btn btn-secondary">
                        Ver Soluciones
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICIOS -->
    <section class="section" id="servicios">
        <div class="container">
            <div class="section-header">
                <span class="text-caption">Soluciones Especializadas</span>
                <h2>Desarrollo de Software a Medida</h2>
                <p class="text-lead">
                    Creamos soluciones tecnológicas que resuelven problemas específicos de negocio, 
                    optimizando procesos y maximizando la productividad.
                </p>
            </div>
            
            <div class="services-grid">
                <div class="service-card fade-up">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3>Aplicaciones Empresariales</h3>
                    <p>Sistemas CRM, ERP y gestión interna desarrollados con las mejores prácticas de desarrollo y seguridad empresarial.</p>
                </div>
                
                <div class="service-card fade-up delay-100">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3>Plataformas Web</h3>
                    <p>Desarrollo de aplicaciones web escalables con arquitecturas modernas y tecnologías de vanguardia.</p>
                </div>
                
                <div class="service-card fade-up delay-200">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3>Integración de Sistemas</h3>
                    <p>Conexión segura entre aplicaciones existentes y nuevas soluciones, garantizando flujos de datos óptimos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CLIENTES -->
    <section class="section clients" id="clientes">
        <div class="container">
            <div class="section-header">
                <span class="text-caption">Confianza Empresarial</span>
                <h2>Empresas que Confían en Nosotros</h2>
                <p class="text-lead">
                    Colaboramos con organizaciones líderes que buscan innovación tecnológica y soluciones robustas.
                </p>
            </div>
            
            <div class="clients-grid">
                <div class="client-logo fade-up">
                    <img src="/images/empresas/TESI.png" alt="TESI">
                </div>
                <div class="client-logo fade-up delay-100">
                    <img src="/images/empresas/Gisena.png" alt="Gisena">
                </div>
                <div class="client-logo fade-up delay-200">
                    <img src="/images/empresas/TESCHA.png" alt="TESCHA">
                </div>
                <div class="client-logo fade-up delay-300">
                    <img src="/images/empresas/AMCID.png" alt="AMCID">
                </div>
                <div class="client-logo fade-up">
                    <img src="/images/empresas/EVOBIKE.png" alt="EVOBIKE">
                </div>
            </div>
        </div>
    </section>

    <!-- MÉTRICAS -->
    <section class="section metrics" id="resultados">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--white);">Resultados Comprobados</h2>
                <p class="text-lead" style="color: var(--gray-300);">
                    Impacto tangible en el crecimiento y eficiencia de nuestros clientes
                </p>
            </div>
            
            <div class="metrics-grid">
                <div class="metric-item fade-up">
                    <div class="metric-value">+95%</div>
                    <div class="metric-label">Satisfacción Cliente</div>
                </div>
                <div class="metric-item fade-up delay-100">
                    <div class="metric-value">+40%</div>
                    <div class="metric-label">Eficiencia Operativa</div>
                </div>
                <div class="metric-item fade-up delay-200">
                    <div class="metric-value">150+</div>
                    <div class="metric-label">Proyectos Entregados</div>
                </div>
                <div class="metric-item fade-up delay-300">
                    <div class="metric-value">100%</div>
                    <div class="metric-label">Cumplimiento de Plazos</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIOS -->
    <section class="section" id="testimonios">
        <div class="container">
            <div class="section-header">
                <span class="text-caption">Testimonios</span>
                <h2>Lo que Dicen Nuestros Clientes</h2>
                <p class="text-lead">
                    Experiencias reales de empresas que han transformado sus operaciones con nuestras soluciones
                </p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card fade-up">
                    <p class="testimonial-text">
                        El equipo de desarrollo entregó una solución que superó nuestras expectativas. 
                        La plataforma ha optimizado nuestros procesos en un 60%.
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar"></div>
                        <div class="author-info">
                            <h4>Carlos Mendoza</h4>
                            <p>Director TI - TESI</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card fade-up delay-100">
                    <p class="testimonial-text">
                        Profesionalismo y calidad técnica excepcional. El sistema desarrollado 
                        se integra perfectamente con nuestra infraestructura existente.
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar"></div>
                        <div class="author-info">
                            <h4>Ana Rodríguez</h4>
                            <p>Gerente de Operaciones - Gisena</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card fade-up delay-200">
                    <p class="testimonial-text">
                        Implementación impecable y soporte continuo. Han sido un partner tecnológico 
                        confiable para nuestro crecimiento digital.
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar"></div>
                        <div class="author-info">
                            <h4>Miguel Torres</h4>
                            <p>CEO - EVOBIKE</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">¿Listo para Transformar su Negocio?</h2>
                <p class="cta-description">
                    Agenda una consulta técnica gratuita y descubre cómo podemos desarrollar la solución perfecta para sus necesidades.
                </p>
                <a href="{{ route('quote.builder') }}" class="btn btn-primary">
                    Solicitar Consulta Técnica
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>Digital Market Intelligence</h3>
                    <div class="contact-info">
                        <p>Desarrollo de software empresarial y consultoría tecnológica especializada.</p>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Servicios</h3>
                    <ul class="footer-links">
                        <li><a href="#servicios">Aplicaciones Empresariales</a></li>
                        <li><a href="#servicios">Plataformas Web</a></li>
                        <li><a href="#servicios">Integración de Sistemas</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <div class="contact-info">
                        <p>contacto@dmi.mx</p>
                        <p>+52 55 1234 5678</p>
                        <p>Ciudad de México</p>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Recursos</h3>
                    <ul class="footer-links">
                        <li><a href="#">Blog Técnico</a></li>
                        <li><a href="#">Casos de Estudio</a></li>
                        <li><a href="#">Documentación</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">
                    © {{ date('Y') }} Digital Market Intelligence. Todos los derechos reservados.
                </div>
                <div class="footer-social">
                    <a href="#" class="social-link">LinkedIn</a>
                    <a href="#" class="social-link">GitHub</a>
                    <a href="#" class="social-link">Twitter</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            
            // Cambiar ícono del botón
            const isOpen = mobileMenu.classList.contains('active');
            mobileMenuButton.innerHTML = isOpen ? 
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>' :
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>';
        });

        // Cerrar menú móvil al hacer clic en un enlace
        mobileMenu.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                mobileMenuButton.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>';
            });
        });

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Solo smooth scroll para enlaces internos que no sean "#"
                if (href !== '#' && href.startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        // Cerrar menú móvil si está abierto
                        if (mobileMenu.classList.contains('active')) {
                            mobileMenu.classList.remove('active');
                            mobileMenuButton.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>';
                        }
                        
                        // Smooth scroll
                        window.scrollTo({
                            top: target.offsetTop - 80, // Ajuste para navbar fija
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Intersection Observer para animaciones
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observar elementos para animación
        document.querySelectorAll('.service-card, .client-logo, .metric-item, .testimonial-card').forEach(el => {
            observer.observe(el);
        });

        // Ajustar padding del hero para navbar fija
        function adjustHeroPadding() {
            const navbarHeight = navbar.offsetHeight;
            const hero = document.querySelector('.hero');
            if (hero) {
                hero.style.paddingTop = `calc(${navbarHeight}px + ${getComputedStyle(hero).paddingTop})`;
            }
        }

        // Ejecutar al cargar y redimensionar
        window.addEventListener('load', adjustHeroPadding);
        window.addEventListener('resize', adjustHeroPadding);
        adjustHeroPadding();

        // Clases iniciales para animaciones
        document.addEventListener('DOMContentLoaded', () => {
            // Añadir animación a elementos iniciales
            const initialElements = document.querySelectorAll('.hero-badge, .hero-title, .hero-description, .hero-actions');
            initialElements.forEach((el, index) => {
                el.classList.add('fade-up');
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

</body>
</html>