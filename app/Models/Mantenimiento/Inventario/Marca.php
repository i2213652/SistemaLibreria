<?php

namespace App\Models\Mantenimiento\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'inventario_marcas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'marca',
        'habilitado',

        'created_at',
        'updated_at'
    ];
}
