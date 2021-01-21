@extends('layouts.list')

@section('filters')
	<div class="field">
		<input type="text" name="filter[sales]" placeholder="Nama Sales">
	</div>
	<div class="field">
		<input type="text" name="filter[area]" placeholder="Nama Area">
	</div>
	<button type="button" class="ui teal icon filter button" data-content="Cari Data">
		<i class="search icon"></i>
	</button>
	<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
		<i class="refresh icon"></i>
	</button>
@endsection

@section('js-filters')
	d.sales = $("input[name='filter[sales]']").val();
	d.area = $("input[name='filter[area]']").val();
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
        onShow = function(){
            $('#rangestart').calendar({
                type: 'date',
				endCalendar: $('#rangeend'),
				formatter: {
					date: function (date, settings) {
					if (!date) return '';
					var day = date.getDate();
					var month = date.getMonth() + 1;
					var year = date.getFullYear();
					return day + '/' + month + '/' + year;
					}
				}
            });
            $('#rangeend').calendar({
                type: 'date',
				startCalendar: $('#rangestart'),
				formatter: {
					date: function (date, settings) {
					if (!date) return '';
					var day = date.getDate();
					var month = date.getMonth() + 1;
					var year = date.getFullYear();
					return day + '/' + month + '/' + year;
					}
				}
            });
        };
	</script>
@endsection