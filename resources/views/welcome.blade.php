<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* INSPIRADO EN MELIORA.MX */
        :root {
            /* Colores principales inspirados en Meliora */
            --primary: #2d3748;
            --primary-dark: #1a202c;
            --primary-light: #4a5568;
            --accent: #4f46e5;
            --accent-light: #6366f1;
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
            
            /* Tipografía */
            --font-heading: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-body: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            
            /* Espaciado */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;
            --spacing-3xl: 4rem;
            
            /* Sombras */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            
            /* Bordes */
            --radius-sm: 0.25rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Transiciones */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* RESET Y BASE ESTILOS */
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
            font-size: 16px;
            line-height: 1.6;
            color: var(--gray-800);
            background-color: var(--white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* TIPOGRAFÍA INSPIRADA EN MELIORA */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            font-weight: 600;
            line-height: 1.2;
            color: var(--gray-900);
            margin-bottom: var(--spacing-md);
        }

        .display-1 {
            font-size: 4.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .display-2 {
            font-size: 3.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .heading-1 {
            font-size: 3rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .heading-2 {
            font-size: 2.25rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .heading-3 {
            font-size: 1.875rem;
            font-weight: 600;
        }

        .heading-4 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .body-large {
            font-size: 1.125rem;
            line-height: 1.7;
        }

        .body-regular {
            font-size: 1rem;
            line-height: 1.6;
        }

        .body-small {
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .caption {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--gray-500);
        }

        /* NAVBAR ELEGANTE COMO MELIORA */
        .navbar-meliora {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: var(--spacing-md) 0;
            transition: all var(--transition-normal);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .navbar-meliora.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-sm);
            padding: var(--spacing-sm) 0;
        }

        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 var(--spacing-lg);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gray-900);
        }

        .navbar-logo img {
            height: 2.5rem;
            width: auto;
            margin-right: var(--spacing-sm);
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: var(--spacing-xl);
        }

        .nav-link {
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color var(--transition-fast);
            position: relative;
            padding: var(--spacing-xs) 0;
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
            transition: width var(--transition-normal);
        }

        .nav-link:hover::after {
            width: 100%;
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
        }

        .nav-button:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* HERO SECTION ELEGANTE */
        .hero-section-meliora {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: var(--spacing-3xl) var(--spacing-lg);
            background: linear-gradient(135deg, var(--off-white) 0%, var(--white) 100%);
            overflow: hidden;
        }

        .hero-content {
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
            padding: var(--spacing-xs) var(--spacing-md);
            background: rgba(79, 70, 229, 0.1);
            color: var(--accent);
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: var(--radius-full);
            margin-bottom: var(--spacing-xl);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: var(--spacing-xl);
            color: var(--gray-900);
            max-width: 800px;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            line-height: 1.6;
            color: var(--gray-600);
            max-width: 600px;
            margin-bottom: var(--spacing-2xl);
        }

        .hero-actions {
            display: flex;
            gap: var(--spacing-md);
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 1rem 2rem;
            background: var(--accent);
            color: white;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            border: 2px solid var(--accent);
        }

        .btn-primary:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            padding: 1rem 2rem;
            background: transparent;
            color: var(--gray-700);
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
            border: 2px solid var(--gray-300);
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* LOGOS SECTION */
        .logos-section {
            padding: var(--spacing-2xl) var(--spacing-lg);
            background: var(--white);
        }

        .logos-title {
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-500);
            margin-bottom: var(--spacing-xl);
        }

        .logos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-xl);
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-item {
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.6;
            transition: opacity var(--transition-fast);
        }

        .logo-item:hover {
            opacity: 1;
        }

        .logo-item img {
            max-height: 60px;
            width: auto;
            filter: grayscale(100%);
            transition: filter var(--transition-fast);
        }

        .logo-item:hover img {
            filter: grayscale(0%);
        }

        /* FEATURES SECTION */
        .features-section {
            padding: var(--spacing-3xl) var(--spacing-lg);
            background: var(--off-white);
        }

        .section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto var(--spacing-3xl);
        }

        .section-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            color: var(--gray-900);
        }

        .section-description {
            font-size: 1.25rem;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-xl);
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: var(--spacing-2xl);
            transition: all var(--transition-normal);
            border: 1px solid var(--gray-200);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--accent-light);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: rgba(79, 70, 229, 0.1);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--spacing-lg);
        }

        .feature-icon svg {
            width: 32px;
            height: 32px;
            color: var(--accent);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: var(--spacing-md);
            color: var(--gray-900);
        }

        .feature-description {
            color: var(--gray-600);
            line-height: 1.6;
        }

        /* TESTIMONIALS SECTION */
        .testimonials-section {
            padding: var(--spacing-3xl) var(--spacing-lg);
            background: var(--white);
        }

        .testimonials-slider {
            max-width: 1000px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: var(--off-white);
            border-radius: var(--radius-xl);
            padding: var(--spacing-2xl);
            border: 1px solid var(--gray-200);
        }

        .testimonial-content {
            font-size: 1.25rem;
            font-style: italic;
            color: var(--gray-700);
            line-height: 1.6;
            margin-bottom: var(--spacing-xl);
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gray-300);
        }

        .author-info h4 {
            margin-bottom: var(--spacing-xs);
            font-size: 1rem;
        }

        .author-info p {
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        /* CTA SECTION */
        .cta-section {
            padding: var(--spacing-3xl) var(--spacing-lg);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            text-align: center;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            color: var(--white);
        }

        .cta-description {
            font-size: 1.25rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: var(--spacing-2xl);
        }

        /* FOOTER */
        .footer {
            background: var(--gray-900);
            color: var(--white);
            padding: var(--spacing-3xl) var(--spacing-lg) var(--spacing-lg);
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-2xl);
            margin-bottom: var(--spacing-2xl);
        }

        .footer-column h3 {
            color: var(--white);
            margin-bottom: var(--spacing-lg);
            font-size: 1.125rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: var(--spacing-sm);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            padding-top: var(--spacing-lg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--spacing-md);
        }

        .copyright {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }

        .footer-social {
            display: flex;
            gap: var(--spacing-md);
        }

        .social-link {
            color: rgba(255, 255, 255, 0.6);
            transition: color var(--transition-fast);
        }

        .social-link:hover {
            color: var(--white);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .display-1 { font-size: 3.75rem; }
            .display-2 { font-size: 3rem; }
            .heading-1 { font-size: 2.5rem; }
            .heading-2 { font-size: 2rem; }
            .hero-title { font-size: 3rem; }
            .section-title { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }
            
            .display-1 { font-size: 3rem; }
            .display-2 { font-size: 2.5rem; }
            .heading-1 { font-size: 2rem; }
            .heading-2 { font-size: 1.75rem; }
            .hero-title { font-size: 2.5rem; }
            .section-title { font-size: 2rem; }
            
            .hero-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn-primary, .btn-secondary {
                text-align: center;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .display-1 { font-size: 2.5rem; }
            .display-2 { font-size: 2rem; }
            .heading-1 { font-size: 1.75rem; }
            .hero-title { font-size: 2rem; }
            .section-title { font-size: 1.75rem; }
            
            .feature-card, .testimonial-card {
                padding: var(--spacing-xl);
            }
        }

        /* ANIMACIONES */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans antialiased">

    <!-- NAVBAR ELEGANTE -->
    <nav class="navbar-meliora" id="navbar">
        <div class="navbar-container">
           <a href="/" class="flex items-center gap-3 font-bold text-lg tracking-tight">
    <img src="/images/DMI-logob.png" class="h-20 w-auto" alt="Logo">
    <!-- h-16 en lugar de h-12 -->
</a>
            <div class="navbar-menu">
                <a href="#features" class="nav-link">Features</a>
                <a href="#testimonials" class="nav-link">Testimonials</a>
                <a href="#pricing" class="nav-link">Pricing</a>
                <a href="{{ route('login') }}" class="nav-link">Log in</a>
               <a href="{{ route('quote.builder') }}" class="nav-button">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section-meliora">
        <div class="hero-content">
            <span class="hero-badge animate-fade-in-up">✨ Build custom business software fast</span>
            <h1 class="hero-title animate-fade-in-up" style="animation-delay: 0.1s">
                You need 100% customized apps to make your business efficient.
            </h1>
            <p class="hero-subtitle animate-fade-in-up" style="animation-delay: 0.2s">
                Jodo helps you create them all, for free, and no coding needed.
            </p>
            <div class="hero-actions animate-fade-in-up" style="animation-delay: 0.3s">
                <a href="#" class="btn-primary">
                    Request trial
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#" class="btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 10v4a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Watch demo
                </a>
            </div>
        </div>
    </section>

    <!-- LOGOS SECTION -->
    <section class="logos-section">
        <div class="logos-title">Trusted by innovative teams worldwide</div>
        <div class="logos-grid">
            <div class="logo-item">
                <img src="/images/empresas/TESI.png" alt="TESI">
            </div>
            <div class="logo-item">
                <img src="/images/empresas/Gisena.png" alt="Gisena">
            </div>
            <div class="logo-item">
                <img src="/images/empresas/TESCHA.png" alt="TESCHA">
            </div>
            <div class="logo-item">
                <img src="/images/empresas/AMCID.png" alt="AMCID">
            </div>
            <div class="logo-item">
                <img src="/images/empresas/EVOBIKE.png" alt="EVOBIKE">
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features-section" id="features">
        <div class="section-header">
            <h2 class="section-title">Why choose our platform?</h2>
            <p class="section-description">
                Build, deploy, and scale your business applications with ease. Join thousands of companies who are building faster with Jodo.
            </p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="feature-title">No Coding Required</h3>
                <p class="feature-description">
                    Build complex applications using our visual drag-and-drop interface. No technical skills needed.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="feature-title">10x Faster Development</h3>
                <p class="feature-description">
                    Deploy production-ready applications in days, not months. Accelerate your digital transformation.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Enterprise Security</h3>
                <p class="feature-description">
                    Bank-level security and compliance for all your business applications. SOC 2 Type II certified.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Ready to transform your business?</h2>
            <p class="cta-description">
                Join thousands of companies who trust our platform for their digital transformation.
            </p>
            <a href="#" class="btn-primary">
                Get Started Free
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Digital Marketplace</h3>
                <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: var(--spacing-md);">
                    Building the future of no-code development
                </p>
            </div>
            
            <div class="footer-column">
                <h3>Product</h3>
                <ul class="footer-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Company</h3>
                <ul class="footer-links">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Legal</h3>
                <ul class="footer-links">
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
            <div class="footer-social">
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">LinkedIn</a>
                <a href="#" class="social-link">GitHub</a>
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

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .testimonial-card').forEach(el => {
            observer.observe(el);
        });

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            // Add animation delay to features cards
            document.querySelectorAll('.feature-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

</body>
</html>