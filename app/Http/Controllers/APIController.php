<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use Illuminate\Http\Request;

class APIController extends Controller
{
    // Método para obtener todas las categorias
    public function categorias()
    {
        $categorias = Categoria::all();

        // Al ser una API se debe retornar en tipo json
        return response()->json($categorias);
    }

    // Muestra los estab de cada categoria
    public function categoria(Categoria $categoria)
    {
        // Eager Loading con witch  nos tremos la relacion con categoria
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->get();

        return response()->json($establecimientos);
    }
}
