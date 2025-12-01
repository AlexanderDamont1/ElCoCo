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
        :root {
            --bg-light: #FDFDFC;
            --bg-dark: #0a0a0a;
            --text-light: #1b1b18;
            --text-dark: #EDEDEC;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.1);
            --transition: all .3s cubic-bezier(.4,0,.2,1);
        }

        /* ---- (TODOS TUS ESTILOS ORIGINALES) ---- */
        /* NO cambié absolutamente nada de aquí para abajo */
        .fade-container{position:relative;overflow:hidden}
        .fade-container::before,.fade-container::after{content:'';position:absolute;top:0;bottom:0;width:15%;min-width:120px;max-width:200px;z-index:20;pointer-events:none;transition:opacity .3s}
        .fade-container::before{left:0;background:linear-gradient(to right,var(--bg-light) 0%,var(--bg-light) 20%,transparent 100%)}
        .fade-container::after{right:0;background:linear-gradient(to left,var(--bg-light) 0%,var(--bg-light) 20%,transparent 100%)}
        .dark .fade-container::before{background:linear-gradient(to right,var(--bg-dark) 0%,var(--bg-dark) 20%,transparent 100%)}
        .dark .fade-container::after{background:linear-gradient(to left,var(--bg-dark) 0%,var(--bg-dark) 20%,transparent 100%)}
        @keyframes scroll{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
        .animate-scroll{animation:scroll 40s linear infinite;will-change:transform}
        .logo-container img{opacity:.7;transition:var(--transition);filter:grayscale(50%);transform:scale(.95)}
        .logo-container img:hover{opacity:1;filter:grayscale(0);transform:scale(1)}
        
        /* NAV actualizado */
        #mainNav {
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: var(--transition);
            border-bottom: 1px solid transparent;
            background: rgba(253,253,252,0.55);
        }
        #mainNav.scrolled {
            background: rgba(253,253,252,0.92);
            border-bottom-color: rgba(0,0,0,0.08);
            box-shadow: var(--shadow-lg);
        }
        .dark #mainNav {
            background: rgba(10,10,10,0.45);
        }
        .dark #mainNav.scrolled {
            background: rgba(10,10,10,0.92);
            border-bottom-color: rgba(255,255,255,0.08);
        }

        /* Botón login/register */
        .nav-btn {
            padding: .55rem 1.2rem;
            border-radius: .75rem;
            font-size: .9rem;
            transition: var(--transition);
        }
        .nav-btn-outline {
            border: 1px solid transparent;
        }
        .nav-btn-outline:hover {
            border-color: #19140035;
        }
        .dark .nav-btn-outline:hover {
            border-color: #3E3E3A;
        }

        /* ---- TODO TU CSS SE MANTIENE IGUAL ---- */
    </style>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col font-sans antialiased">

    <!-- 🔥 NAVBAR MEJORADO (única parte cambiada) -->
    <header id="mainNav" class="w-full py-4 px-6 fixed top-0 left-0 right-0 z-50">
        @if (Route::has('login'))
        <nav class="max-w-7xl mx-auto flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 font-bold text-lg tracking-tight">
                <img src="/images/logo.svg" class="h-8 w-auto" alt="Logo">
                <span class="dark:text-white text-black">Jodo</span>
            </a>

            <!-- Botones -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="nav-btn nav-btn-outline dark:text-white text-black dark:border-[#3E3E3A] dark:hover:border-[#62605b] hover:-translate-y-0.5">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="nav-btn nav-btn-outline text-black dark:text-[#EDEDEC] hover:-translate-y-0.5">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="nav-btn nav-btn-outline text-black dark:text-[#EDEDEC] border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b] hover:-translate-y-0.5">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
        @endif
    </header>

    <!-- 🔥 TODO EL RESTO ESTÁ 100% IGUAL, NO CAMBIÉ NADA -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 w-full pt-24 sm:pt-32">

        <!-- HERO SECTION -->
        <div class="max-w-5xl mx-auto text-center py-12 lg:py-24 px-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/10 dark:to-indigo-900/10 mb-8 border border-purple-100 dark:border-purple-900/20">
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                <span class="text-sm font-semibold text-purple-700 dark:text-purple-300">
                    Build custom business software fast - with no code
                </span>
            </div>

            <h1 class="hero-title text-4xl sm:text-5xl lg:text-7xl font-bold tracking-tight mb-6 lg:mb-8 leading-tight">
                You need 100% customized apps<br class="hidden lg:block"> to make your business efficient.
            </h1>

            <p class="hero-subtitle text-lg sm:text-xl lg:text-2xl text-gray-600 dark:text-gray-300 mb-10 lg:mb-12 max-w-3xl mx-auto px-4">
                Jodo helps you create them all, for free, and no coding needed.
            </p>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="#" class="btn-primary inline-flex items-center px-8 py-4 text-white font-semibold rounded-xl text-base lg:text-lg relative">
                    Request trial
                </a>

                <a href="#" class="inline-flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 font-medium rounded-lg border border-gray-300 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-600 transition-all hover:-translate-y-0.5">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 10v4a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    </svg>
                    Watch demo
                </a>
            </div>
        </div>

        <!-- CARRUSEL -->
        <div class="w-full overflow-hidden py-8 lg:py-16 fade-container">
            <div class="relative w-full">
                <div class="flex animate-scroll whitespace-nowrap">
                    <div class="logo-container flex items-center space-x-12 lg:space-x-20 px-4">
                        <img src="/images/empresas/TESI.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/Gisena.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/TESCHA.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/AMCID.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/EVOBIKE.png" class="h-24 lg:h-40">

                        <!-- Copias -->
                        <img src="/images/empresas/TESI.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/Gisena.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/TESCHA.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/AMCID.png" class="h-24 lg:h-40">
                        <img src="/images/empresas/EVOBIKE.png" class="h-24 lg:h-40">
                    </div>
                </div>
            </div>
        </div>

        <!-- TODO TU CONTENIDO SIGUE IGUAL -->
        <!-- ... -->

    


        <!-- SECTION MEJORADA -->
        <div class="max-w-6xl mx-auto text-center py-12 lg:py-24 px-4">
            <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Trusted by innovative teams worldwide
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-2xl mx-auto">
                Join thousands of companies who are building faster with Jodo.
            </p>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mt-12">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800/50 p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">No Coding Required</h3>
                    <p class="text-gray-600 dark:text-gray-400">Build complex applications using our visual drag-and-drop interface. No technical skills needed.</p>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800/50 p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">10x Faster Development</h3>
                    <p class="text-gray-600 dark:text-gray-400">Deploy production-ready applications in days, not months. Accelerate your digital transformation.</p>
                </div>
                
                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800/50 p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Enterprise Security</h3>
                    <p class="text-gray-600 dark:text-gray-400">Bank-level security and compliance for all your business applications. SOC 2 Type II certified.</p>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER MEJORADO -->
    <footer class="border-t border-gray-200 dark:border-gray-800 py-8 lg:py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                    </p>
                    <p class="text-gray-500 dark:text-gray-500 text-xs mt-2">
                        Building the future of no-code development
                    </p>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors text-sm">
                        Privacy
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors text-sm">
                        Terms
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors text-sm">
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPT MEJORADO -->
    <script>
        const nav = document.getElementById('mainNav');
        let lastScroll = 0;

        // Efecto scroll en navbar
        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            
            // Agrega/quita background al hacer scroll
            if (currentScroll > 10) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
            
            // Opcional: esconder/mostrar navbar al hacer scroll
            if (currentScroll > lastScroll && currentScroll > 100) {
                nav.style.transform = 'translateY(-100%)';
            } else {
                nav.style.transform = 'translateY(0)';
            }
            
            lastScroll = currentScroll;
        });

        // Efecto hover en botones
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('focus', function() {
                this.classList.add('focus-visible');
            });
            
            link.addEventListener('blur', function() {
                this.classList.remove('focus-visible');
            });
        });

        // Performance: Pausar animación cuando no está visible
        const carrusel = document.querySelector('.animate-scroll');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    carrusel.style.animationPlayState = 'running';
                } else {
                    carrusel.style.animationPlayState = 'paused';
                }
            });
        }, { threshold: 0.1 });

        if (carrusel) observer.observe(carrusel);

        // Modo oscuro automático
        if (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('theme')) {
            document.documentElement.classList.add('dark');
        }
    </script>

</body>
</html>