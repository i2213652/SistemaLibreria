<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Inertia\Inertia;

class MainController extends Controller
{



    public function fecha_larga_aplicacion($agencia_id)
    {
        $conexion = 'master_' .  $agencia_id;
        // $data = Datos_aplicacion::on($conexion)->where([
        //     ['descripcion', 'FECHA_CREDITOS'],
        // ])->get()->last();

        date_default_timezone_set("America/Lima");
        $hora = date('Y-m-d H:i:s');

        // return $data->valor_fecha . ' ' . $hora;
        return $hora;
    }

    public function fecha_corta_aplicacion($agencia_id)
    {
        $conexion = 'master_' .  $agencia_id;
        // $data = Datos_aplicacion::on($conexion)->where([
        //     ['descripcion', 'FECHA_CREDITOS']

        // ])->get()->last();

        date_default_timezone_set("America/Lima");
        $fecha = date('Y-m-d');

        return $fecha;
    }

    public function verificar_nulo($value)
    {
        if (is_null($value) || empty($value) || $value == 'null') {
            return null;
        }
        return $value;
    }

    public function datos_registro($sede_id)
    {
        $fecha = $this->fecha_larga_aplicacion($sede_id);
        $usuario_id = session('id');
        // $nombre_dispositivo = session('dispositivo')->nombre;
        // $tipo_dispositivo = session('dispositivo')->tipo;

        $datos_registro = (object)[
            'fecha' => $fecha,
            'usuario_id' => $usuario_id
            // 'nombre_dispositivo' => $nombre_dispositivo,
            // 'tipo_dispositivo' => $tipo_dispositivo
        ];

        return json_encode($datos_registro);
    }



    public function nombre_dia($fecha)
    {

        switch (date('w', $fecha)) {
            case 0:
                return "Domingo";
                break;
            case 1:
                return "Lunes";
                break;
            case 2:
                return "Martes";
                break;
            case 3:
                return "Miércoles";
                break;
            case 4:
                return "Jueves";
                break;
            case 5:
                return "Viernes";
                break;
            case 6:
                return "Sábado";
                break;
        }
    }


    public function compressImage($archivo, $ruta, $calidad)
    {
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($archivo);
        $mime = $imgInfo['mime'];

        // Creamos una imagen
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($archivo);
                break;
            case 'image/png':
                $image = imagecreatefrompng($archivo);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($archivo);
                break;
            default:
                $image = imagecreatefromjpeg($archivo);
        }

        $exif = exif_read_data($archivo);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
            }
        }

        // Guardamos la imagen
        imagejpeg($image, $ruta, $calidad);

        // Devolvemos la imagen comprimida
        return true;
    }
    public function num2char($num)
    {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->num2char($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
    public function concatenar_aleatorio($string, $characters)
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $rango = 36;
        $cantidad = $characters;

        $aleatorio = '_';
        for ($i = 0; $i < $cantidad; $i++) {
            $caracter_aleatorio =  $caracteres[mt_rand(0, $rango - 1)];
            $aleatorio .= $caracter_aleatorio;
        }

        return $string . $aleatorio;
    }
}
