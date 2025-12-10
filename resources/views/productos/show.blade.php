@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-neon mb-4">{{ $producto->nombre }}</h1>

    <div class="card producto-card shadow-sm">
        @if($producto->imagen && file_exists(public_path('imagenes/' . $producto->imagen)))
            <img src="{{ asset('imagenes/' . $producto->imagen) }}" 
                 class="card-img-top" 
                 alt="{{ $producto->nombre }}" 
                 style="max-height: 400px; object-fit: cover;">
        @else
            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                <i class="bi bi-image text-light" style="font-size: 3rem;"></i>
            </div>
        @endif

        <div class="card-body">
            <h5 class="card-title text-neon">{{ $producto->nombre }}</h5>
            
            {{-- Categoría --}}
            @if($producto->categoria)
                <span class="badge bg-info mb-2">{{ $producto->categoria }}</span>
            @endif

            <p class="card-text text-light">{{ $producto->descripcion }}</p>
            
            <p class="card-text fw-bold">
                <strong>Precio:</strong> 
                <span class="text-neon">{{ $producto->precio_formateado }}</span>
            </p>

            {{-- Stock --}}
            <p class="card-text">
                <strong>Stock:</strong> 
                <span class="badge bg-success">{{ $producto->stock }}</span>
            </p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">⬅ Volver al catálogo</a>
        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">✏️ Editar</a>
        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑️ Eliminar</button>
        </form>
    </div>
</div>
@endsection
