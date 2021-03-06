@extends('layouts.list')

@section('css')
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-lite.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
	{{-- <script src="{{ asset('plugins/summernote/summernote-lite.js') }}"></script> --}}
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append
{{-- 
@section('toolbars')
@endsection --}}

@section('filters')
	<div class="field">
		<input type="text" name="filter[name]" placeholder="Nama">
	</div>
	<div class="field">
        @if (auth()->user()->client_id != null)
            <select name="filter[area]" class="ui search dropdown">
                <option value="">Pilih Area</option>
                @foreach (\App\Models\Master\Area::where('client_id', auth()->user()->client_id)->get() as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        @else
            <select name="filter[area]" class="ui search dropdown">
                {!! \App\Models\Master\Area::options('name','id',[],'Pilih Area') !!}
            </select>
        @endif
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
    <button type="button" class="ui icon green export button" data-content="Download">
		<i class="print icon"></i>
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

        $(document).on('click', '.export.button', function(event) {
            event.preventDefault();
            var area = $("select[name='filter[area]']").val();
            var name = $("input[name='filter[name]']").val();
            var date = $("input[name='filter[date]']").val();
            postNewTab('{{ url('kehadiran/monitoring/export') }}', {
                '_token'    : '{{ csrf_token() }}',
                'area' : area,
                'name' : name,
                'date' : date,
            })
           
        });

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

        $(document).on('change','.chose-user', function (e) { 
			var area = $('.chose-user option:selected').data('area');
            $('[name="area"]').val(area);
            // console.log(area);
        });

	});

    onShow = function(){
        $('#tangg').calendar({
            type: 'date',
            // endCalendar: $('#to')
        });

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