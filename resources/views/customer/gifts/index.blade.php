@extends('layouts.gifts')

@section('content')
    <!-- Login Form -->
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center mb-3"><strong>¡Casa Marín te da la bienvenida!</strong></h1>
                <h4 class="text-center">Completa los siguientes datos para iniciar la celebración:</h4>
                <form id="giftForm" method="POST" action="{{ url("gift/index/$uuid") }}" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group mt-4">
                        <label for="name">Tu Nombre*</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="email">Tu Email*</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu email.</small>
                    </div>
                    <div class="form-group mt-4">
                        <label for="serie">N° de serie*</label>
                        <input type="number" class="form-control" id="phone" name="serie" aria-describedby="serieHelp" required>
                        <small id="serieHelp" class="form-text text-muted">Puedes encontrarlo en la etiqueta de la botella.</small>
                    </div>
                    <input type="hidden" value="{{ $uuid }}" name="key" />

                    <div class="form-group text-center mt-5">
                        <button type="submit" class="btn btn-primary">¡Comencemos!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Login Form -->
@endsection

@section('scripts')
<script>
    $("#giftForm").validate({
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@endsection
