<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="bg-dark text-white position-fixed h-100" style="width:250px; top:0; left:0;">
        <div class="p-3">
            <h4 class="mb-4">
                <i class="fas fa-toolbox"></i> Admin
            </h4>

            <ul class="nav flex-column">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>

                {{-- Cotizaciones --}}
                <li class="nav-item">
                    <a href="{{ route('admin.quotes.index') }}"
                        class="nav-link text-white {{ request()->routeIs('admin.quotes.*') ? 'fw-bold' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i> Cotizaciones
                    </a>
                </li>

                {{-- Bloques --}}
                <li class="nav-item">
                    <a href="{{ route('admin.quote-blocks.index') }}"
                        class="nav-link text-white {{ request()->routeIs('admin.quote-blocks.*') ? 'fw-bold' : '' }}">
                        <i class="fas fa-cubes"></i> Bloques
                    </a>
                </li>

                {{-- Categorías --}}
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'fw-bold' : '' }}">
                        <i class="fas fa-folder"></i> Categorías
                    </a>
                </li>

            </ul>

            <hr class="border-light">

            <a href="{{ route('quote.builder') }}" class="btn btn-outline-light w-100 mt-3" target="_blank">
                <i class="fas fa-external-link-alt"></i> Ir al Cotizador
            </a>
        </div>
    </div>

    <!-- MAIN -->
    <div style="margin-left:250px">

        <!-- TOPBAR -->
        <nav class="navbar navbar-light bg-white px-4 shadow-sm">
            <h4>@yield('title')</h4>

            <div>
                {{ Auth::user()->name }}

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf
                </form>
            </div>
        </nav>

        <main class="container p-5">
            @yield('content')
        </main>

    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    
    @stack('scripts')
</body>
</html>
