<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Buat {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
		<div class="field">
			<label>Nama Pegawai</label>
			<select name="pegawai_id" class="ui fluid dropdown chose-user">
				<option value="">Pilih Pegawai</option>
				@foreach ($users as $item)
					<option value="{{$item->id}}" data-area="{{$item->area}}">{{$item->name}}</option>					
				@endforeach
			</select>
		</div>
		<div class="field">
        	<label>Area</label>
            <input name="area" type="text" placeholder="Area" readonly>
        </div>
        <div class="field" id="tangg">
        	<label>Tanggal</label>
            <input type="text" placeholder="Tanggal" name="tanggal" value="{{ Carbon::now()->format('d/m/Y') }}">
		</div>
		<div class="field">
        	<label>Status</label>
            <select name="status" class="ui search dropdown">
				<option value="">Pilih Salah Satu</option>
				<option value="hadir">Hadir</option>
				<option value="izin">Izin</option>
				<option value="sakit">Sakit</option>
				{{-- <option value="cuti">Cuti</option> --}}
			</select>
		</div>	
		<div class="two fields">
			<div class="field" id="in">
			  <label>Jam Masuk</label>
			  <input type="text" placeholder="Jam Masuk" name="time_in">
			</div>
			<div class="field" id="out">
			  <label>Jam Pulang</label>
			  <input type="text" placeholder="Jam Masuk" name="time_out">
			</div>
		</div>

        <div class="field">
        	<label>Koordinat</label>
            <input type="text" placeholder="Koordinat" name="latitude">
		</div>
		
        <div class="field">
        	<label>Keterangan</label>
            <textarea placeholder="Keterangan" name="keterangan" rows="3"></textarea>
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