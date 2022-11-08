<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'inventario_productos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'codigo',
        'descripcion',
        'cantidad',
        'marca_id',
        'categoria_id',
        'precio_compra',
        'precio_venta',

        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];
}
