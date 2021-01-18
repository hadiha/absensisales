@extends('layouts.list')

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-lite.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}"> --}}
@append

@section('js')
	{{-- <script src="{{ asset('plugins/summernote/summernote-lite.js') }}"></script> --}}
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append

@section('toolbars')
@endsection

@section('filters')
	<div class="field">
        <select name="filter[pegawai_id]" class="ui search dropdown">
            {!! \App\Models\Authentication\User::options('username','id',[],'Pilih Pegawai') !!}
        </select>
		{{-- <input type="text" name="filter[name]" placeholder="Nama"> --}}
    </div>
    <div class="field">
        <select name="filter[barang_id]" class="ui search dropdown">
            {!! \App\Models\Master\Barang::options('name','id',[],'Pilih Barang') !!}
        </select>
		{{-- <input type="text" name="filter[name]" placeholder="Nama"> --}}
	</div>
	{{-- <div class="field">
        <select name="filter[area_id]" class="ui search dropdown">
            {!! \App\Models\Master\Area::options('name','id',[],'Pilih Area') !!}
        </select>       
    </div> --}}
    <div class="field">
        <div class="ui month" id="from">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" name="filter[from]"  placeholder="Dari" value="">
            </div>
        </div>
    </div>
    <div class="field">
        <div class="ui month" id="to">
            <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" name="filter[to]"  placeholder="Sampai" value="">
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
    d.name = $("select[name='filter[pegawai_id]']").val();
    d.barang = $("select[name='filter[barang_id]']").val();
	d.from = $("input[name='filter[from]']").val();
	d.to = $("input[name='filter[to]']").val();
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
        $('#from').calendar({
            type: 'date',
            endCalendar: $('#to')
        });
        $('#to').calendar({
            type: 'date',
            startCalendar: $('#from')
        });

	});

        // onShow = function(){
        //     $('.checkbox').checkbox();
        //     $('.ui.dropdown').dropdown({
        //         onChange: function(value) {
        //             var target = $(this).dropdown();
        //             if (value!="") {
        //                 target
        //                     .find('.dropdown.icon')
        //                     .removeClass('dropdown')
        //                     .addClass('delete')
        //                     .on('click', function() {
        //                         target.dropdown('clear');
        //                         $(this).removeClass('delete').addClass('dropdown');
        //                         return false;
        //                     });
        //             }
        //         }
        //     });
        //     // force onChange  event to fire on initialization
        //     $('.ui.dropdown')
        //         .closest('.ui.selection')
        //         .find('.item.active').addClass('qwerty').end()
        //         .dropdown('clear')
        //             .find('.qwerty').removeClass('qwerty')
        //         .trigger('click');

	    //     $('[name=display_name]').on('change, keyup', function(event) {
	    //         var display_name = $(this).val();
	    //         $('[name=name]').val(slugify(display_name));
	    //     });

        //     return false;
        // };

        
	</script>
@endsection