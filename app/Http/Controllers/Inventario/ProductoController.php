<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;

use App\Models\Inventario\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;


class ProductoController extends Controller
{

    public function productos()
    {
        return Inertia::render('Inventario/productos');
    }

    public function get()
    {
        $response = new \stdClass();

        $productos = Producto::orderBy('id', 'asc')
            ->get();

        $response->success = true;
        $response->data = $productos;

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $response = new \stdClass();

        $frmProducto = $request->frmProducto;

        $producto = new Producto();

        $producto->descripcion = mb_strtoupper($frmProducto['descripcion']);
        $producto->cantidad = $frmProducto['cantidad'];
        $producto->marca_id = $frmProducto['marca_id'];
        $producto->categoria_id = $frmProducto['categoria_id'];
        $producto->precio_compra = $frmProducto['precio_compra'];
        $producto->precio_venta = $frmProducto['precio_venta'];

        $producto->save();

        $id = $producto->id;

        $codigo = 'P' . (str_pad(strval(intval($id)), 4, "0", STR_PAD_LEFT));
        $producto->codigo = $codigo;
        Producto::where('id', $id)->update(['codigo' => $codigo]);

        $response->success = true;
        $response->data = $producto;

        return response()->json($response, 200);
    }

    public function update($id, Request $request)
    {
        $response = new \stdClass();

        $frmProducto = $request->frmProducto;

        $producto = Producto::find($id);

        $producto->precio_compra = $frmProducto['precio_compra'];
        $producto->precio_venta = $frmProducto['precio_venta'];

        $producto->save();

        $response->success = true;
        $response->data = $producto;

        return response()->json($response, 200);
    }

    public function delete($id)
    {
        $response = new \stdClass();

        $sector = Producto::find($id);
        $sector->delete();

        $response->success = true;

        return response()->json($response, 200);
    }
}
