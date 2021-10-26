@extends('layouts.gifts')


@section('content')

    <!-- Login Form -->
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center">¡Gracias! Tu saludo ya ha sido guardado.</h1>
               <div class="text-center">
                   <p class="pb-0">Revisalo aquí</p>
                   <a type="button" class="btn btn-primary" href="/gift/play/{{ $key }}">Ver Saludo</a>
               </div>
            </div>
        </div>
    </div>
    <!-- Login Form -->

@endsection
