@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-neon mb-4">✏️ Editar Producto</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>❌ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="p-4 producto-card">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label text-neon">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" 
                   value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label text-neon">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label text-neon">Precio</label>
            <input type="number" step="0.01" id="precio" name="precio" class="form-control" 
                   value="{{ old('precio', $producto->precio) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-neon">Imagen actual</label><br>
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                     alt="{{ $producto->nombre }}" 
                     class="img-thumbnail mb-3" 
                     style="max-height: 200px;">
            @else
                <p class="text-muted">No hay imagen cargada.</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label text-neon">Cambiar imagen</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
            <small class="text-light">Si subes una nueva imagen, reemplazará la actual.</small>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">⬅ Volver</a>
        </div>
    </form>
</div>
@endsection
