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

<h2 class="text-center mb-5">Crear Nueva Receta</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
    <form  method="POST" action="{{ route('recetas.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="form-group">


          <label for="titulo">Titulo Receta</label>

          <input type="text"
                 name="titulo"
                 class="form-control @error('titulo') is-invalid @enderror"
                 id="titulo"
            value="{{old('titulo')}}"
                 placeholder="Titulo Receta"
          >
          @error('titulo')
              <span class="invalid-feedback d-block" role="alert">
              <strong>{{$message}}</strong>
              </span>
          @enderror
        </div>

          <div class="form-group">
              <label for="categoria">Categoria</label>
               <select name="categoria"
                       class="form-control @error('categoria') is-invalid @enderror"
                       id="categoria">
                       <option value=""> --Seleccione-- </option>
                       @foreach ($categorias as  $categoria)
          <option value="{{$categoria->id}}" {{old('categoria') == $categoria->id ? 'selected' : ''}}>{{$categoria->nombre}}</option>
                       @endforeach
               </select>
               @error('categoria')
               <span class="invalid-feedback d-block" role="alert">
               <strong>{{$message}}</strong>
               </span>
               @enderror

          </div>

          <div class="form-group mt-3">
              <label for="preparacion">Preparación</label>
          <input type="hidden" name="preparacion" id="preparacion" value="{{old('preparacion')}}">
          <trix-editor class="form-control  @error('preparacion') is-invalid @enderror" input="preparacion"></trix-editor>
          @error('preparacion')
               <span class="invalid-feedback d-block" role="alert">
               <strong>{{$message}}</strong>
               </span>
               @enderror
          </div>

          <div class="form-group mt-3">
              <label for="ingredientes">Ingredientes</label>
          <input type="hidden" name="ingredientes" id="ingredientes" value="{{old('ingredientes')}}">
          <trix-editor class="form-control @error('ingredientes') is-invalid @enderror" input="ingredientes"></trix-editor>
          @error('ingredientes')
               <span class="invalid-feedback d-block" role="alert">
               <strong>{{$message}}</strong>
               </span>
               @enderror
          </div>
          <div class="form-group mt-3">

              <label for="imagen">Elige la imagen</label>
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

