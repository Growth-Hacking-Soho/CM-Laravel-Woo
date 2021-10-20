@extends('layouts.gifts')

@section('content')


    <!-- Video principal -->
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Celebremos juntos, {{ $model->name }}</h1>
                <p class="my-5">{{ $model->message }}</p>
                <!--<iframe width="100%" height="500" src="https://www.youtube.com/embed/LFIfKP_OvFk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                <video width="100%" controls>
                    <source src="{{ route('gift.video',$model->key) }}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
    <!-- Video principal -->
    <!-- Jumbotron -->

    <div class="container px-4 py-5" id="content-section">
        <div class="row">
            <div class="col-md-6">
                <h4>ACERCA DE ESTE VINO</h4>
            </div>
            <div class="col-md-7 order-md-3 mb-5 mb-md-0">
                <h1 class="variedad">Cartagena<br>Sauvignon Blanc</h1>
                <p class="my-5">{!! $model->description !!}</p>
                <a href="#" class="link">Conocer Más <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="col-md-5 order-md-4 bkg-botella mb-5 mb-md-0">
{{--                <img src="{{ $model->images[0]->src }}" class="botella"/>--}}
                <img src="{{ asset('images/botella-vino.png') }}" class="botella"/>
            </div>
            <div class="col-md-6 order-md-2 text-center text-md-end">
                <button type="button" class="btn btn-outline-primary"><i class="fas fa-download"></i> Descargar Ficha</button>
            </div>
        </div>
    </div>

    <!-- Jumbotron -->
    <!-- Video secundario -->
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Jamie Verbraak - Acerca de Cartagena Sauvignon Blanc</h2>
                <p class="my-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vitae magna at elit tristique finibus. Morbi lobortis urna in tortor porta efficitur. Nulla vestibulum mi eget urna semper auctor. Phasellus rhoncus, erat et eleifend bibendum, elit leo elementum nunc, quis ullamcorper risus orci quis risus. Sed id eros egestas, sollicitudin massa non, euismod ipsum. Etiam diam dolor, cursus a mi in, facilisis cursus odio. Morbi faucibus semper enim, nec scelerisque lectus suscipit id. Aenean id ex rutrum, porttitor mauris sed, vestibulum sem. Duis quam nunc, tristique id risus ut, tincidunt malesuada nisl. Praesent ultrices gravida nunc vel vestibulum.</p>
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/LFIfKP_OvFk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <!-- Video secundario -->
    <!-- Features -->
    <div class="container px-4 py-5" id="hanging-icons">


        <div class="row pb-5">
            <div class="col-md-5 mb-5 mb-md-0">
                <h3><img src="{{ asset('images/icono-recomendaciones.svg') }}" class="icono-titulo"/> Recomendaciones</h3>
                <p class="my-5">Su acidez fresca y Buena estructura en boca hace que este vino sea muy amigable con la comida. Es delicioso tomarlo durante un día caluroso de verano o en un maridaje con ensaladas frescas, queso de cabra y todo tipo de mariscos y pescados.</p>
                <a href="#" class="link">Conocer Más <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="col-md-5 offset-md-2">
                <h3><img src="{{ asset('images/icono-premios.svg') }}" class="icono-titulo"/> Premios</h3>
                <p class="my-5"><strong>La Cav:</strong> 93pts, 2019<br>
                    <strong>Robert Parker´s Wine Advocate:</strong> 91pts, 2019​</p>
                <a href="#" class="link">Conocer Más <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

    </div>
    <!-- Features -->
    <!-- Jumbotron -->
    <div class="p-4 p-md-5 d-table-cell align-bottom vw-100" id="about">
        <div class="container py-5 text-center">

            <button class="btn btn-primary btn-lg" type="button">Visita Nuestra Web</button>
        </div>
    </div>
    <!-- Jumbotron -->

@endsection
