@extends('layouts.empty')

@section('title', 'Regalo')

@section('body')

            <div class="container">
                <nav class="navbar navbar-expand-sm navbar-light" aria-label="Third navbar example">
                    <div class="container-fluid">
                        <a class="navbar-brand me-0" href="index.html"><img src="{{ asset('images/logo-casamarin.svg') }}" class="logo"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse py-5 py-md-0" id="navbarsExample03">
                            <ul class="navbar-nav me-auto mb-2 mb-sm-0 w-100 justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.html">TIENDA</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="about.html">VISÍTANOS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="productos.html">CONTACTO</a>
                                </li>
                            </ul>
                            <div class="mb-0 mt-4 mt-md-0 ">
                                <button type="button" class="btn btn-outline-primary d-none">Salir</button>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        <!-- Header -->
        @yield('header')

    <!--Body-->
    <section id="content" class="container-fluid mt-4 px-3">
        @yield('content')
    </section>

    <!--Footer-->
    <footer>
        <!-- Footer -->

        <footer class="border-top">
            <div class="container">
                <div class="row py-4 my-0 py-md-5 mt-md-0">
                    <div class="col-md-3 text-center text-md-start mb-5 mb-md-0">
                        <a href="/" class="d-md-flex align-items-center mb-3 link-dark text-decoration-none">
                            <img src="{{ asset('images/logo-casamarin.svg') }}" class="logo"/>
                        </a>
                    </div>


                    <div class="col-md-3 text-center text-md-start pt-4 pt-md-0">
                        <h5>DIRECCIÓN:</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2 text-black-50">Camino Lo Abarca s/n.<br> Lo Abarca, Cartagena</li>
                        </ul>
                    </div>

                    <div class="col-md-3 text-center text-md-start pt-4 pt-md-0">
                        <h5>TELÉFONO:</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2 text-black-50">+56 (9) 8 777 6786</li>
                        </ul>
                    </div>

                    <div class="col-md-3 text-center text-md-start pt-4 pt-md-0">
                        <h5>HORARIOS DE ATENCIÓN:</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2 text-black-50">Mar / Vie de 9.30 a 13.00 y 14.00 a 17.30 <br>Sáb de 10.00 a 13.00 y 14.00 a 17.00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        @yield('footer')
    </footer>

@endsection





