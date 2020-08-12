<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        //Mostrar las recetas por la cantidad de votos
        //$votadas = Receta::has('likes', '>',0)->get();
        $votadas = Receta::withCount('likes')->orderBy('likes_count','desc')->take(3)->get();

        //Obtener las recetas mas nuevas
        // $nuevas = Receta::orderBy('created_at', 'DESC')->get();
        $nuevas = Receta::latest()->take(5)->get();

        $categorias = CategoriaReceta::all();
        $recetas = [];
        foreach ($categorias as $categoria) {
            $recetas [Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id)->take(3)->get();
        }
        //  return $recetas;

        return view('inicio.index', compact('nuevas', 'recetas', 'votadas'));
    }
}
