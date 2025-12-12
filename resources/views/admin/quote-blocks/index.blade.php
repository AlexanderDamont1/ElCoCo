@extends('admin.layouts.app')

@section('title', 'Bloques de Cotización')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Bloques de Cotización</h1>
        <a href="{{ route('admin.quote-blocks.create') }}" class="btn btn-primary">
            + Nuevo Bloque
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    @foreach($categories as $category)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <span>
                    <strong>{{ $category->name }}</strong>
                    @if(!$category->is_active)
                        <span class="badge bg-secondary">inactiva</span>
                    @endif
                </span>
                <span class="badge bg-info text-dark">
                    {{ $category->blocks->count() }} bloques
                </span>
            </div>

            @if($category->description)
                <div class="card-body">
                    <p class="text-muted mb-0">{{ $category->description }}</p>
                </div>
            @endif

            @if($category->blocks->count())
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Precio base</th>
                            <th>Horas por default</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->blocks as $block)
                            <tr>
                                <td>{{ $block->name }}</td>
                                <td>{{ $block->type }}</td>
                                <td>${{ number_format($block->base_price, 2) }}</td>
                                <td>{{ $block->default_hours }}</td>
                                <td class="text-end">

                                    <a href="{{ route('admin.quote-blocks.edit', $block) }}" class="btn btn-sm btn-outline-secondary">
                                        Editaaar
                                    </a>

                                    <form action="{{ route('admin.quote-blocks.destroy', $block) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body text-muted">
                    No existen bloques en esta categoría
                </div>
            @endif
        </div>
    @endforeach

</div>
@endsection
