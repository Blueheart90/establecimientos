<?php

namespace App\Http\Controllers;


use App\Image as Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    //

    public function store(Request $request)
    {
        // Leer la imagen
        $ruta_imagen = $request->file('file')->store('establecimientos', 'public');

        // Resize
        $imagen = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 450);
        $imagen->save();

        // Almacenar con model
        $imagenDB = new Images;
        $imagenDB->id_establecimiento = $request['uuid'];
        $imagenDB->ruta_imagen = $ruta_imagen;
        $imagenDB->save();

        // Retornar respuesta
        $respuesta = [
            'archivo' => $ruta_imagen
        ];


        // return $request->all();
        // return $ruta_imagen;

        // se debe utilizar el formato json (objeto) pues los arreglos asociativos no existen como tal en js
        return response()->json($respuesta);
    }

    // Eliminar imagen
    public function destroy(Request $request)
    {

        $imagen = $request->get('imagen');

        if(File::exists('storage/' . $imagen)) {

            // Eliminar imagen del servidor
            File::delete('storage/' . $imagen);

            // Eliminar imagen de la BD
            Images::where('ruta_imagen', '=', $imagen)->delete();


            $respuesta = [
                'imagen' => $imagen,
                'mensaje' => 'Imagen eliminada'
            ];

        }else{

            $respuesta = [
                'imagen' => $imagen,
                'mensaje' => 'No fue posible eliminar la imagen'
            ];
        }


        return response()->json($respuesta);
    }
}
