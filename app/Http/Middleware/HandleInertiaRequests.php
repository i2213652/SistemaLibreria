<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\DB;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $x = session()->all();

        if (empty($x['id'])) {
            $permisos_array = null;
            $permisos_object = null;
            $sedes = null;
            $datos_cuenta = null;
            $datos_caja = null;
        } else {

            $permisos = DB::table('usuario_permisos as usu_per')
                ->select(
                    'usu_per.permiso_id',
                    'usu_per.acceso_sedes',

                    'per.modulo',
                    'per.submodulo'
                )
                ->join('permisos as per', 'usu_per.permiso_id',  'per.id')
                ->where('usu_per.usuario_id', session('id'))
                ->get();

            $permisos_array = [];
            $permisos_object = [];
            foreach ($permisos as $permiso) {
                $permisos_array[] = $permiso->modulo . '/' . $permiso->submodulo;
                $permisos_object[] = [
                    'permiso_id' => $permiso->permiso_id,
                    'permiso' => $permiso->modulo . '/' . $permiso->submodulo,
                    'acceso_sedes' => $permiso->acceso_sedes
                ];
            }

            $sedes = DB::table('sedes as sed')->select(
                'sed.id',
                'sed.sede',
                'sed.direccion',
                'dis.distrito'
            )
                ->join('distritos as dis', 'sed.distrito_id', 'dis.id')
                ->orderBy('sed.sede', 'asc')
                ->get();


            $conexion = 'master_' .  session('sede_id');

            $datos_cuenta = DB::connection($conexion)->table('cuenta_registros')
                ->where([['usuario_id', session('id')], ['con_cuenta', 1]])
                ->get()->last();

            if (empty((array)$datos_cuenta)) {
                $datos_cuenta = null;
            }
            // ----------------------------------------------------

            // Verificar si el usuario tiene una caja aperturada
            $datos_caja = DB::connection($conexion)->table('caja_registros')->where([
                ['usuario_id', session('id')],
                ['datos_cierre', null]
            ])->get()->last();

            if (empty((array)$datos_caja)) {
                $datos_caja = null;
            }
        }


        return array_merge(parent::share($request), [
            //

            'appName' => config('app.name'),

            // Lazily
            'datos_usuario' => fn () => $request->session()
                ? $request->session()->all()
                : null,

            'permisos' => fn () => $request->session()
                ?   [
                    'permisos' => $permisos_array,
                    'permisos_detalle' => $permisos_object,
                ]
                : [
                    'permisos' => null,
                    'permisos_detalle' => null,
                ],

            'sedes' => fn () => $request->session()
                ? $sedes
                : null,

            'datos_caja' => fn () => $request->session()
                ? $datos_caja
                : null,

            'datos_cuenta' => fn () => $request->session()
                ? $datos_cuenta
                : null

        ]);
    }
}
