<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use App\Image;
use Illuminate\Http\Request;

class APIController extends Controller
{
    // Método para obtener todos los Establecimientos
    public function index() {
        // $establecimientos =  Establecimiento::all();
        // Eager Loading
        $establecimientos =  Establecimiento::with('categoria')->get();
        return response()->json($establecimientos);
    }

    // Método para obtener todas las categorias
    public function categorias()
    {
        $categorias = Categoria::all();

        // Al ser una API se debe retornar en tipo json
        return response()->json($categorias);
    }

    // Muestra los estab de cada categoria. limit 3
    public function categoria(Categoria $categoria)
    {
        // Eager Loading con witch  nos tremos la relacion con categoria
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->take(3)->get();

        return response()->json($establecimientos);
    }
    // Muestra los estab de cada categoria sin limit
    public function establecimientoscategoria(Categoria $categoria)
    {
        // Eager Loading con witch  nos tremos la relacion con categoria
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->get();

        return response()->json($establecimientos);
    }

    // Muestra un establecimiento en especifico
    public function show(Establecimiento $establecimiento )
    {
        $imagenes = Image::where('id_establecimiento', $establecimiento->uuid)->get();

        // Agregamos las imagenes que coincidan con el establecimiento al objeto establecimiento
        $establecimiento->imagenes = $imagenes;

        return response()->json($establecimiento);
    }


}
