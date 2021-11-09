@extends('layouts.gifts')

@section('content')
    <!-- Login Form -->
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h4 class="text-center">Escribe aquí­ el mensaje y sube tu video para la persona que recibirá tu regalo:</h4>
                @if ($option)
                    <form id="giftForm" method="POST" action="{{ url("gift/$model->key") }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group mt-5">
                            <label for="name">Nombre de tu ser querido*</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $model->name }}" required>
                        </div>
                        <div class="form-group mt-5">
                            <label for="email">Email de tu ser querido</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $model->email }}">
                        </div>
                        <div class="form-group mt-5">
                            <label for="phone">Telefono de tu ser querido</label>
                            <input type="number" class="form-control" id="phone" name="phone" value="{{ $model->phone }}">
                        </div>
                        <div class="form-group mt-5">
                            <label for="video">Video</label>
                            <input type="file" class="form-control" id="video" name="video">
                            <div class="text-center">
                                <video width="40%" controls class="mt-2">
                                    <source src="{{ route('gift.video',$model->key) }}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="message">Mensaje*</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required>{{ $model->message }}</textarea>
                        </div>
                        <input type="hidden" value="{{ $model->key }}" name="key" />
                        <div class="form-group text-center mt-5">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                @else
                    <form id="giftForm" method="POST" action="{{ route('gift.store') }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group mt-5">
                            <label for="name">Nombre de tu ser querido*</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mt-5">
                            <label for="email">Email de tu ser querido</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group mt-5">
                            <label for="phone">Teléfono de tu ser querido</label>
                            <input type="number" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group mt-5">
                            <label for="video">Video</label>
                            <input type="file" class="form-control" id="video" name="video" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="message">Mensaje*</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <input type="hidden" value="{{ $order_id }}" name="order_id" />
                        <div class="form-group text-center mt-5">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                @endif
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
