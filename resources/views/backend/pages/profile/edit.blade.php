@extends('backend.layouts.layout')

@section('title', 'Profile')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if (Auth::user()->role == 'customer')
                <h1>customer</h1>
            @elseif (Auth::user()->role == 'administrator')
                <h1>admin</h1>
            @elseif (Auth::user()->role == 'apoteker')
                <h1>apoteker</h1>
            @elseif (Auth::user()->role == 'kurir')
                <h1>kurir</h1>
            @endif

            @php
                dd(Auth::user())
            @endphp
        </div>
    </div>
</div>
@stop