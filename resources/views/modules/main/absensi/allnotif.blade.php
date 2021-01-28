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
	@if($record->isEmpty())
		<div class="ui teal message">Data Tidak Ditemukan</div>
	@else
    	<div class="ui relaxed divided list">
			@foreach ($record as $item)
				<div class="item">
					<img class="ui avatar image" src="{{ asset($item->user->showfotopath()) }}">
					<div class="content  detail-notif" data-href="{{url('') .'/'.$item->notifiable_type.'/'.$item->notifiable_id}}">
						<a href="#" @if($item->read_at == null) class="header" @else style="color: black" @endif>{{$item->type}}</a>
						<div class="description">{{Carbon::parse($item->created_at)->diffForHumans()}}</div>
					</div>
				</div>
			@endforeach
		</div>
		@endif
	<br>
		{{-- {{($record->links())}} --}}
	@if (isset($record) && $record->lastPage() > 1)
		<div class="ui small pagination menu">
			
			<?php
			$interval = isset($interval) ? abs(intval($interval)) : 3 ;
			$from = $record->currentPage() - $interval;
			if($from < 1){
				$from = 1;
			}
			
			$to = $record->currentPage() + $interval;
			if($to > $record->lastPage()){
				$to = $record->lastPage();
			}
			?>
			
			<!-- first/previous -->
			@if($record->currentPage() > 1)
					<a href="{{ $record->url(1) }}" aria-label="First" class="item">
						<span aria-hidden="true">&laquo;</span>
					</a>
					<a href="{{ $record->url($record->currentPage() - 1) }}" aria-label="Previous" class="item">
						<span aria-hidden="true">&lsaquo;</span>
					</a>
			@endif
			
			<!-- links -->
			@for($i = $from; $i <= $to; $i++)
				<?php 
				$isCurrentPage = $record->currentPage() == $i;
				?>
					<a href="{{ !$isCurrentPage ? $record->url($i) : '#' }}" class="{{ $isCurrentPage ? 'active' : '' }} item">
						{{ $i }}
					</a>
			@endfor
			
			<!-- next/last -->
			@if($record->currentPage() < $record->lastPage())
					<a href="{{ $record->url($record->currentPage() + 1) }}" aria-label="Next" class="item">
						<span aria-hidden="true">&rsaquo;</span>
					</a>
					<a href="{{ $record->url($record->lastpage()) }}" aria-label="Last" class="item">
						<span aria-hidden="true">&raquo;</span>
					</a>
			@endif
		</div>
	@endif
@endsection


