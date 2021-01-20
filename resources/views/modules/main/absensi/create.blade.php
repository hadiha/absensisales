<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Buat Pengajuan</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}/pengajuan" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
        <div class="field">
			<label>Nama Pegawai</label>
			<input type="hidden" name="pegawai_id" value="{{auth()->user()->id}}">
            <input type="text" placeholder="Nama" value="{{auth()->user()->name}}" readonly>
		</div>
		<div class="field">
        	<label>Area</label>
            <input type="text" placeholder="Area" name="area" value="{{ auth()->user()->area ?? '-' }}" readonly>
        </div>
        <div class="field">
        	<label>Tanggal</label>
            <input type="text" placeholder="Tanggal" name="tanggal" value="{{ Carbon::now()->format('d/m/Y')}}" readonly>
		</div>
	
		<div class="field">
        	<label>Status</label>
            <select name="status" class="ui search dropdown">
				<option value="izin">Izin</option>
				<option value="sakit">Sakit</option>
				<option value="cuti">Cuti</option>
			</select>
		</div>
				
		<div class="field">
        	<label>Keterangan</label>
            <textarea placeholder="Keterangan" name="keterangan" rows="3"></textarea>
		</div>
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