<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="quoteBuilder()" x-init="init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffffff">
    <title>Cotizador — {{ config('app.name', 'DMI') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>
/* ═══════════════════════════════════════════
   VARIABLES
═══════════════════════════════════════════ */
:root {
    --accent:        #374151;
    --accent-light:  #4B5563;
    --accent-dark:   #1F2937;
    --white:         #ffffff;
    --gray-50:       #f9fafb;
    --gray-100:      #f3f4f6;
    --gray-200:      #e5e7eb;
    --gray-300:      #d1d5db;
    --gray-400:      #9ca3af;
    --gray-500:      #6b7280;
    --gray-600:      #4b5563;
    --gray-700:      #374151;
    --gray-800:      #1f2937;
    --gray-900:      #111827;
    --font: 'Instrument Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    --r-sm: 0.375rem;
    --r-md: 0.5rem;
    --r-lg: 0.75rem;
    --r-xl: 1rem;
    --r-2xl: 1.25rem;
    --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -2px rgba(0,0,0,.05);
    --shadow-xl: 0 20px 25px -5px rgba(0,0,0,.1), 0 10px 10px -5px rgba(0,0,0,.04);
    --shadow-2xl: 0 25px 50px -12px rgba(0,0,0,.25);
    --t-fast: 150ms cubic-bezier(.4,0,.2,1);
    --t-norm: 300ms cubic-bezier(.4,0,.2,1);
    --navbar-h: 60px;
    --summary-h: 80px;
}

/* ═══════════════════════════════════════════
   BASE
═══════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { font-size: 14px; scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }
body {
    font-family: var(--font);
    background: var(--gray-50);
    color: var(--gray-800);
    min-height: 100vh;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

/* ═══════════════════════════════════════════
   NAVBAR
═══════════════════════════════════════════ */
.navbar {
    position: fixed;
    inset: 0 0 auto 0;
    height: var(--navbar-h);
    z-index: 1000;
    background: rgba(255,255,255,.97);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: center;
    padding: 0 1.25rem;
}
.navbar-inner {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.navbar-logo {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--gray-900);
    flex-shrink: 0;
}
.navbar-logo img { height: 2.25rem; width: auto; }
.nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1rem;
    background: var(--accent);
    color: white;
    border: none;
    border-radius: var(--r-md);
    font-family: var(--font);
    font-weight: 500;
    font-size: 0.8125rem;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: background var(--t-fast), transform var(--t-fast), box-shadow var(--t-fast);
}
.nav-btn:hover { background: var(--accent-light); transform: translateY(-1px); box-shadow: var(--shadow-md); }

/* ═══════════════════════════════════════════
   LAYOUT PRINCIPAL
═══════════════════════════════════════════ */
.app-wrap {
    padding-top: var(--navbar-h);
    padding-bottom: var(--summary-h);
    height: 100dvh;
    display: flex;
    flex-direction: column;
}
.app-body {
    flex: 1;
    display: grid;
    grid-template-columns: 290px 1fr;
    gap: 0;
    overflow: hidden;
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
    padding: 1rem 1rem 0;
    gap: 1rem;
}

/* ═══════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════ */
.sidebar {
    background: white;
    border-radius: var(--r-lg);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    height: 100%;
}
.sidebar-head {
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--gray-200);
    background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
    flex-shrink: 0;
}
.sidebar-head h2 { font-size: 0.9375rem; font-weight: 600; color: var(--gray-900); }
.sidebar-head p  { font-size: 0.75rem; color: var(--gray-500); margin-top: 0.2rem; }
.sidebar-body {
    flex: 1;
    overflow-y: auto;
    padding: 0.75rem;
    scrollbar-width: thin;
    scrollbar-color: var(--gray-300) transparent;
}
.sidebar-body::-webkit-scrollbar { width: 5px; }
.sidebar-body::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 3px; }

/* Búsqueda en sidebar */
.sidebar-search {
    position: relative;
    margin-bottom: 0.75rem;
}
.sidebar-search input {
    width: 100%;
    padding: 0.5rem 0.75rem 0.5rem 2.1rem;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-md);
    font-size: 0.8125rem;
    font-family: var(--font);
    background: var(--gray-50);
    color: var(--gray-800);
    transition: border-color var(--t-fast), box-shadow var(--t-fast);
    outline: none;
}
.sidebar-search input:focus {
    border-color: var(--accent);
    background: white;
    box-shadow: 0 0 0 3px rgba(55,65,81,.1);
}
.sidebar-search svg {
    position: absolute;
    left: 0.6rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    pointer-events: none;
}

/* Categorías */
.cat-section {
    margin-bottom: 0.5rem;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-md);
    overflow: hidden;
}
.cat-header {
    padding: 0.625rem 0.875rem;
    background: var(--gray-50);
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    user-select: none;
    transition: background var(--t-fast);
    border-bottom: 1px solid transparent;
}
.cat-header:hover { background: var(--gray-100); }
.cat-header.open { border-bottom-color: var(--gray-200); }
.cat-header-label { font-size: 0.8125rem; font-weight: 600; color: var(--gray-800); }
.cat-count {
    font-size: 0.6875rem;
    padding: 0.125rem 0.5rem;
    background: var(--gray-200);
    color: var(--gray-600);
    border-radius: 99px;
    font-weight: 500;
}
.cat-chevron {
    width: 14px;
    height: 14px;
    color: var(--gray-400);
    transition: transform var(--t-fast);
    flex-shrink: 0;
}
.cat-chevron.open { transform: rotate(180deg); }
.cat-body { padding: 0.5rem; background: white; display: grid; gap: 0.375rem; }

/* Bloque en sidebar */
.block-pill {
    padding: 0.625rem 0.75rem;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-sm);
    cursor: grab;
    user-select: none;
    transition: border-color var(--t-fast), background var(--t-fast), transform var(--t-fast);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}
.block-pill:hover  { border-color: var(--accent); background: var(--gray-50); transform: translateX(2px); }
.block-pill:active { cursor: grabbing; }
.block-pill-name   { font-size: 0.8125rem; font-weight: 500; color: var(--gray-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.block-pill-desc   { font-size: 0.6875rem; color: var(--gray-500); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 0.1rem; }
.block-pill-price  { font-size: 0.75rem; font-weight: 600; color: var(--accent); white-space: nowrap; flex-shrink: 0; }
.block-pill-hrs    { font-size: 0.6875rem; color: var(--gray-400); white-space: nowrap; }

/* ═══════════════════════════════════════════
   ÁREA DE CONSTRUCCIÓN
═══════════════════════════════════════════ */
.canvas-area {
    background: white;
    border-radius: var(--r-lg);
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    height: 100%;
}
.canvas-head {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--gray-200);
    background: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    flex-wrap: wrap;
    flex-shrink: 0;
}
.canvas-title { font-size: 0.9375rem; font-weight: 600; color: var(--gray-900); }
.canvas-subtitle { font-size: 0.75rem; color: var(--gray-500); margin-top: 0.15rem; }
.canvas-controls { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
.zoom-wrap {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: var(--gray-100);
    padding: 0.25rem;
    border-radius: var(--r-md);
}
.zoom-btn {
    width: 26px; height: 26px;
    border: 1px solid var(--gray-300);
    border-radius: var(--r-sm);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--gray-700);
    transition: all var(--t-fast);
}
.zoom-btn:hover:not(:disabled) { background: var(--accent); color: white; border-color: var(--accent); }
.zoom-btn:disabled { opacity: .35; cursor: not-allowed; }
.zoom-val { font-size: 0.6875rem; font-weight: 600; color: var(--gray-700); min-width: 2.5rem; text-align: center; }

/* Botones acción canvas */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 0.875rem;
    border-radius: var(--r-md);
    font-family: var(--font);
    font-weight: 500;
    font-size: 0.8125rem;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all var(--t-fast);
    white-space: nowrap;
    outline: none;
}
.btn:disabled { opacity: .45; cursor: not-allowed; pointer-events: none; }
.btn-icon { padding: 0.4rem; }
.btn-primary { background: var(--accent); color: white; border-color: var(--accent); }
.btn-primary:hover:not(:disabled) { background: var(--accent-light); transform: translateY(-1px); box-shadow: var(--shadow-md); }
.btn-ghost   { background: transparent; color: var(--gray-600); border-color: var(--gray-300); }
.btn-ghost:hover:not(:disabled) { border-color: var(--accent); color: var(--accent); background: var(--gray-50); }
.btn-danger  { background: transparent; color: #dc2626; border-color: #fecaca; }
.btn-danger:hover:not(:disabled) { background: #fef2f2; border-color: #fca5a5; }

/* Canvas viewport */
.canvas-viewport {
    flex: 1;
    position: relative;
    background: var(--gray-50);
    overflow: auto;
    cursor: default;
}
.canvas-grid {
    position: absolute;
    inset: 0;
    width: 2000px;
    height: 2000px;
    background-image:
        linear-gradient(rgba(0,0,0,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,0,0,.03) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
    z-index: 0;
    transform-origin: 0 0;
}
.canvas-blocks {
    position: absolute;
    top: 0; left: 0;
    width: 2000px;
    height: 2000px;
    transform-origin: 0 0;
    pointer-events: none;
    z-index: 1;
}
.canvas-blocks * { pointer-events: auto; }

/* ═══════════════════════════════════════════
   BLOQUES DRAGGABLE
═══════════════════════════════════════════ */
.d-block {
    position: absolute;
    width: 258px;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-sm);
    cursor: move;
    user-select: none;
    touch-action: none;
    transition: box-shadow var(--t-fast), border-color var(--t-fast);
    transform-origin: 0 0;
}
.d-block:hover   { box-shadow: var(--shadow-md); border-color: var(--gray-300); }
.d-block.active  { box-shadow: var(--shadow-xl); border-color: var(--accent); z-index: 100 !important; }

.d-block-head {
    padding: 0.6rem 0.75rem;
    background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
    border-bottom: 1px solid var(--gray-200);
    border-radius: var(--r-lg) var(--r-lg) 0 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.5rem;
    cursor: move;
}
.d-block-name { font-size: 0.8125rem; font-weight: 600; color: var(--gray-900); line-height: 1.3; }
.d-block-cat  { font-size: 0.6875rem; color: var(--gray-400); margin-top: 0.15rem; }
.d-block-close {
    width: 22px; height: 22px;
    border: none;
    border-radius: var(--r-sm);
    background: transparent;
    color: var(--gray-400);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--t-fast);
    flex-shrink: 0;
    padding: 0;
}
.d-block-close:hover { background: #fee2e2; color: #dc2626; }

.d-block-body { padding: 0.75rem; }
.d-block-body .field-row { margin-bottom: 0.5rem; }
.d-block-body label { display: block; font-size: 0.6875rem; font-weight: 500; color: var(--gray-600); margin-bottom: 0.25rem; }
.d-block-body input[type="number"] {
    width: 100%;
    padding: 0.375rem 0.625rem;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-sm);
    font-size: 0.8125rem;
    font-family: var(--font);
    background: white;
    color: var(--gray-900);
    outline: none;
    transition: border-color var(--t-fast);
}
.d-block-body input[type="number"]:focus { border-color: var(--accent); box-shadow: 0 0 0 2px rgba(55,65,81,.08); }

.d-block-foot {
    padding: 0.5rem 0.75rem;
    border-top: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--gray-50);
    border-radius: 0 0 var(--r-lg) var(--r-lg);
}
.d-block-total { font-size: 0.8125rem; font-weight: 700; color: var(--accent); }
.d-block-hours { font-size: 0.6875rem; color: var(--gray-400); margin-top: 0.1rem; }
.d-block-dup {
    width: 26px; height: 26px;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-sm);
    background: white;
    color: var(--gray-500);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--t-fast);
}
.d-block-dup:hover { background: var(--accent); color: white; border-color: var(--accent); }

/* Empty state */
.canvas-empty {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    pointer-events: none;
}
.canvas-empty-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
}
.canvas-empty h3 { font-size: 1.0625rem; font-weight: 600; color: var(--gray-800); }
.canvas-empty p  { font-size: 0.8125rem; color: var(--gray-500); text-align: center; max-width: 240px; line-height: 1.5; }

/* ═══════════════════════════════════════════
   PANEL DE RESUMEN
═══════════════════════════════════════════ */
.summary-bar {
    position: fixed;
    inset: auto 0 0 0;
    height: var(--summary-h);
    z-index: 900;
    background: white;
    border-top: 1px solid var(--gray-200);
    box-shadow: 0 -4px 16px rgba(0,0,0,.06);
    display: flex;
    align-items: center;
    padding: 0 1.25rem;
}
.summary-inner {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 1.5rem;
    align-items: center;
}
.sum-total { flex-shrink: 0; }
.sum-total-label { font-size: 0.6875rem; text-transform: uppercase; letter-spacing: .06em; color: var(--gray-500); }
.sum-total-val   { font-size: 1.5rem; font-weight: 700; color: var(--gray-900); line-height: 1.15; }
.sum-total-hrs   { font-size: 0.75rem; color: var(--gray-400); margin-top: 0.1rem; }
.sum-meta {
    display: flex;
    gap: 1.25rem;
    flex-wrap: wrap;
    justify-content: center;
}
.sum-item { text-align: center; }
.sum-item-label { font-size: 0.6875rem; text-transform: uppercase; letter-spacing: .05em; color: var(--gray-400); }
.sum-item-val   { font-size: 0.9375rem; font-weight: 600; color: var(--gray-800); margin-top: 0.1rem; }
.sum-actions { display: flex; justify-content: flex-end; gap: 0.625rem; flex-shrink: 0; }

/* ═══════════════════════════════════════════
   TOASTS
═══════════════════════════════════════════ */
.toast-wrap {
    position: fixed;
    top: calc(var(--navbar-h) + 0.75rem);
    right: 1rem;
    z-index: 2500;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-width: 300px;
    pointer-events: none;
}
.toast {
    background: white;
    border-radius: var(--r-md);
    padding: 0.625rem 0.875rem;
    box-shadow: var(--shadow-lg);
    border-left: 3px solid var(--gray-400);
    font-size: 0.8125rem;
    color: var(--gray-800);
    animation: toastIn .25s ease-out forwards;
    pointer-events: auto;
}
.toast.success { border-left-color: #10b981; }
.toast.error   { border-left-color: #ef4444; }
.toast.info    { border-left-color: #3b82f6; }
.toast.warning { border-left-color: #f59e0b; }
@keyframes toastIn {
    from { opacity: 0; transform: translateX(12px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* ═══════════════════════════════════════════
   MODALES — BASE
═══════════════════════════════════════════ */
.modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 2000;
    display: flex;
    align-items: flex-end;     /* mobile: sheet desde abajo */
    justify-content: center;
    padding: 0;
    animation: bdIn .25s ease-out;
}
@keyframes bdIn { from { opacity: 0; } to { opacity: 1; } }

/* Modal genérico (sheet desde abajo en móvil, centered en desktop) */
.modal-sheet {
    background: white;
    width: 100%;
    max-height: 92dvh;
    border-radius: var(--r-2xl) var(--r-2xl) 0 0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: sheetUp .3s cubic-bezier(.32,1,.32,1);
    box-shadow: 0 -8px 40px rgba(0,0,0,.15);
}
@keyframes sheetUp {
    from { transform: translateY(100%); }
    to   { transform: translateY(0); }
}

/* Handle visual para swipe */
.modal-handle {
    width: 36px;
    height: 4px;
    background: var(--gray-300);
    border-radius: 2px;
    margin: 0.75rem auto 0;
    flex-shrink: 0;
}
.modal-head {
    padding: 1rem 1.25rem 0.875rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--gray-100);
    flex-shrink: 0;
}
.modal-title  { font-size: 1.0625rem; font-weight: 700; color: var(--gray-900); }
.modal-close  {
    width: 30px; height: 30px;
    border: 1px solid var(--gray-200);
    border-radius: var(--r-md);
    background: var(--gray-50);
    color: var(--gray-500);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--t-fast);
    flex-shrink: 0;
}
.modal-close:hover { background: var(--gray-200); color: var(--gray-900); }
.modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.25rem;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
}
.modal-foot {
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--gray-100);
    display: flex;
    gap: 0.625rem;
    flex-shrink: 0;
    background: white;
    /* safe area para dispositivos con home indicator */
    padding-bottom: calc(1rem + env(safe-area-inset-bottom));
}
.modal-foot .btn { flex: 1; justify-content: center; padding-top: 0.625rem; padding-bottom: 0.625rem; }

/* En desktop: centrar como diálogo */
@media (min-width: 640px) {
    .modal-backdrop { align-items: center; padding: 1rem; }
    .modal-sheet {
        max-width: 480px;
        border-radius: var(--r-2xl);
        max-height: 88vh;
        animation: dialogIn .3s cubic-bezier(.32,1,.32,1);
    }
    @keyframes dialogIn {
        from { opacity: 0; transform: scale(.94) translateY(12px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-handle { display: none; }
    .modal-foot { padding-bottom: 1rem; }
}

/* ═══════════════════════════════════════════
   FORMULARIO EN MODAL
═══════════════════════════════════════════ */
.field-group { margin-bottom: 1rem; }
.field-label {
    display: block;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--gray-700);
    margin-bottom: 0.375rem;
}
.field-label .req { color: #ef4444; margin-left: 0.2rem; }
.field-input {
    width: 100%;
    padding: 0.625rem 0.75rem;
    border: 1px solid var(--gray-300);
    border-radius: var(--r-md);
    font-size: 0.875rem;
    font-family: var(--font);
    color: var(--gray-900);
    background: white;
    outline: none;
    transition: border-color var(--t-fast), box-shadow var(--t-fast);
    -webkit-appearance: none;
}
.field-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(55,65,81,.1);
}
.field-input::placeholder { color: var(--gray-400); }
textarea.field-input { resize: vertical; min-height: 72px; }

/* Grid 2 columnas en formulario */
.field-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
@media (max-width: 400px) { .field-row-2 { grid-template-columns: 1fr; } }

/* Resumen mini en modal */
.quote-summary-box {
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--r-lg);
    padding: 1rem;
    margin-top: 0.25rem;
}
.quote-summary-box h4 { font-size: 0.8125rem; font-weight: 600; color: var(--gray-800); margin-bottom: 0.75rem; }
.qsb-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.8125rem; color: var(--gray-600); padding: 0.25rem 0; }
.qsb-row.total {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--gray-900);
    border-top: 1px solid var(--gray-200);
    margin-top: 0.5rem;
    padding-top: 0.75rem;
}
.qsb-row.total span:last-child { color: var(--accent); }

/* ═══════════════════════════════════════════
   MODAL DE TUTORIAL
═══════════════════════════════════════════ */
.tutorial-sheet {
    background: white;
    width: 100%;
    max-width: 600px;
    border-radius: var(--r-2xl) var(--r-2xl) 0 0;
    max-height: 92dvh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: sheetUp .35s cubic-bezier(.32,1,.32,1);
    box-shadow: 0 -8px 40px rgba(0,0,0,.2);
}
@media (min-width: 640px) {
    .tutorial-sheet {
        border-radius: var(--r-2xl);
        animation: dialogIn .3s cubic-bezier(.32,1,.32,1);
    }
}
.tut-body { flex: 1; overflow-y: auto; padding: 1.25rem; }
.tut-video {
    aspect-ratio: 16/9;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: var(--r-lg);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    color: var(--gray-400);
    margin-bottom: 1.25rem;
    overflow: hidden;
}
.tut-steps { display: flex; flex-direction: column; gap: 1rem; }
.tut-step { display: flex; align-items: flex-start; gap: 0.875rem; }
.tut-step-num {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: var(--accent);
    color: white;
    font-size: 0.8125rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 3px 8px rgba(0,0,0,.15);
}
.tut-step-title { font-size: 0.9375rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem; }
.tut-step-desc  { font-size: 0.8125rem; color: var(--gray-600); line-height: 1.5; }

/* ═══════════════════════════════════════════
   MODAL DE ÉXITO
═══════════════════════════════════════════ */
.success-sheet {
    background: white;
    width: 100%;
    max-width: 420px;
    border-radius: var(--r-2xl) var(--r-2xl) 0 0;
    overflow: hidden;
    animation: sheetUp .35s cubic-bezier(.32,1,.32,1);
    box-shadow: 0 -8px 40px rgba(0,0,0,.2);
}
@media (min-width: 640px) {
    .success-sheet { border-radius: var(--r-2xl); animation: dialogIn .3s cubic-bezier(.32,1,.32,1); }
}
.success-body { padding: 2rem 1.5rem 1.5rem; text-align: center; }
.success-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: #d1fae5;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
}
.success-icon svg { color: #059669; }
.success-ref {
    display: inline-block;
    background: var(--gray-100);
    border: 1px solid var(--gray-200);
    border-radius: var(--r-md);
    padding: 0.5rem 1rem;
    font-family: monospace;
    font-size: 1rem;
    font-weight: 700;
    color: var(--accent);
    letter-spacing: .05em;
    margin: 0.75rem 0 1.25rem;
}
.success-actions { display: flex; flex-direction: column; gap: 0.5rem; padding: 0 0 calc(1rem + env(safe-area-inset-bottom)); }
.success-actions .btn { justify-content: center; padding-top: 0.7rem; padding-bottom: 0.7rem; }

/* ═══════════════════════════════════════════
   SPINNER
═══════════════════════════════════════════ */
.spinner {
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin .7s linear infinite;
    flex-shrink: 0;
}
.spinner.dark { border-color: rgba(55,65,81,.2); border-top-color: var(--accent); }
@keyframes spin { to { transform: rotate(360deg); } }

/* ═══════════════════════════════════════════
   ESTADO DE CARGA / VACÍO
═══════════════════════════════════════════ */
.loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 2rem 1rem;
    color: var(--gray-500);
    font-size: 0.8125rem;
}
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 2.5rem 1rem;
    color: var(--gray-400);
    font-size: 0.8125rem;
    text-align: center;
}

/* ═══════════════════════════════════════════
   RESPONSIVE — MÓVIL
═══════════════════════════════════════════ */

/* TABLET */
@media (max-width: 1024px) {
    .app-body { grid-template-columns: 260px 1fr; }
}

/* MÓVIL: layout vertical con sidebar como drawer inferior */
@media (max-width: 768px) {
    :root { --summary-h: 72px; }

    .app-body {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        padding: 0.75rem 0.75rem 0;
    }

    /* Sidebar como drawer lateral colapsable */
    .sidebar {
        position: fixed;
        inset: var(--navbar-h) auto 0 0;
        width: min(290px, 85vw);
        z-index: 800;
        border-radius: 0 var(--r-xl) var(--r-xl) 0;
        transform: translateX(-100%);
        transition: transform .3s cubic-bezier(.32,1,.32,1);
        box-shadow: var(--shadow-xl);
        height: calc(100dvh - var(--navbar-h) - var(--summary-h));
    }
    .sidebar.open { transform: translateX(0); }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.4);
        z-index: 799;
        backdrop-filter: blur(2px);
    }
    .sidebar-overlay.show { display: block; }

    .canvas-area { border-radius: var(--r-lg); }

    /* Fab para abrir sidebar en móvil */
    .sidebar-fab {
        display: flex;
        position: fixed;
        bottom: calc(var(--summary-h) + 1rem);
        left: 1rem;
        z-index: 790;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--accent);
        color: white;
        border: none;
        box-shadow: var(--shadow-lg);
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform var(--t-fast), box-shadow var(--t-fast);
    }
    .sidebar-fab:active { transform: scale(.93); }

    .summary-inner {
        grid-template-columns: 1fr auto;
        gap: 0.75rem;
    }
    .sum-meta { display: none; } /* ocultamos en móvil para no saturar */

    .canvas-head {
        padding: 0.625rem 0.75rem;
        gap: 0.5rem;
    }
    .canvas-controls { gap: 0.375rem; }
    .btn { padding: 0.375rem 0.625rem; font-size: 0.75rem; }
    .zoom-val { min-width: 2rem; font-size: 0.6875rem; }

    /* Ocultar texto en botones pequeños en móvil */
    .btn-label-md { display: none; }
}

/* MÓVIL PEQUEÑO */
@media (max-width: 480px) {
    :root { --navbar-h: 56px; }
    .canvas-head .canvas-title { font-size: 0.875rem; }
    .d-block { width: 230px; }
}

/* Tablet portrait: sidebar visible pero más angosta */
@media (min-width: 769px) {
    .sidebar-fab { display: none; }
    .sidebar-overlay { display: none !important; }
}

/* ═══════════════════════════════════════════
   UTILIDADES
═══════════════════════════════════════════ */
.sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; }
.truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
[x-cloak] { display: none !important; }

/* Anim entrada general */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up { animation: fadeUp .35s ease-out; }
</style>
</head>

<body>
<!-- ────────────────────────────────────────
     NAVBAR
──────────────────────────────────────── -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="/" class="navbar-logo">
            <img src="/images/DMI-logob.png" alt="DMI">
        </a>
        <a href="/" class="nav-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Inicio
        </a>
    </div>
</nav>

<!-- ────────────────────────────────────────
     TOASTS
──────────────────────────────────────── -->
<div class="toast-wrap" id="toast-wrap"></div>

<!-- ────────────────────────────────────────
     OVERLAY SIDEBAR (móvil)
──────────────────────────────────────── -->
<div class="sidebar-overlay" :class="{ show: sidebarOpen }" @click="sidebarOpen = false"></div>

<!-- ────────────────────────────────────────
     FAB SERVICIOS (móvil)
──────────────────────────────────────── -->
<button class="sidebar-fab" @click="sidebarOpen = !sidebarOpen" aria-label="Servicios">
    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<!-- ────────────────────────────────────────
     APP WRAPPER
──────────────────────────────────────── -->
<div class="app-wrap">
    <div class="app-body fade-up">

        <!-- ══ SIDEBAR ══ -->
        <aside class="sidebar" :class="{ open: sidebarOpen }">
            <div class="sidebar-head">
                <h2>Servicios</h2>
                <p>Arrastra al área de trabajo</p>
            </div>
            <div class="sidebar-body">

                <!-- Búsqueda -->
                <div class="sidebar-search">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" x-model="search" placeholder="Buscar servicio…" autocomplete="off">
                </div>

                <!-- Cargando -->
                <div x-show="isLoadingBlocks" class="loading-state">
                    <div class="spinner dark"></div>
                    <span>Cargando servicios…</span>
                </div>

                <!-- Sin bloques -->
                <div x-show="!isLoadingBlocks && filteredCategories.length === 0" class="empty-state">
                    <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/>
                    </svg>
                    <span x-text="search ? 'Sin resultados para «' + search + '»' : 'No hay servicios disponibles'"></span>
                </div>

                <!-- Categorías -->
                <template x-for="cat in filteredCategories" :key="cat.id">
                    <div class="cat-section">
                        <div class="cat-header" :class="{ open: cat.expanded }" @click="cat.expanded = !cat.expanded">
                            <span class="cat-header-label" x-text="cat.name"></span>
                            <div style="display:flex;align-items:center;gap:0.5rem">
                                <span class="cat-count" x-text="cat.blocks.length"></span>
                                <svg class="cat-chevron" :class="{ open: cat.expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="cat-body" x-show="cat.expanded" x-transition>
                            <template x-for="block in cat.blocks" :key="block.id">
                                <div class="block-pill"
                                     draggable="true"
                                     @dragstart="onDragStart($event, block)"
                                     @dragend="onDragEnd($event)"
                                     @click="addBlockAt(block, null, null)"
                                     :title="'Clic para agregar · ' + block.name">
                                    <div style="flex:1;min-width:0">
                                        <div class="block-pill-name" x-text="block.name"></div>
                                        <div class="block-pill-desc" x-text="block.description"></div>
                                    </div>
                                    <div style="text-align:right;flex-shrink:0">
                                        <div class="block-pill-price" x-text="fmt(block.base_price)"></div>
                                        <div class="block-pill-hrs"  x-text="block.default_hours + 'h'"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

            </div>
        </aside>

        <!-- ══ ÁREA DE CONSTRUCCIÓN ══ -->
        <div class="canvas-area">
            <div class="canvas-head">
                <div>
                    <div class="canvas-title">Cotizador DMI</div>
                    <div class="canvas-subtitle"
                         x-text="placedBlocks.length === 0
                            ? 'Arrastra o toca un servicio para comenzar'
                            : placedBlocks.length + ' servicio' + (placedBlocks.length !== 1 ? 's' : '') + ' · ' + fmt(totalCost)">
                    </div>
                </div>
                <div class="canvas-controls">
                    <!-- Zoom -->
                    <div class="zoom-wrap">
                        <button class="zoom-btn" @click="zoomOut" :disabled="zoom <= 0.4" aria-label="Alejar">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <span class="zoom-val" x-text="Math.round(zoom * 100) + '%'"></span>
                        <button class="zoom-btn" @click="zoomIn"  :disabled="zoom >= 2"    aria-label="Acercar">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Acciones -->
                    <button class="btn btn-ghost btn-icon" @click="undo" :disabled="historyIdx <= 0" title="Deshacer (Ctrl+Z)" aria-label="Deshacer">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                    </button>
                    <button class="btn btn-ghost btn-icon" @click="redo" :disabled="historyIdx >= history.length - 1" title="Rehacer (Ctrl+Y)" aria-label="Rehacer">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"/>
                        </svg>
                    </button>
                    <button class="btn btn-ghost" @click="clearCanvas" :disabled="placedBlocks.length === 0" aria-label="Limpiar">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="btn-label-md">Limpiar</span>
                    </button>
                    <button class="btn btn-primary" @click="showSubmit = true" :disabled="placedBlocks.length === 0" aria-label="Enviar cotización">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span class="btn-label-md">Enviar</span>
                    </button>
                </div>
            </div>

            <!-- Canvas viewport -->
            <div class="canvas-viewport"
                 id="canvas-vp"
                 @dragover.prevent
                 @drop.prevent="onCanvasDrop">

                <div class="canvas-grid" :style="{ transform: 'scale('+zoom+')' }"></div>

                <div class="canvas-blocks" :style="{ transform: 'scale('+zoom+')' }">
                    <!-- Bloques colocados -->
                    <template x-for="(blk, idx) in placedBlocks" :key="blk.iid">
                        <div class="d-block"
                             :class="{ active: blk.dragging }"
                             :data-iid="blk.iid"
                             :style="{ left: blk.x + 'px', top: blk.y + 'px', zIndex: blk.z || 10 }">

                            <div class="d-block-head">
                                <div style="min-width:0;flex:1">
                                    <div class="d-block-name truncate" x-text="blk.name"></div>
                                    <div class="d-block-cat truncate" x-text="blk.category_name || ''"></div>
                                </div>
                                <button class="d-block-close" @click="removeBlock(blk.iid)" aria-label="Eliminar">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="d-block-body">
                                <div class="field-row">
                                    <label>Cantidad</label>
                                    <input type="number" x-model.number="blk.quantity" min="1" max="99"
                                           @change="recalc(blk)">
                                </div>
                            </div>

                            <div class="d-block-foot">
                                <div>
                                    <div class="d-block-total" x-text="fmt(blk.totalPrice)"></div>
                                    <div class="d-block-hours" x-text="(blk.hours * blk.quantity) + 'h totales'"></div>
                                </div>
                                <button class="d-block-dup" @click="dupBlock(blk.iid)" title="Duplicar" aria-label="Duplicar">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Empty state -->
                    <div class="canvas-empty" x-show="placedBlocks.length === 0">
                        <div class="canvas-empty-icon">
                            <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3>Comienza tu cotización</h3>
                        <p>Arrastra un servicio desde el panel, o tócalo para agregarlo directamente.</p>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /app-body -->
</div><!-- /app-wrap -->

<!-- ────────────────────────────────────────
     SUMMARY BAR
──────────────────────────────────────── -->
<div class="summary-bar">
    <div class="summary-inner">
        <div class="sum-total">
            <div class="sum-total-label">Total estimado</div>
            <div class="sum-total-val" x-text="fmt(totalCost)"></div>
            <div class="sum-total-hrs" x-text="totalHours + ' horas'"></div>
        </div>
        <div class="sum-meta">
            <div class="sum-item">
                <div class="sum-item-label">Servicios</div>
                <div class="sum-item-val" x-text="placedBlocks.length"></div>
            </div>
            <div class="sum-item">
                <div class="sum-item-label">Subtotal</div>
                <div class="sum-item-val" x-text="fmt(subtotal)"></div>
            </div>
            <div class="sum-item">
                <div class="sum-item-label">IVA 16%</div>
                <div class="sum-item-val" x-text="fmt(totalTax)"></div>
            </div>
        </div>
        <div class="sum-actions">
            <button class="btn btn-primary" @click="showSubmit = true" :disabled="placedBlocks.length === 0">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Enviar Cotización
            </button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MODAL TUTORIAL
═══════════════════════════════════════════════════════ -->
<div class="modal-backdrop" x-show="showTutorial" x-cloak @click.self="showTutorial = false">
    <div class="tutorial-sheet">
        <div class="modal-handle"></div>
        <div class="modal-head">
            <span class="modal-title">¿Cómo usar el Cotizador?</span>
            <button class="modal-close" @click="showTutorial = false" aria-label="Cerrar">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="tut-body">
            <div class="tut-video">
    <video 
        controls
        preload="metadata"
        poster="/images/video-preview.jpg"
        style="width:100%; border-radius:14px; max-height:320px; object-fit:cover;"
    >
        <source src="/videos/demo-dmi.mp4" type="video/mp4">
        Tu navegador no soporta video HTML5.
    </video>

    <span style="font-size:.875rem;font-weight:500;color:var(--gray-500);display:block;margin-top:8px;">
        Demostración DMI
    </span>
</div>
            <div class="tut-steps">
                <div class="tut-step">
                    <div class="tut-step-num">1</div>
                    <div>
                        <div class="tut-step-title">Selecciona servicios</div>
                        <p class="tut-step-desc">Arrastra bloques desde el panel izquierdo — o tócalos para agregarlos directamente en móvil.</p>
                    </div>
                </div>
                <div class="tut-step">
                    <div class="tut-step-num">2</div>
                    <div>
                        <div class="tut-step-title">Organiza y ajusta</div>
                        <p class="tut-step-desc">Mueve, duplica y ajusta cantidades. El total se actualiza en tiempo real.</p>
                    </div>
                </div>
                <div class="tut-step">
                    <div class="tut-step-num">3</div>
                    <div>
                        <div class="tut-step-title">Envía al cliente</div>
                        <p class="tut-step-desc">Pulsa "Enviar Cotización", llena los datos y te contactamos en menos de 24h.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-primary" @click="showTutorial = false">¡Comenzar!</button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MODAL ENVIAR COTIZACIÓN
═══════════════════════════════════════════════════════ -->
<div class="modal-backdrop" x-show="showSubmit" x-cloak @click.self="showSubmit = false" @keydown.escape.window="showSubmit = false">
    <div class="modal-sheet">
        <div class="modal-handle"></div>
        <div class="modal-head">
            <span class="modal-title">Enviar Cotización</span>
            <button class="modal-close" @click="showSubmit = false" aria-label="Cerrar">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="modal-body">
            <!-- Datos de contacto -->
            <div class="field-group">
                <label class="field-label">Nombre completo<span class="req">*</span></label>
                <input class="field-input" type="text" x-model="form.name" placeholder="Tu nombre o empresa" autocomplete="name">
            </div>
            <div class="field-row-2">
                <div class="field-group">
                    <label class="field-label">Correo<span class="req">*</span></label>
                    <input class="field-input" type="email" x-model="form.email" placeholder="correo@ejemplo.com" autocomplete="email" inputmode="email">
                </div>
                <div class="field-group">
                    <label class="field-label">Teléfono</label>
                    <input class="field-input" type="tel" x-model="form.phone" placeholder="+52 123 456 7890" autocomplete="tel" inputmode="tel">
                </div>
            </div>
            <div class="field-group">
                <label class="field-label">Empresa</label>
                <input class="field-input" type="text" x-model="form.company" placeholder="Nombre de la empresa" autocomplete="organization">
            </div>
            <div class="field-group">
                <label class="field-label">Notas adicionales</label>
                <textarea class="field-input" x-model="form.notes" placeholder="Requerimientos especiales, preguntas…" rows="3"></textarea>
            </div>

            <!-- Resumen -->
            <div class="quote-summary-box">
                <h4>Resumen de cotización</h4>
                <div class="qsb-row"><span>Servicios</span><span x-text="placedBlocks.length"></span></div>
                <div class="qsb-row"><span>Horas totales</span><span x-text="totalHours + 'h'"></span></div>
                <div class="qsb-row"><span>Subtotal</span><span x-text="fmt(subtotal)"></span></div>
                <div class="qsb-row"><span>IVA (16%)</span><span x-text="fmt(totalTax)"></span></div>
                <div class="qsb-row total"><span>Total</span><span x-text="fmt(totalCost)"></span></div>
            </div>
        </div>

        <div class="modal-foot">
            <button class="btn btn-ghost" @click="showSubmit = false">Cancelar</button>
            <button class="btn btn-primary"
                    @click="submitQuote"
                    :disabled="isSubmitting || !form.name || !form.email">
                <div x-show="isSubmitting" class="spinner"></div>
                <span x-text="isSubmitting ? 'Enviando…' : 'Enviar Cotización'"></span>
            </button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     MODAL ÉXITO
═══════════════════════════════════════════════════════ -->
<div class="modal-backdrop" x-show="showSuccess" x-cloak>
    <div class="success-sheet">
        <div class="modal-handle"></div>
        <div class="success-body">
            <div class="success-icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 style="font-size:1.25rem;font-weight:700;color:var(--gray-900)">¡Cotización enviada!</h2>
            <p style="font-size:.875rem;color:var(--gray-500);margin-top:.5rem;line-height:1.5">
                Te contactaremos en menos de 24 horas con los detalles.
            </p>
            <div class="success-ref" x-text="'DMI-' + quoteRef"></div>
            <div class="success-actions">
                <a href="/" class="btn btn-primary">Volver al inicio</a>
                <button class="btn btn-ghost" @click="showSuccess = false; placedBlocks = []">Nueva cotización</button>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     ALPINE JS
═══════════════════════════════════════════════════════ -->
<script>
function quoteBuilder() {
    return {
        /* ── Estado ── */
        categories:    [],
        placedBlocks:  [],
        zoom:          1,
        search:        '',
        sidebarOpen:   false,

        /* ── UI ── */
        showTutorial:  true,
        showSubmit:    false,
        showSuccess:   false,
        isSubmitting:  false,
        isLoadingBlocks: false,
        quoteRef:      '',

        /* ── Formulario ── */
        form: { name: '', email: '', phone: '', company: '', notes: '' },

        /* ── Historia ── */
        history:    [],
        historyIdx: -1,

        /* ── Computed ── */
        get subtotal()   { return this.placedBlocks.reduce((s, b) => s + (b.totalPrice || 0), 0); },
        get totalTax()   { return this.subtotal * 0.16; },
        get totalCost()  { return this.subtotal + this.totalTax; },
        get totalHours() { return this.placedBlocks.reduce((s, b) => s + (b.hours || 0) * (b.quantity || 1), 0); },

        get filteredCategories() {
            if (!this.search.trim()) return this.categories;
            const q = this.search.toLowerCase();
            return this.categories
                .map(cat => ({
                    ...cat,
                    blocks: cat.blocks.filter(b =>
                        b.name.toLowerCase().includes(q) ||
                        (b.description || '').toLowerCase().includes(q)
                    )
                }))
                .filter(cat => cat.blocks.length > 0);
        },

        /* ── Init ── */
        init() {
            this.loadBlocks();
            this.loadState();
            this.$nextTick(() => this.setupInteract());
            this.setupKeys();
            this.saveHistory();
        },

        /* ── API ── */
        async loadBlocks() {
            this.isLoadingBlocks = true;
            try {
                const r = await fetch('/api/quote-blocks', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!r.ok) throw new Error('HTTP ' + r.status);
                const data = await r.json();
                if (!data.success) throw new Error('Server error');
                this.categories = (data.categories || []).map(c => ({ ...c, expanded: true }));
            } catch (e) {
                console.error(e);
                this.toast('Error al cargar servicios', 'error');
            } finally {
                this.isLoadingBlocks = false;
            }
        },

        /* ── Drag & Drop ── */
        onDragStart(e, block) {
            e.dataTransfer.setData('text/plain', JSON.stringify(block));
            e.dataTransfer.effectAllowed = 'copy';
        },
        onDragEnd(e) {},

        onCanvasDrop(e) {
            try {
                const block = JSON.parse(e.dataTransfer.getData('text/plain'));
                const vp = document.getElementById('canvas-vp');
                const rect = vp.getBoundingClientRect();
                const x = (e.clientX - rect.left + vp.scrollLeft) / this.zoom - 129;
                const y = (e.clientY - rect.top  + vp.scrollTop)  / this.zoom - 40;
                this.addBlockAt(block, x, y);
            } catch(err) { console.error(err); }
        },

        /* ── Agregar bloque ── */
        addBlockAt(blockData, x, y) {
            // Si no hay posición, colocar en cascada
            const offset = this.placedBlocks.length * 20;
            const px = x !== null ? Math.max(0, x) : 40 + offset;
            const py = y !== null ? Math.max(0, y) : 40 + offset;

            const blk = {
                ...blockData,
                iid:        'b_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5),
                quantity:   1,
                hours:      blockData.default_hours || 20,
                x: px, y: py,
                z:          10 + this.placedBlocks.length,
                dragging:   false,
                totalPrice: 0
            };
            this.recalc(blk);
            this.placedBlocks.push(blk);
            this.saveHistory();

            // Cerrar sidebar en móvil
            if (window.innerWidth < 769) this.sidebarOpen = false;
            this.toast(blockData.name + ' agregado', 'success');
        },

        recalc(blk) {
            const dh = blk.default_hours || 20;
            const pph = blk.base_price / dh;
            const hExtra = Math.max(0, blk.hours - dh);
            blk.totalPrice = (blk.base_price + hExtra * pph * 1.5) * (blk.quantity || 1);
        },

        /* ── Gestión bloques ── */
        removeBlock(iid) {
            this.placedBlocks = this.placedBlocks.filter(b => b.iid !== iid);
            this.saveHistory();
            this.toast('Bloque eliminado', 'warning');
        },

        dupBlock(iid) {
            const orig = this.placedBlocks.find(b => b.iid === iid);
            if (!orig) return;
            const dup = { ...JSON.parse(JSON.stringify(orig)),
                iid:     'b_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5),
                x: orig.x + 24, y: orig.y + 24,
                z:       10 + this.placedBlocks.length,
                dragging: false
            };
            this.placedBlocks.push(dup);
            this.saveHistory();
            this.toast('Bloque duplicado', 'success');
        },

        /* ── Zoom ── */
        zoomIn()  { if (this.zoom < 2)   this.zoom = Math.round((this.zoom + 0.1) * 10) / 10; },
        zoomOut() { if (this.zoom > 0.4) this.zoom = Math.round((this.zoom - 0.1) * 10) / 10; },

        /* ── Historia ── */
        saveHistory() {
            if (this.history.length > 40) { this.history.shift(); this.historyIdx = Math.max(0, this.historyIdx - 1); }
            this.history = this.history.slice(0, this.historyIdx + 1);
            this.history.push({ blocks: JSON.parse(JSON.stringify(this.placedBlocks)), zoom: this.zoom });
            this.historyIdx = this.history.length - 1;
            this.saveState();
        },
        undo() {
            if (this.historyIdx <= 0) return;
            this.historyIdx--;
            const s = this.history[this.historyIdx];
            this.placedBlocks = JSON.parse(JSON.stringify(s.blocks));
            this.zoom = s.zoom;
            this.toast('Deshecho', 'info');
        },
        redo() {
            if (this.historyIdx >= this.history.length - 1) return;
            this.historyIdx++;
            const s = this.history[this.historyIdx];
            this.placedBlocks = JSON.parse(JSON.stringify(s.blocks));
            this.zoom = s.zoom;
            this.toast('Rehecho', 'info');
        },

        /* ── Persistencia local ── */
        loadState() {
            try {
                const saved = localStorage.getItem('qb_state');
                if (saved) {
                    const s = JSON.parse(saved);
                    this.placedBlocks = s.blocks || [];
                    this.zoom = s.zoom || 1;
                    this.placedBlocks.forEach(b => this.recalc(b));
                }
            } catch(e) {}
        },
        saveState() {
            try {
                localStorage.setItem('qb_state', JSON.stringify({ blocks: this.placedBlocks, zoom: this.zoom }));
            } catch(e) {}
        },

        clearCanvas() {
            if (this.placedBlocks.length === 0) return;
            if (!confirm('¿Limpiar toda la cotización?')) return;
            this.placedBlocks = [];
            this.saveHistory();
            this.toast('Canvas limpiado', 'info');
        },

        /* ── Interact.js drag en canvas ── */
        setupInteract() {
            if (typeof interact === 'undefined') return;
            interact('.d-block').draggable({
                listeners: {
                    start: e => {
                        const b = this.placedBlocks.find(b => b.iid === e.target.dataset.iid);
                        if (b) { b.dragging = true; b.z = 100 + this.placedBlocks.length; }
                    },
                    move: e => {
                        const b = this.placedBlocks.find(b => b.iid === e.target.dataset.iid);
                        if (!b) return;
                        b.x += e.dx / this.zoom;
                        b.y += e.dy / this.zoom;
                        b.x = Math.max(0, Math.min(b.x, 1740));
                        b.y = Math.max(0, Math.min(b.y, 1880));
                    },
                    end: e => {
                        const b = this.placedBlocks.find(b => b.iid === e.target.dataset.iid);
                        if (b) { b.dragging = false; b.z = 10; this.saveHistory(); }
                    }
                }
            });
        },

        /* ── Teclado ── */
        setupKeys() {
            document.addEventListener('keydown', e => {
                const inInput = ['INPUT','TEXTAREA','SELECT'].includes(document.activeElement.tagName);
                if (inInput) return;
                if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) { e.preventDefault(); this.undo(); }
                if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) { e.preventDefault(); this.redo(); }
            });
        },

        /* ── Envío ── */
        async submitQuote() {
            if (!this.form.name || !this.form.email) {
                this.toast('Completa nombre y correo', 'error');
                return;
            }
            this.isSubmitting = true;
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const payload = {
                    client: {
                        name:    this.form.name,
                        email:   this.form.email,
                        phone:   this.form.phone,
                        company: this.form.company,
                        additional_requirements: this.form.notes
                    },
                    blocks: this.placedBlocks.map(b => ({
                        id: b.id, name: b.name, type: b.type,
                        quantity: b.quantity, hours: b.hours,
                        base_price: b.base_price, total_price: b.totalPrice, totalPrice: b.totalPrice,
                        description: b.description || '', config: b.config || {}
                    })),
                    summary: { subtotal: this.subtotal, tax: this.totalTax, total: this.totalCost, hours: this.totalHours }
                };
                const r = await fetch('/api/quotes/submit', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await r.json();
                if (!r.ok || !data.success) throw new Error(data.message || 'Error del servidor');
                this.quoteRef = data.reference || String(Date.now()).slice(-6);
                this.showSubmit  = false;
                this.showSuccess = true;
                this.form = { name: '', email: '', phone: '', company: '', notes: '' };
            } catch(e) {
                this.toast(e.message || 'Error al enviar', 'error');
            } finally {
                this.isSubmitting = false;
            }
        },

        /* ── Toasts ── */
        toast(msg, type = 'info') {
            const wrap = document.getElementById('toast-wrap');
            if (!wrap) return;
            const el = document.createElement('div');
            el.className = `toast ${type}`;
            el.textContent = msg;
            wrap.appendChild(el);
            setTimeout(() => el.remove(), 3500);
        },

        /* ── Formato moneda ── */
        fmt(v) {
            return new Intl.NumberFormat('es-MX', {
                style: 'currency', currency: 'MXN',
                minimumFractionDigits: 0, maximumFractionDigits: 0
            }).format(v || 0);
        }
    };
}
</script>
</body>
</html>