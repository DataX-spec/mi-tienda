<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;

class ProductoController extends Controller
{
    /**
     * Página principal -> muestra productos
     */
    public function home()
    {
        try {
            if (!Schema::hasTable('productos')) {
                return view('productos.index', ['productos' => collect()]);
            }
            $productos = Producto::latest()->paginate(12);
        } catch (\Exception $e) {
            $productos = collect(); // vacío si falla
        }

        if (!view()->exists('productos.index')) {
            abort(500, 'La vista productos.index no existe');
        }

        return view('productos.index', compact('productos'));
    }

    /**
     * Listar todos los productos
     */
    public function index()
    {
        try {
            if (!Schema::hasTable('productos')) {
                return view('productos.index', ['productos' => collect()]);
            }
            $productos = Producto::latest()->paginate(15);
        } catch (\Exception $e) {
            $productos = collect();
        }

        return view('productos.index', compact('productos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        if (!view()->exists('productos.create')) {
            abort(500, 'La vista productos.create no existe');
        }
        return view('productos.create');
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        try {
            if (!Schema::hasTable('productos')) {
                return back()->with('error', '❌ La tabla productos no está disponible. Verifica las migraciones.');
            }

            $validated = $request->validate([
                'nombre' => ['required', 'string', 'max:255', 'unique:productos,nombre'],
                'descripcion' => ['nullable', 'string'],
                'precio' => ['required', 'numeric', 'min:0'],
                'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'categoria' => ['nullable', 'string', 'max:100'],
                'stock' => ['required', 'integer', 'min:0'],
            ]);

            // Procesar imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = $imagen->getClientOriginalName();
                $rutaDestino = public_path('imagenes');

                if (!file_exists($rutaDestino)) {
                    mkdir($rutaDestino, 0755, true);
                }
                if (!is_writable($rutaDestino)) {
                    return back()->with('error', '❌ No se puede escribir en la carpeta de imágenes.');
                }

                $finalName = $nombreImagen;
                if (file_exists($rutaDestino . DIRECTORY_SEPARATOR . $finalName)) {
                    $finalName = pathinfo($nombreImagen, PATHINFO_FILENAME) . '_' . time() . '.' . $imagen->getClientOriginalExtension();
                }

                $imagen->move($rutaDestino, $finalName);
                $validated['imagen'] = $finalName;
            }

            Producto::create($validated);

            return redirect()->route('productos.index')
                ->with('success', '✅ Producto creado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al crear: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar detalle de un producto
     */
    public function show($id)
    {
        try {
            $producto = Producto::findOrFail($id);
        } catch (\Exception $e) {
            abort(404, 'Producto no encontrado');
        }

        if (!view()->exists('productos.show')) {
            abort(500, 'La vista productos.show no existe');
        }

        return view('productos.show', compact('producto'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        try {
            $producto = Producto::findOrFail($id);
        } catch (\Exception $e) {
            abort(404, 'Producto no encontrado');
        }

        if (!view()->exists('productos.edit')) {
            abort(500, 'La vista productos.edit no existe');
        }

        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, $id)
    {
        try {
            if (!Schema::hasTable('productos')) {
                return back()->with('error', '❌ La tabla productos no está disponible. Verifica las migraciones.');
            }

            $producto = Producto::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:productos,nombre,' . $id,
                'precio' => 'required|numeric|min:0.01|max:999999.99',
                'descripcion' => 'nullable|string|max:1000',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'categoria' => ['nullable', 'string', 'max:100'],
                'stock' => ['required', 'integer', 'min:0'],
            ]);

            // Procesar imagen
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = $imagen->getClientOriginalName();
                $rutaDestino = public_path('imagenes');

                if (!file_exists($rutaDestino)) {
                    mkdir($rutaDestino, 0755, true);
                }
                if (!is_writable($rutaDestino)) {
                    return back()->with('error', '❌ No se puede escribir en la carpeta de imágenes.');
                }

                $finalName = $nombreImagen;
                if (file_exists($rutaDestino . DIRECTORY_SEPARATOR . $finalName)) {
                    $finalName = pathinfo($nombreImagen, PATHINFO_FILENAME) . '_' . time() . '.' . $imagen->getClientOriginalExtension();
                }

                $imagen->move($rutaDestino, $finalName);
                $validated['imagen'] = $finalName;

                // Eliminar imagen antigua si existe y es distinta
                if ($producto->imagen && $producto->imagen !== $finalName) {
                    $oldPath = public_path('imagenes/' . $producto->imagen);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
            }

            $producto->update($validated);

            return redirect()->route('productos.index')
                ->with('success', '✅ Producto actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Eliminar producto
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $nombre = $producto->nombre;

            // Eliminar imagen si existe
            if ($producto->imagen && file_exists(public_path('imagenes/' . $producto->imagen))) {
                @unlink(public_path('imagenes/' . $producto->imagen));
            }

            $producto->delete();

            return redirect()->route('productos.index')
                ->with('success', "✅ '$nombre' eliminado correctamente.");
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Buscar productos con filtros
     */
    public function search(Request $request)
    {
        try {
            if (!Schema::hasTable('productos')) {
                return view('productos.index', ['productos' => collect()]);
            }

            $q = $request->input('q');
            $categoria = $request->input('categoria');
            $min = $request->input('min');
            $max = $request->input('max');

            $productos = Producto::query()
                ->when($q, fn($query) =>
                    $query->where(function($sub) use ($q) {
                        $sub->where('nombre', 'like', "%{$q}%")
                            ->orWhere('descripcion', 'like', "%{$q}%");
                    })
                )
                ->when($categoria, fn($query) =>
                    $query->where('categoria', $categoria)
                )
                ->when(strlen($min ?? '') > 0, fn($query) =>
                    $query->where('precio', '>=', (float) $min)
                )
                ->when(strlen($max ?? '') > 0, fn($query) =>
                    $query->where('precio', '<=', (float) $max)
                )
                ->latest()
                ->paginate(15)
                ->appends($request->query());

            return view('productos.index', compact('productos'));
        } catch (\Exception $e) {
            return view('productos.index', ['productos' => collect()]);
        }
    }
}
