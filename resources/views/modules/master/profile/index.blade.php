@extends('layouts.list')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-lite.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
<script src="{{ asset('plugins/summernote/summernote-lite.js') }}"></script>
<script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append


@section('filters')
<div class="field">
	<select name="filter[kirim]" class="ui dropdown">
		{!! \App\Models\Authentication\User::options('username', 'id', [], '(Pilih Kirim)') !!}
	</select>
</div>
<div class="field">
	<div class="ui calendar" id="rangestart">
		<div class="ui input left icon">
			<i class="calendar icon"></i>
			<input type="text" placeholder="Create At" name="filter[dariTanggal]" autocomplete="off">
		</div>
	</div>
</div>
<div class="field">
	<select name="filter[status]" >
		<option value="">-- Status --</option>
		<option value="0">Draf</option>
		<option value="1">Kirim</option>
		<option value="2">Tolak</option>
	</select>
</div>
<button type="button" class="ui teal icon filter button" data-content="Cari Data">
	<i class="search icon"></i>
</button>
<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
	<i class="refresh icon"></i>
</button>
@endsection

@section('js-filters')
d.kirim = $("select[name='filter[kirim]']").val();
d.status = $("select[name='filter[status]']").val();
d.dariTanggal = $("input[name='filter[dariTanggal]']").val();
d.sampaiTanggal = $("input[name='filter[sampaiTanggal]']").val();
@endsection


@section('rules')
<script type="text/javascript">
	formRules = {
		judul: 'empty',
		sub_judul: 'empty',
		url: 'url',
	};

	$('#rangestart').calendar(calendarOpts);
</script>
@endsection

@section('init-modal')
<script>
	$(document).ready(function() {
		$('.ui.add.button').on('click', function(event) {
			event.preventDefault();
			// /* Act on the event */
			location.href='{{ url($pageUrl) }}/create';
		});
		
		$('.ui.back.button').on('click', function(event) {
			event.preventDefault();
			// /* Act on the event */
			location.href='{{ url($pageUrl) }}';
		});
	});
</script>
@endsection
