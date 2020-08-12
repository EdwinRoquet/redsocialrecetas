<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except'=> 'show']);
    }


    public function show(Perfil $perfil)
    {
    //Obtener la recetas con paginación
    $recetas = Receta::where('user_id', $perfil->user_id)->paginate(3);

        return view('perfiles.show', compact('perfil', 'recetas'));
    }


    public function edit(Perfil $perfil)
    {
        $this->authorize('view', $perfil);
        return view('perfiles.edit', compact('perfil'));
    }


    public function update(Request $request, Perfil $perfil)
    {
        //Ejecutar el polocy
        $this->authorize('update', $perfil);

        /** Validar **/
        $data = request()->validate([
          'nombre'=> 'required',
          'url' => 'required',
          'biografia'=> 'required',
        ]);

        /** Si el usuario sube de la imagen **/
        if(request('imagen')){

            //obtener la ruta de la imagen
            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
            //Resize de la imagen
            $img = Image::make( public_path("storage/${ruta_imagen}"))->fit(600,600);
            $img->save();
            //Asignar al objeto
            $array_imagen  = ['imagen' => $ruta_imagen];
        }


        /** Asignar nombre y URL **/
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        /** Eliminar url y name de $data **/
        unset($data['url']);
        unset($data['nombre']);

        // dd($data);
        /** Guardar la informacion **/
        /** Asignar Biografia e imagen **/
        auth()->user()->perfil()->update( array_merge(
            $data,
            $array_imagen ?? []
        ));


        /** Redireccionar **/
        return redirect()->action('RecetaController@index');
    }


}
