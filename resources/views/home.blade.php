@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Banner de bienvenida -->
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-5 fw-bold">¡Bienvenido a Auklet Technology!</h1>
            <p class="fs-4">Encuentra los mejores productos al mejor precio.</p>
            <p class="text-success fw-bold">🚚 ¡Envío gratis en compras mayores a $500!</p>
            <a href="{{ route('productos.index') }}" class="btn btn-primary btn-lg">Ver catálogo</a>
        </div>
    </div>

    <!-- Listado de productos -->
    @if($productos->count())
        <div class="row">
            @foreach($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($producto->imagen)
                            <img src="{{ $producto->imagen }}" class="card-img-top" alt="{{ $producto->nombre }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text">{{ Str::limit($producto->descripcion, 80) }}</p>
                            <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
                            <a href="{{ route('productos.show', $producto) }}" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay productos disponibles por ahora.</p>
    @endif
</div>
@endsection
