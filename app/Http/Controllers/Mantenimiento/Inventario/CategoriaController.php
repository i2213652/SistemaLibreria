<?php

namespace App\Http\Controllers\Mantenimiento\Inventario;

use App\Http\Controllers\Controller;

use App\Models\Mantenimiento\Inventario\Categoria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;


class CategoriaController extends Controller
{
    public function categorias()
    {
        return Inertia::render('Mantenimiento/Inventario/categorias');
    }
    public function get($solo_habilitado = false)
    {
        $response = new \stdClass();

        if ($solo_habilitado) {
            $categorias = Categoria::where('habilitado', 1)
                ->orderBy('categoria', 'asc')
                ->get();
        } else {
            $categorias = Categoria::orderBy('categoria', 'asc')
                ->get();
        }

        $response->success = true;
        $response->data = $categorias;

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $response = new \stdClass();

        $frmCategoria = $request->frmCategoria;

        $categoria = new Categoria();
        $categoria->categoria = mb_strtoupper($frmCategoria['categoria']);
        $categoria->save();

        $response->success = true;
        $response->data = $categoria;

        return response()->json($response, 200);
    }

    public function update($id, Request $request)
    {
        $response = new \stdClass();

        $frmCategoria = $request->frmCategoria;

        $categoria = Categoria::find($id);

        $categoria->categoria = mb_strtoupper($frmCategoria['categoria']);
        $categoria->habilitado = $frmCategoria['habilitado'];
        $categoria->save();

        $response->success = true;
        $response->data = $categoria;

        return response()->json($response, 200);
    }
}
