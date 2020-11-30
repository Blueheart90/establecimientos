<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use App\Image as AppImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class EstablecimientoController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Consultar las Categorias
        $categorias = Categoria::all();
        return  view('establecimientos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id', // Comproba que dicha id exista en la tabla categoria
            'imagen_principal' => 'required|image|max:1000',
            'direccion' => 'required||min:6',
            'barrio' => 'required|min:6',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:50',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);

        // Guardar imagen
        $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

        // Resize
        $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(800, 600);
        $img->save();

        // Agregando la ruta de la imagen ppal al array validado
        $validatedData['imagen_principal'] = $ruta_imagen;

        // Agregando a la DB
        auth()->user()->establecimiento()->create($validatedData);

        return back()->with('estado', 'Tu informacion se almaceno correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {
        //
        // Consultar las Categorias
        $categorias = Categoria::all();

        // Obtener el establecimiento del usuario
        $establecimiento = Auth()->user()->establecimiento;

        // Evitar  problemas con algunos navegadores en el formato de hora
        $establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura) );
        $establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre) );

        // Obtiene las imagenes del establecimiento
        $imagenes = AppImage::where('id_establecimiento', $establecimiento->uuid)->get();

        return view('establecimientos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establecimiento $establecimiento)
    {
        // Ejecutar el policy
        $this->authorize('update', $establecimiento);

        $validatedData = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id', // Comproba que dicha id exista en la tabla categoria
            'imagen_principal' => 'image|max:1000',
            'direccion' => 'required||min:6',
            'barrio' => 'required|min:6',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:50',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);

        if ($request['imagen_principal']) {

            $oldImg = $establecimiento->imagen_principal;

            if (File::exists('storage/' . $oldImg)) {

                // Eliminar imagen del servidor
                File::delete('storage/' . $oldImg);
            }



            // Guardar imagen
            $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

            // Resize
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(800, 600);
            $img->save();

            // Agregando la ruta de la imagen ppal al array validado
            $validatedData['imagen_principal'] = $ruta_imagen;



        }

        $establecimiento->update($validatedData);

        return back()->with('estado', 'Tu informacion se almaceno correctamente');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
