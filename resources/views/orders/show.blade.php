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
            @forelse ($records as $record)
                <div class="mt-3 row border">
                    <div>
                        Product :
                        <div>Name : {{$record->products->title}}</div>
                        <div>Quantity : {{$record->quantity}}</div>
                        <div>Price : {{$record->price}}</div>
                    </div>
                </div>
            @empty
                <div class="mt-3 row justify-content-center">
                    <div>
                        <h3>No Records found</h3>
                    </div>
                </div>
            @endforelse
            @if (isset($record))
                Total Price : {{$record->order->total_price}}
            @endif
        </div>
    </div>
@endsection

@section('scripts')

@endsection