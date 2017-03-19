@extends('layouts.master')
@section('title','bnb')
@section('content')
<div>
	@foreach ($bnbs as $key=>$bnb)
	<div>
		{{ $bnb->name }}
	</div>
	@endforeach
</div>
        
@endsection