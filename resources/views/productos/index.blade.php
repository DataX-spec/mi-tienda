@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-neon">📦 Catálogo de Productos</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Crear Producto
            </a>
        </div>
    </div>

    {{-- Mensajes de éxito o error --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Verificar si hay productos --}}
    @if ($productos->count() > 0)
        <div class="row">
            @foreach ($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card producto-card h-100">
                        {{-- Imagen del producto --}}
                        @if ($producto->imagen)
                            <img src="{{ asset('imagenes/' . $producto->imagen) }}"
                                 class="card-img-top img-fluid"
                                 alt="{{ $producto->nombre }}"
                                 style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('imagenes/default.jpg') }}"
                                 class="card-img-top img-fluid"
                                 alt="Sin imagen"
                                 style="height: 250px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-neon">{{ $producto->nombre }}</h5>
                            
                            {{-- Categoría --}}
                            @if ($producto->categoria)
                                <span class="badge bg-info mb-2">{{ $producto->categoria }}</span>
                            @endif

                            {{-- Descripción --}}
                            <p class="card-text text-light">
                                {{ Str::limit($producto->descripcion, 100) }}
                            </p>

                            {{-- Precio --}}
                            <p class="card-text fw-bold">
                                <span class="text-neon">{{ $producto->precio_formateado }}</span>
                            </p>

                            {{-- Stock --}}
                            <p class="card-text">
                                Stock: <span class="badge bg-success">{{ $producto->stock }}</span>
                            </p>

                            {{-- Botones de acción --}}
                            <div class="mt-auto">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $productos->links() }}
        </div>
    @else
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-inbox"></i> No hay productos disponibles por ahora.
            <br>
            <a href="{{ route('productos.create') }}" class="btn btn-primary mt-3">
                Crear primer producto
            </a>
        </div>
    @endif
</div>
@endsection
