@extends('layouts.empty')

@section('body')

    @foreach($orders as $order)

        <h1>{{$order->order_key}}</h1>
        <h2>{{$order->id}}</h2>

    @endforeach

@endsection
