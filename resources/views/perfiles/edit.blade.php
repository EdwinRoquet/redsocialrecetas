@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.css" integrity="sha256-scOSmTNhvwKJmV7JQCuR7e6SQ3U9PcJ5rM/OMgL78X8=" crossorigin="anonymous" />
@endsection

@section('botones')

<a href="{{ route('recetas.index') }}" class="btn btn-outline-primary text-uppercase mt-2 font-weight-bold mt-2">
    <svg class="icono" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Volver</a>
@endsection

@section('content')

   <h1 class="text-center">Editar Mi Perfil</h1>

<div class="row justify-content-center mt-5">
    <div class="col-md-10 bg-white p-3">
    <form action="{{route('perfiles.update', ['perfil'=> $perfil->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
              <input type="text"
                   name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   id="nombre"
                   value="{{ $perfil->usuario->name}}"
                   placeholder="Tu Nombre">
            @error('nombre')
                <span class="invalid-feedback d-block" role="alert">
                <strong>{{$message}}</strong>
                </span>
            @enderror
          </div>

        <div class="form-group">
            <label for="url">Tu sitio Web</label>
              <input type="text"
                   name="url"
                   class="form-control @error('url') is-invalid @enderror"
                   id="url"
                   value="{{ $perfil->usuario->url}}"
                   placeholder="Tu Sitio Web">
            @error('url')
                <span class="invalid-feedback d-block" role="alert">
                <strong>{{$message}}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group mt-3">
            <label for="biografia">Biografia</label>
        <input type="hidden" name="biografia" id="biografia" value="{{ $perfil->biografia}}">
        <trix-editor class="form-control  @error('biografia') is-invalid @enderror" input="biografia"></trix-editor>
        @error('biografia')
             <span class="invalid-feedback d-block" role="alert">
             <strong>{{$message}}</strong>
             </span>
             @enderror
        </div>
        @if( $perfil->imagen )
               <div class="mt-4">
                <p>Imagen Actual:</p>
               <img src="/storage/{{$perfil->imagen}}"style="width:300px" >
               </div>

        @endif

       <div class="form-group mt-3">

           <label for="imagen">Tu imagen</label>
           <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror">
           @error('imagen')
            <span class="invalid-feedback d-block" role="alert">
            <strong>{{$message}}</strong>
            </span>
            @enderror
       </div>

       <div class="form-group">
           <input type="submit" class="btn btn-primary" value="Agregar Receta">
       </div>

       </form>
    </div>
</div>

@endsection

@section('scripts')
   <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.js" integrity="sha256-b2QKiCv0BXIIuoHBOxol1XbUcNjWqOcZixymQn9CQDE=" crossorigin="anonymous" defer></script>
@endsection
