@extends('layouts.mainapp')

@section('title','Orders Details')
@section('style')
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Orders Details</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            @foreach ($records as $record)
                <div class="mt-3 row border">
                    <div>
                        Product :
                        <div>Name : {{$record->products->title}}</div>
                        <div>Quantity : {{$record->quantity}}</div>
                        <div>Price : {{$record->price}}</div>
                    </div>
                </div>
            @endforeach
            Total Price : {{$record->order->total_price}}
        </div>
    </div>
@endsection

@section('scripts')

@endsection