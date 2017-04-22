@extends('layouts.master')
@section('title','bnb')
@section('content')

<div class="container">

    <div class="jumbotron col-md-6 col-md-offset-3 col-xs-12">
        
        <!-- Single button -->
        <div class="panel panel-success" id="orderRooms">
            <!-- Default panel contents -->
            <div class="panel-heading">民宿</div>
            <ul class="list-group">
                @foreach ($bnbs as $key=>$bnb)
                <li class="list-group-item">
                    {{ $bnb->name }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
        
@endsection