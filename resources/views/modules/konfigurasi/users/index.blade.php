@extends('layouts.list')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append

@section('filters')
	<div class="field">
		<input type="text" name="filter[username]" placeholder="Username Pengguna">
	</div>
	<div class="field">
		<input type="email" name="filter[email]" placeholder="Email Pengguna">
	</div>
	<button type="button" class="ui teal icon filter button" data-content="Cari Data">
		<i class="search icon"></i>
	</button>
	<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
		<i class="refresh icon"></i>
	</button>
@endsection

@section('js-filters')
	d.username = $("input[name='filter[username]']").val();
	d.email = $("input[name='filter[email]']").val();
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
			$(document).on('change', '.hak-akses', function(){
				var id = $('.hak-akses option:selected').val();
				if(id == '2'){
					$('.chose-area').show();
				}
			});
		});
	</script>
@endsection