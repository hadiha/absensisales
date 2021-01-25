@extends('layouts.form')

@section('css')
   
@append

@section('js')
   
@append

@section('styles')
    <style type="text/css">
        
    </style>
@append

@section('js-filters')
@endsection

@section('scripts')

@append


@section('form')
	{{-- <h1 class="ui center aligned header" style="line-height: 500px">
		U N D E R &nbsp; &nbsp; C O N S T R U C T I O N
    </h1> --}}
    <div class="ui relaxed divided list">
		@foreach ($record as $item)
			<div class="item">
				<img class="ui avatar image" src="{{ asset($item->user->showfotopath()) }}">
				<div class="content">
					<a class="header">{{$item->type}}</a>
					<div class="description">{{Carbon::parse($item->created_at)->diffForHumans()}}</div>
				</div>
			</div>
		@endforeach
	</div>
@endsection


