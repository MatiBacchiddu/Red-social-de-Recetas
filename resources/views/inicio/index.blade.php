@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous"></script>
@endsection

@section('hero')

    <div class="hero-categorias">
        <form action="" class="container h-100" action={{route('buscar.show')}}>
            <div class="row h-100 align-items-center">
               <div class="col-md-4 texto-buscar">
                <p class="display-4">Encuentra una receta para tu proxima comida</p>
                <input
                type="search"
                name="buscar"
                class="form-control"
                placeholder="buscar receta">
               </div>
            </div>
        </form>
    </div>

@endsection

@section('content')


    <div class="container nuevas-recetas">
        <h2 class="titulo-categoria text-uppercase mb-4">Ultimas recetas</h2>

        <div class="owl-carousel owl-theme">
            @foreach($nuevas as $nueva)
                <div class="card">
                    <img src="/storage/{{$nueva->imagen}}" class="card-img-top" alt="">
                    <div class="card-body">

                        <h3>{{ Str::upper($nueva->titulo)}}</h3>

                        <p> {{ Str::words(strip_tags($nueva->preparacion), 5)}} </p>

                        <a 
                        href=" {{ route('recetas.show', ['receta' => $nueva->id ]) }} "
                        class="btn btn-primary d-block font-weight-bold text-uppercase">
                        Ver receta</a>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @foreach($recetas as $key => $grupo)
        <div class="container">
            <h2 class="titulo-categoria text-uppercase mt-5 mb-4">{{str_replace('-', ' ', $key)}}</h2>
            <div class="row">
                @foreach($grupo as $recetas)
                    @foreach($recetas as $receta)
                        <div class="col-md-4 mt-4">
                            <div class="card shadow">
                                <img src="/storage/{{$receta->imagen}}" class="card-img-top">
                                <div class="card-body">
                                    <h3 class="card-title">{{$receta->titulo}}</h3>
                                </div>
                                <div class="text-left mt-0 mb-4 ml-4">
                                   <p class="text-primary fecha font-weight-bold">Creado el: {{$receta->created_at}}</p>
                                </div>
                                <p>{{Str::words(strip_tags($receta->preparacion)), 10}}</p>
                                <a href="{{route('recetas.show', ['receta' => $receta->id])}}"
                                class="btn btn-primary d-block btn-receta">Ver receta</a>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endforeach

@endsection

