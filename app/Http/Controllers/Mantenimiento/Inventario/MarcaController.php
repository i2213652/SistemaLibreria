<?php

namespace App\Http\Controllers\Mantenimiento\Inventario;

use App\Http\Controllers\Controller;

use App\Models\Mantenimiento\Inventario\Marca;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;


class MarcaController extends Controller
{
    public function marcas()
    {
        return Inertia::render('Mantenimiento/Inventario/marcas');
    }

    public function get($solo_habilitado = false)
    {
        $response = new \stdClass();

        if ($solo_habilitado) {
            $marcas = Marca::where('habilitado', 1)
                ->orderBy('marca', 'asc')
                ->get();
        } else {
            $marcas = Marca::orderBy('marca', 'asc')
                ->get();
        }

        $response->success = true;
        $response->data = $marcas;

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $response = new \stdClass();

        $frmMarca = $request->frmMarca;

        $marca = new Marca();
        $marca->marca = mb_strtoupper($frmMarca['marca']);
        $marca->save();

        $response->success = true;
        $response->data = $marca;

        return response()->json($response, 200);
    }

    public function update($id, Request $request)
    {
        $response = new \stdClass();

        $frmMarca = $request->frmMarca;

        $marca = Marca::find($id);

        $marca->marca = mb_strtoupper($frmMarca['marca']);
        $marca->habilitado = $frmMarca['habilitado'];
        $marca->save();

        $response->success = true;
        $response->data = $marca;

        return response()->json($response, 200);
    }
}
