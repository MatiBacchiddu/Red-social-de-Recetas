<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
    public function index()
    {
        //obtener nuevas recetas
        $nuevas = Receta::latest()->take(6)->get();

        // Obtener todas las categorias
        $categorias = CategoriaReceta::all(); // CategoriaReceta es el modelo
        //return $categorias;
        // agrupar recetas por cat
        $recetas = [];

        foreach($categorias as $categoria){
            $recetas[Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id)->take(3)->get();
        }

        //return $recetas;


        return view('inicio.index', compact('nuevas', 'recetas'));
    }
}
