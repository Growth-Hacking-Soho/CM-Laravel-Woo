@extends('layouts.gifts')

@section('content')


    <!-- Video principal -->
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-md-4">
                <video width="100%" controls>
                    <source src="{{ route('gift.video',$model->key) }}" type="video/mp4">
                </video>
            </div>
            <div class="col-md-8">
                <h1>Celebremos juntos, {{ $model->name }}</h1>
                <p class="my-5">{{ $model->message }}</p>
                <!--<iframe width="100%" height="500" src="https://www.youtube.com/embed/LFIfKP_OvFk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                <div class="text-center">
                    <button type="button" class="btn btn-outline-primary">Editar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Video principal -->
    <!-- Jumbotron -->

@endsection
