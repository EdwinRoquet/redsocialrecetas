<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except'=>['show', 'search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user();
        // $recetas = auth()->user()->recetas;
        // $meGusta = auth()->user()->meGusta;
        //Recetas con paginación
        $recetas = Receta::where('user_id', $usuario->id)->paginate(3);

        return view('recetas.index')
        ->with('recetas', $recetas)
        ->with('usuario', $usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::table('categoria_receta')->get()->pluck('nombre', 'id')->dd();

        //Obtner las categorias sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

    //Obtener las categorias con modelo
    $categorias = CategoriaReceta::all(['nombre', 'id']);

        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd( $request['imagen']->store('upload-recetas', 'public'));
        $data = $request->validate([
            'titulo'=> 'required|min:6',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'imagen'=>'required|image',
            'categoria'=>'required',
        ]);
        //obtener la ruta de la imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
        //Resize de la imagen
        $img = Image::make( public_path("storage/${ruta_imagen}"))->fit(1000,500);
        $img->save();
         //almacenar en la bd(sin modelo)
        // DB::table('recetas')->insert([
        //      'titulo'=> $data['titulo'],
        //      'preparacion'=> $data['preparacion'],
        //      'ingredientes'=> $data['ingredientes'],
        //      'imagen'=> $ruta_imagen,
        //      'user_id'=> Auth::user()->id,
        //      'categoria_id'=> $data['categoria'],
        // ]);

        //almacenar en la base de datos con modelo
        auth()->user()->recetas()->create([
            'titulo'=> $data['titulo'],
            'preparacion'=> $data['preparacion'],
            'ingredientes'=> $data['ingredientes'],
            'imagen'=> $ruta_imagen,
            'categoria_id'=> $data['categoria'],
        ]);

        //Redireccionar
        return redirect()->action('RecetaController@index');

        // dd( $request->all() );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
         //Obtener si el usuario actual le gusta la receta
        $like = ( auth()->user()) ? auth()->user()->meGusta->contains($receta->id)  : false;

        //Pasa la cantidad de likes a la receta
        $likes = $receta->likes->count();

        return  view('recetas.show', compact('receta','like', 'likes') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $this->authorize('view', $receta);
         //Obtener las categorias con modelo
    $categorias = CategoriaReceta::all(['nombre', 'id']);

       return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //Revisar el policy
        $this->authorize('update', $receta);
        //validacion
        $data = $request->validate([
            'titulo'=> 'required|min:6',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'categoria'=>'required',
        ]);

        //Asignar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        if(request('imagen')){

            //obtener la ruta de la imagen
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            //Resize de la imagen
            $img = Image::make( public_path("storage/${ruta_imagen}"))->fit(1000,500);
            $img->save();
            //Asignar al objeto
            $receta->imagen = $ruta_imagen;
        }

        $receta->save();


        //Redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //Ejecutar el Policy
        $this->authorize('delete', $receta);
        //Eliminar la receta
        $receta->delete();

        return redirect()->action('RecetaController@index');
    }
    public function search(Request $request)
    {
        // $busqueda = $request['buscar'];
        $busqueda = $request->get('buscar');
        $recetas = Receta::where('titulo', 'like','%' . $busqueda . '%')->paginate(2);
        $recetas->appends(['buscar' =>$busqueda]);
        return view('busquedas.show', compact('recetas','busqueda'));
    }
}
