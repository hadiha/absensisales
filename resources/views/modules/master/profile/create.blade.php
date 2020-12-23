@extends('layouts.form')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-lite.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
<script src="{{ asset('plugins/summernote/summernote-lite.js') }}"></script>
<script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append


@section('rules')
<script type="text/javascript">
	formRules = {
		judul: 'empty',
		sub_judul: 'empty',
		url: 'url',
	};
</script>
@endsection

@section('styles')
@append

@section('scripts')
<script type="text/javascript">
	$(document).on('click', '.save.page.button', function(e){
		$('#status').val(1);
	})

	$(document).on('click', '.draft.page.button', function(e){
		$('#status').val(0);
	})

	// Function jumlah total awal
	$(document).on('keyup', '.biaya.awal', function(e){
		var total = 0;
		$('.biaya.awal').each(function(index){
			total += parseFloat($(this).val());
			console.log(parseFloat($(this).val()))
		});
		if (isNaN(total)){
			total=0
		}
		else{
			total= total;
		}
		$('#total_akomodasi_awal').val(total);
		jumlah();
	});

	jawal = function(){
		var total = 0;
		$('.biaya.awal').each(function(index){
			total += parseFloat($(this).val());
			console.log(parseFloat($(this).val()))
		});
		if (isNaN(total)){
			total=0
		}
		else{
			total= total;
		}
		$('#total_akomodasi_awal').val(total);
		jumlah();
	}
	//-- end --
	// Function jumlah total rincian
	$(document).on('keyup', '.biaya.rincian', function(e){
		var total = 0;
		$('.biaya.rincian').each(function(index){
			total += parseFloat($(this).val());
			console.log(parseFloat($(this).val()))
		});
		if (isNaN(total)){
			total=0
		}
		else{
			total= total;
		}
		$('#total_perjalanan').val(total);
		jumlah();
	});

	jrinci = function(){
		var total = 0;
		$('.biaya.rincian').each(function(index){
			total += parseFloat($(this).val());
			console.log(parseFloat($(this).val()))
		});
		if (isNaN(total)){
			total=0
		}
		else{
			total= total;
		}
		$('#total_perjalanan').val(total);
		jumlah();
	}
	//-- end --
	// function jumlah total selisih
	jumlah = function(){
		var bawal   = parseFloat($("[name=total_akomodasi_awal]").val());
		var brincian = parseFloat($("[name=total_perjalanan]").val());
		total= bawal-brincian;
		if (isNaN(total)){
			total=0
		}
		else{
			total= total;
		}
		$('[name=selisih]').val(total);
	}
	//-- end --
	// -- calendar
	$('.ui.calendar').calendar(calendarOpts);

	$(document).ready(function() {
		$(document).on('click', '.remove-awal', function(event) {
			$(this).closest('.fields').remove();
			jawal();
		});

		$('.add-awal').click(function(event) {
			var idx = parseInt($('.awal.container .fields').last().data('count')) + 1;
			var html = `
			<div class="fields" data-count="`+idx+`">
				<div class="ten wide field">
					<input name="keterangan_awal[`+idx+`]" placeholder="Deskripsi" type="text">
				</div>
				<div class="six wide field">
					<input name="biaya_awal[`+idx+`]" class="biaya awal" placeholder="Biaya" type="text" value="0">
				</div>
				<div class="field">
					<button type="button" class="ui negative icon save button remove-awal" data-content="Hapus Akomodasi Awal"><i class="remove icon"></i></button>
				</div>
			</div>`;

			$('.awal.container').append(html);
		});
		// end awal

		$(document).on('click', '.remove-rincian', function(event) {
			$(this).closest('.fields').remove();
			jrinci();
		});

		$('.add-rincian').click(function(event) {
			var idx = parseInt($('.rincian.container .fields').last().data('count')) + 1;
			var html = `<div class="fields" data-count="`+idx+`">
			<div class="ten wide field">
				<input name="keterangan_rincian[`+idx+`]" placeholder="Deskripsi" type="text">
			</div>
			<div class="six wide field">
				<input name="biaya_rincian[`+idx+`]" class="biaya rincian" placeholder="Biaya" type="text" value="0">
			</div>
			<div class="field">
				<button type="button" class="ui negative icon save button remove-rincian" data-content="Hapus Akomodasi Awal"><i class="remove icon"></i></button>
			</div>
		</div>`;
		$('.rincian.container').append(html);
	});
	});
</script>
@append

@section('content-header')
<h2 class="ui header">
	<div class="content">
		{!! $title or '-' !!}
		{{-- <div class="sub header">{!! $subtitle or ' ' !!}</div> --}}
		<div class="sub header">{!! $subtitle or 'Buat Data Akomodasi' !!}</div>
	</div>
</h2>
@endsection

@section('form')
<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header"></div>
<div class="content">
	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST">
		<div class="ui error message">
		</div>
		{!! csrf_field() !!}
		<div class="ui equal width grid">
			<div class="column">
				<div class="field">
					<label>Kirim Ke</label>
					<select name="kirim_ke" class="dropdown">
						@foreach ($option_user as $val)
						<option value="{{ $val->id }}">{{ $val->username }}</option>
						@endforeach
					</select>
				</div>
				<div class="field">
					<label>Keterangan</label>
					<textarea name="keterangan" placeholder="Keterangan"></textarea>
				</div>
				<div class="field">
					<div class="three fields">
						<div class="field">
							<label>Tanggal Awal</label>
							<div class="ui calendar" id="to">
								<div class="ui input left icon">
									<i class="calendar icon"></i>
									<input type="text" name="tgl_mulai"  placeholder="Tangggal Awal" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="field">
							<label>Tanggal Akhir</label>
							<div class="ui calendar" id="to">
								<div class="ui input left icon">
									<i class="calendar icon"></i>
									<input type="text" name="tgl_selesai" placeholder="Tangggal Akhir" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="field">
							<label>Jumlah Hari</label>
							<input name="jml_hari" placeholder="Jumlah Hari" type="number" required="required">
						</div>
					</div>
				</div>
				<div class="field">
					<label>Personil</label>
					<select name="personil[]" class="ui fluid search dropdown selection multiple" multiple="">
						<option value="">Select</option>
						@foreach ($option_user as $val)
						<option value="{{ $val->id }}">{{ $val->username }}</option>
						@endforeach
					</select>
				</div>
				<div class="field">
					<h5 class="ui dividing header">Akomodasi Awal</h5>	
				</div>
				<div class="awal container">
					<div class="fields" data-count="0">
						<div class="ten wide field">
							<label>Deskripsi</label>
							<input name="keterangan_awal[]" placeholder="Deskripsi" type="text" required>
						</div>
						<div class="six wide field">
							<label>Biaya</label>
							<input name="biaya_awal[]" class="biaya awal" placeholder="Biaya" type="number" required>
						</div>
						<div class="field">
							<label>&nbsp;</label>
							<button type="button" id="btn2" class="ui positive icon save button add-awal"><i class="plus icon"></i></button>
						</div>
					</div>
				</div>
				<div class="fields">
					<div class="four wide field">
					</div>
					<div class="four wide middle field">
						<label>Total Akomodasi Awal :</label>
					</div>
					<div class="eight wide field">
						<input name="total_akomodasi_awal" id="total_akomodasi_awal" placeholder="Total" type="text" readonly style="background: #fdffbc" value="0">
					</div>
				</div>
			</div>{{-- end column 1--}}
			<div class="column">
				<h5 class="ui dividing header">Rincian Perjalanan</h5>
				<div class="rincian container">
					<div class="fields" data-count="0">
						<div class="ten wide field">
							<label>Deskripsi</label>
							<input name="keterangan_rincian[]" placeholder="Deskripsi" type="text" required>
						</div>
						<div class="six wide field">
							<label>Biaya</label>
							<input name="biaya_rincian[]" class="biaya rincian" placeholder="Biaya" type="number" required>
						</div>
						<div class="field">
							<label>&nbsp;</label>
							<button type="button" id="btn2" class="ui positive icon save button add-rincian"><i class="plus icon"></i></button>
						</div>
					</div>
				</div>
				<div class="fields">
					<div class="four wide field">
					</div>
					<div class="four wide middle field">
						<label>Total Rincian :</label>
					</div>
					<div class="eight wide field">
						<input name="total_perjalanan" id="total_perjalanan" placeholder="Total" type="text" readonly style="background: #fdffbc" value="0">
					</div>
				</div>
				<div class="fields">
					<div class="four wide field">
					</div>
					<div class="four wide middle field">
						<label>Total Selisih:</label>
					</div>
					<div class="eight wide field">
						<input name="selisih" placeholder="Total" type="text"  readonly style="background: #E8FFBC">
						<input type="hidden" id="status" name="status">
					</div>
				</div>
			</div>
		</div>
		<div class="actions" align="right">
			<div class="ui black deny page button">
				Batal
			</div>
			<div class="ui orange right labeled icon draft page button" name="draft">
				Simpan ke Draft
				<i class="checkmark icon"></i>
			</div>
			<div class="ui positive right labeled icon save page button" name="publish">
				Simpan & Kirim
				<i class="checkmark icon"></i>
			</div>
		</div>
	</form>
</div>

@endsection

