<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    use HasFactory;

    // Tabla asociada (opcional)
    protected $table = 'productos';

    // Campos asignables
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'categoria',
        'stock',
    ];

    // Casting de tipos
    protected $casts = [
        'precio' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accesor para precio formateado: maneja nulls
    public function getPrecioFormateadoAttribute(): string
    {
        $precio = $this->precio ?? 0.0;
        return '$' . number_format((float) $precio, 2);
    }

    // Attribute mutator / accessor para asegurar float
    protected function precio(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_null($value) ? null : (float) $value,
            set: fn($value) => is_null($value) ? null : (float) $value
        );
    }
}
