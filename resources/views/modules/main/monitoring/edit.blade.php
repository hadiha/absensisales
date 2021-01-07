<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header"> {{$type == 'add' ? 'Tambah' : 'Ubah' }} {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ $type == 'add' ? url($pageUrl) : url($pageUrl.$record->id) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
		@if($type != 'add')
			<input type="hidden" name="_method" value="PUT">
			<input type="hidden" name="id" value="{{ $record->id }}">
		@endif
        <div class="field">
			<label>Nama Pegawai</label>
			<input type="hidden" name="pegawai_id" value="{{ $type == 'add' ? $record->id : $record->user->id  }}">
            <input type="text" placeholder="Nama" value="{{$type == 'add' ? $record->name : $record->user->name}}" readonly>
		</div>
		<div class="field">
        	<label>Area</label>
            <input type="text" placeholder="Area" name="area" value="{{ $record->area ?? '-' }}" readonly>
        </div>
        <div class="field">
        	<label>Tanggal</label>
            <input type="text" placeholder="Tanggal" name="tanggal" value="{{ $type == 'add' ? $tanggal : ($record->date_in ? Carbon::parse($record->date_in)->format('d/m/Y') : '')}}" readonly>
		</div>
	
		<div class="field">
        	<label>Status</label>
            <select name="status" class="ui search dropdown">
				<option value="hadir" @if($record->status == 'hadir') selected  @endif>Hadir</option>
				<option value="izin" @if($record->status == 'izin') selected  @endif>Izin</option>
				<option value="sakit" @if($record->status == 'sakit') selected  @endif>Sakit</option>
				<option value="cuti" @if($record->status == 'cuti') selected  @endif>Cuti</option>
				<option value="tk" @if($record->status == '') selected  @endif>Tanpa Keterangan</option>
			</select>
		</div>

		<div class="two fields">
			<div class="field" id="in">
			  <label>Jam Masuk</label>
			  <input type="text" placeholder="Jam Masuk" name="time_in" value="{{ $record->date_in ? Carbon::parse($record->date_in)->format('H:i') : '' }}">
			</div>
			<div class="field" id="out">
			  <label>Jam Pulang</label>
			  <input type="text" placeholder="Jam Pulang" name="time_out" value="{{$record->date_out ? Carbon::parse($record->date_out)->format('H:i') : ''}}">
			</div>
		</div>

        <div class="field">
        	<label>Koordinat</label>
            <input type="text" placeholder="Koordinat" name="koordinat" value="{{$record->koordinat}}" readonly>
		</div>
				
		<div class="field">
        	<label>Keterangan</label>
            <textarea placeholder="Keterangan" name="keterangan" rows="3">{{$record->keterangan}}</textarea>
		</div>
	</form>
</div>
<div class="actions">
	<div class="ui black deny button">
		Batal
	</div>
	<div class="ui positive right labeled icon save button">
		Simpan
		<i class="checkmark icon"></i>
	</div>
</div>