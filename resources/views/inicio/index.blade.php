@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
@endsection

@section('hero')
     <div class="hero-categorias">
     <form class="container h-100"  action="{{route('search.show')}}">
              <div class="row  h-100  align-items-center">
                  <div class="col-md-4 texto-buscar">
                      <p class="display-4">Encuentra una receta para tu próxima comida</p>
                      <input type="search" name="buscar" placeholder="Buscar Receta" class="form-control">

                  </div>
              </div>
          </form>
     </div>
@endsection

@section('content')
    <div class="container nuevas-recetas">
        <h2 class="titulo-categoria text-uppercase  mb-4">Últimas Recetas</h2>
        <div class="owl-carousel owl-theme">
            @foreach($nuevas as $nueva)
                <div class="card">
                  <img src="/storage/{{$nueva->imagen}}" class="card-img-top" alt="imagen receta">
                  <div class="card-body">
                     <h3>{{$nueva->titulo}}</h3>
                     <p>{{Str::words( strip_tags( $nueva->preparacion), 20 )}}</p>
                     <a href="{{route('recetas.show',['receta'=> $nueva->id])}}" class="btn btn-primary d-block font-weight-bold text uppercase">Ver Receta</a>
                  </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Recetas más votadas</h2>
        <div class="row">
                @foreach($votadas as $receta )
                   <div class="col-md-4 mt-4">
                       <div class="card shadow">
                       <img src="/storage/{{$receta->imagen}}" class="card-img-top" alt="imagen receta">

                       <div class="card-body">
                          <h3 class="card-title">{{$receta->titulo}}</h3>
                          <div class="meta-receta d-flex justify-content-between">
                               @php
                                   $fecha = $receta->created_at
                               @endphp
                               <p class="text-primary fecha font-weight-bold">
                                   <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                               </p>
                            <p>{{count($receta->likes)}} Les gustó</p>

                        </div>
                        <p>{{Str::words( strip_tags( $receta->preparacion),10, '...' )}}</p>
                        <a href="{{route('recetas.show',['receta'=> $nueva->id])}}" class="btn btn-primary d-block font-weight-bold text uppercase">Ver Receta</a>
                        </div>
                    </div>
                   </div>
                @endforeach
        </div>
    </div>


    @foreach($recetas as $key => $grupo)
        <div class="container">
            <h2 class="titulo-categoria text-uppercase mt-5 mb-4">{{ str_replace('-',' ', $key)}}</h2>
            <div class="row">
                @foreach($grupo as $recetas)
                    @foreach($recetas as $receta )
                       <div class="col-md-4 mt-4">
                           <div class="card shadow">
                           <img src="/storage/{{$receta->imagen}}" class="card-img-top" alt="imagen receta">

                           <div class="card-body">
                              <h3 class="card-title">{{$receta->titulo}}</h3>
                              <div class="meta-receta d-flex justify-content-between">
                                   @php
                                       $fecha = $receta->created_at
                                   @endphp
                                   <p class="text-primary fecha font-weight-bold">
                                       <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                                   </p>
                                <p>{{count($receta->likes)}} Les gustó</p>

                            </div>
                            <p>{{Str::words( strip_tags( $receta->preparacion),10, '...' )}}</p>
                            <a href="{{route('recetas.show',['receta'=> $nueva->id])}}" class="btn btn-primary d-block font-weight-bold text uppercase">Ver Receta</a>
                            </div>
                        </div>
                       </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
