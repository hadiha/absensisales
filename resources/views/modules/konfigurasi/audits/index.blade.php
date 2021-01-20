@extends('layouts.list')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append

@section('toolbars')
@endsection

@section('filters')
	<div class="field">
		<input type="text" name="filter[name]" placeholder="Nama">
	</div>
	<div class="field">
		<input type="text" name="filter[module]" placeholder="Module Name">
    </div>
    <div class="field">
        <div class="ui month" id="date">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" name="filter[date]"  placeholder="Tanggal">
            </div>
        </div>
    </div>
	<button type="button" class="ui teal icon filter button" data-content="Cari Data">
		<i class="search icon"></i>
	</button>
	<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
		<i class="refresh icon"></i>
	</button>
@endsection

@section('js-filters')
    d.date = $("input[name='filter[date]']").val();
	d.name = $("input[name='filter[name]']").val();
	d.module = $("input[name='filter[modul]']").val();
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
            
        };
	</script>
@endsection