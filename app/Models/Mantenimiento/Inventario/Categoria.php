<?php

namespace App\Models\Mantenimiento\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'inventario_categorias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'categoria',
        'habilitado',

        'created_at',
        'updated_at'
    ];
}
