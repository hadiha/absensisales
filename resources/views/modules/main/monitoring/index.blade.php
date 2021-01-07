@extends('layouts.list')

@section('css')
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-lite.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
	{{-- <script src="{{ asset('plugins/summernote/summernote-lite.js') }}"></script> --}}
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append

@section('toolbars')
@endsection

@section('filters')
	<div class="field">
		<input type="text" name="filter[name]" placeholder="Nama">
	</div>
	<div class="field">
        <select name="filter[area]" class="ui search dropdown">
            {!! \App\Models\Master\Area::options('name','id',[],'Pilih Area') !!}
        </select>
    </div>
    <div class="field">
        <div class="ui month" id="date">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" name="filter[date]"  placeholder="Tanggal" value="{{Carbon::now()->format('F j, Y')}}">
            </div>
        </div>
    </div>
    {{-- <div class="field">
        <div class="ui month" id="to">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" name="filter[to]"  placeholder="Sampai" value="">
            </div>
        </div>
    </div> --}}
	<button type="button" class="ui teal icon filter button" data-content="Cari Data">
		<i class="search icon"></i>
	</button>
	<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
		<i class="refresh icon"></i>
	</button>
@endsection

@section('js-filters')
	d.area = $("select[name='filter[area]']").val();
	d.name = $("input[name='filter[name]']").val();
	d.date = $("input[name='filter[date]']").val();
@endsection

@section('rules')
	<script type="text/javascript">
		formRules = {
			username: 'empty',
			email: 'empty',
			roles: 'empty',
		};
	</script>
@endsection

@section('init-modal')
<script>
	$(document).ready(function() {
        $('#date').calendar({
            type: 'date',
            // endCalendar: $('#to')
        });
        // $('#to').calendar({
        //     type: 'date',
        //     startCalendar: $('#from')
        // });
	});

    onShow = function(){
        $('#in').calendar({
            type: 'time',
            ampm: false
        });       

        $('#out').calendar({
            type: 'time',
            ampm: false
        });
    };

	</script>
@endsection