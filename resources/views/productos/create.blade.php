@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-neon mb-4">➕ Crear Producto</h1>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>❌ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="p-4 producto-card">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label text-neon">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" 
                   value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label text-neon">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label text-neon">Precio</label>
            <input type="number" step="0.01" id="precio" name="precio" class="form-control" 
                   value="{{ old('precio') }}" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label text-neon">Imagen del producto</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
            <small class="text-light">Formatos permitidos: JPG, PNG, GIF (máx. 2MB).</small>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">✅ Crear producto</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">⬅ Volver</a>
        </div>
    </form>
</div>
@endsection
