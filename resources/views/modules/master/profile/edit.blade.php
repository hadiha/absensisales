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

</script>
@append

@section('content-header')
<h2 class="ui header">
	<div class="content">
		{!! $title or '-' !!}
		<div class="sub header">{!! $subtitle or '' !!}</div>
	</div>
</h2>
@endsection

@section('form')
<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header"></div>
<div class="content">
	<form class="ui large form" id="dataForm" role="form" method="POST" action="{{ url($pageUrl).'/'.$record->user_id }}" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
		{!! csrf_field() !!}        
		<div class="ui grid">
			<div class="sixteen wide tablet column">
				<h4 class="ui horizontal divider header">
					<i class="address book icon"></i>
					Profile Detail
				</h4>
			</div>
			<div class="sixteen wide tablet eight wide computer column">
				<div class="two fields">
					<div class="five wide field">
						@if($record->photo)
						<img class="image-preview"  style="height: 4cm; width:100%!important; object-fit: cover;" id="showAttachment" src="{{ asset('storage/'.$record->photo) }}">
						@else
						<img class="image-preview"  style="height: 6cm; width:100%!important; object-fit: cover;" id="showAttachment" src="{{ asset('images/default.jpg') }}">
						@endif
						<div class="ui fluid file input action">
							<input type="text" readonly="">
							<input type="file" class="ten wide column" id="attachment" name="photo" autocomplete="off" multiple="">
							<div class="ui blue button file">
								Cari...
							</div>
						</div>
					</div>
					<div class="eleven wide field">
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">NIK</label>
							</div>
							<div class="eleven wide field">
								<div class="ui left icon input">
									<i class="address card icon"></i>
									<input type="text" name="nik" placeholder="NIK" value="{{ $record->nik }}">
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Nama</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="text"  placeholder="Full Name" name="nama" value="{{ $record->nama }}">
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Alamat Email</label>
							</div>
							<div class="eleven wide field">
								<div class="ui left icon input">
									<i class="mail card icon"></i>
									<input type="email" name="email" placeholder="Email Address" value="{{ $record->user->email }}">
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Tanggal Lahir</label>
							</div>
							<div class="eleven wide field">
								<div class="ui calendar" id="example2">
									<div class="ui input left icon">
										<i class="calendar icon"></i>
										<input type="text" placeholder="dd/mm/yyyy" name="tgl_lahir" value="{{ 
											Carbon::createFromFormat('Y-m-d', $record->tgl_lahir)->format('d/m/Y')
										}}">
									</div>
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Tempat Lahir</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="text" name="tmp_lahir" placeholder="Tempat Lahir" value="{{ $record->tmp_lahir }}">
								</div>
							</div>
						</div>      
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="jabatan" style="text-align: left;">Jabatan</label>
					</div>
					<div class="eleven wide field">
						<div class="ui left icon input">
							<i class="industry icon"></i>
							<select name="jabatan" class="ui dropdown" placeholder="Jabatan">
								<option value=""> </option>
								<option value="admin" {{ "admin"==$record->jabatan?'selected':'' }}>Administrator</option>
								<option value="programmer" {{ "programmer"==$record->jabatan?'selected':'' }}>Programmer</option>
							</select>
						</div>
					</div>
				</div>   
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Jenis Kelamin</label>
					</div>
					<div class="eleven wide field">
						<div class="ui left icon input">
							<i class="industry icon"></i>
							<select name="jk" class="ui dropdown" placeholder="Jenis Kelamin">
								<option value=""> </option>
								<option value="L" {{ "L"==$record->jk?'selected':'' }}>Laki - Laki</option>
								<option value="P" {{ "P"==$record->jk?'selected':'' }}>Perempuan</option>
							</select>
						</div>
					</div>
				</div>             
			</div> <!-- end -->
			<div class="sixteen wide tablet eight wide computer column">
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">No. Telepon</label>
					</div>
					<div class="eleven wide field">
						<div class="ui left icon input">
							<i class="home icon"></i>
							<input type="text" name="phone" placeholder="Phone Number" value="{{ $record->no_hp }}">
						</div>
						<span id="tampil-alert-phone"></span>
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">NPWP</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<input type="text" name="npwp" placeholder="No. NPWP" value="{{ $record->no_npwp }}" >
						</div>
						<span id="tampil-alert-npwp"></span>
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">No. Rekening</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<input type="text" name="no_rekening" placeholder="No. Rekening" value="{{ $record->no_rekening }}" >
						</div>
						<span id="tampil-alert-no_rekening"></span>

					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Atas Nama</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<input type="text" name="atas_nama" placeholder="A/n" value="{{ $record->atas_nama }}" >
						</div>
						<span id="tampil-alert-atas_nama"></span>

					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Tanggal Masuk</label>
					</div>
					<div class="eleven wide field">
						<div class="ui calendar" id="example2">
							<div class="ui input left icon">
								<i class="calendar icon"></i>
								<input type="text" placeholder="dd/mm/yyyy" name="tgl_masuk" value="{{ Carbon::createFromFormat('Y-m-d', $record->tgl_masuk)->format('d/m/Y') }}">
							</div>
						</div>
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Status</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
						<input value="{{ $record->statusKaryawan->id==$record->status? $record->statusKaryawan->keterangan:''}}" readonly>
						</div>
						<span id="tampil-alert-status"></span>
					</div>
				</div>
			</div> <!-- end column 2 -->
		</div> <!-- end Grid -->
		<div class="actions" align="right">
			<a href="{{ url('/ganti-password') }}"><div class="ui blue page button">
				Ubah Password
			</div></a>
			<div class="ui black back page button">
				Batal
			</div>
			<div class="ui positive right labeled icon save page button">
				Simpan
				<i class="checkmark icon"></i>
			</div>
		</div>
	</form>
</div>
@endsection
