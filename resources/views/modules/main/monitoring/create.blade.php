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
            <input type="text" placeholder="Nama" name="pegawai_id">
		</div>
		<div class="field">
        	<label>Area</label>
            <input type="text" placeholder="Area" name="area">
        </div>
        <div class="field">
        	<label>Tanggal</label>
            <input type="text" placeholder="Tanggal" name="tanggal">
		</div>
		

		<div class="two fields">
			<div class="field">
			  <label>Jam Masuk</label>
			  <input type="text" placeholder="Jam Masuk" name="time_in">
			</div>
			<div class="field">
			  <label>Jam Pulang</label>
			  <input type="text" placeholder="Jam Masuk" name="time_out">
			</div>
		</div>

        <div class="field">
        	<label>Koordinat</label>
            <input type="text" placeholder="Koordinat" name="koordinat">
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