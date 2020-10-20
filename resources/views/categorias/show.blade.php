@extends('layouts.app')

@section('content')

    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">
            {{$categoriaReceta->nombre}}
        </h2>
        <div class="row">
            @foreach($recetas as $receta)
            <div class="col-md-4 mt-4">
                <div class="card shadow">
                    <img src="/storage/{{$receta->imagen}}" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">{{$receta->titulo}}</h3>
                    </div>
                    <div class="text-left mt-0 mb-4 ml-4">
                        <p class="text-primary fecha font-weight-bold">Creado el: {{$receta->created_at}}</p>
                        <a href="{{route('recetas.show', ['receta' => $receta->id])}}"
                        class="btn btn-primary d-block btn-receta">Ver receta</a>
                     </div>
                </div>
            </div>{{--Cierre del col-md--}}
            @endforeach

            <div class="d-flex justify-content-center mt-5">
                {{$recetas->links()}}
            </div>
        </div>
    </div>

@endsection

