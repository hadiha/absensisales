<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Ubah {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="id" value="{{ $record->id }}">
        <div class="field">
        	<label>Nama Pegawai</label>
            <input type="text" placeholder="Nama" name="pegawai_id" value="{{$record->pegawai_id}}">
		</div>
		<div class="field">
        	<label>Area</label>
            <input type="text" placeholder="Area" name="area">
        </div>
        <div class="field">
        	<label>Tanggal</label>
            <input type="text" placeholder="Tanggal" name="tanggal" value="{{Carbon::parse($record->tanggal)->format('d/m/Y')}}">
		</div>
		

		<div class="two fields">
			<div class="field">
			  <label>Jam Masuk</label>
			  <input type="text" placeholder="Jam Masuk" name="time_in" value="{{ Carbon::parse($record->time_in)->format('H:i')}}">
			</div>
			<div class="field">
			  <label>Jam Pulang</label>
			  <input type="text" placeholder="Jam Masuk" name="time_out" value="{{Carbon::parse($record->time_out)->format('H:i')}}">
			</div>
		</div>

        <div class="field">
        	<label>Koordinat</label>
            <input type="text" placeholder="Koordinat" name="koordinat" value="{{$record->koordinat}}">
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