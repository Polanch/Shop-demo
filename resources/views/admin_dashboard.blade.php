@extends('layouts.admin')

@section('content')
    <div class="dashboard">
        <div class="dash-head">
            <h6>Dashboard</h6>
            <div class="size-menu">
                <button class="sizes active">XXS</button>
                <button class="sizes">XS</button>
                <button class="sizes">S</button>
                <button class="sizes">M</button>
                <button class="sizes">L</button>
                <button class="sizes">XL</button>
                <button class="sizes">XXL</button>
                <button class="sizes">3XL</button>
            </div>
        </div>
        <div class="monitor">
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m1.png') }}" class="m-icons">
                <h4>Orders</h4>
                <p>00</p>
            </div>
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m2.png') }}" class="m-icons">
                <h4>Profit</h4>
                <p>00.00</p>
            </div>
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m3.png') }}" class="m-icons">
                <h4>Stocks</h4>
                <p>00</p>
            </div>
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m4.png') }}" class="m-icons">
                <h4>Sold</h4>
                <p>00</p>
            </div>
        </div>
        <div class="big-monitor">
            <div class="sales-graph"></div>
        </div>
    </div>
@endsection