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
        	<label>Kode Barang</label>
            <input type="text" placeholder="Kode Barang" name="kode" value="{{$record->kode}}">
        </div>
        <div class="field">
        	<label>Nama Barang</label>
            <input type="text" placeholder="Nama Barang" name="name" value="{{$record->name}}">
        </div>
        {{-- <div class="field">
			<label>Jumlah</label>
			<input type="number" placeholder="Jumlah Barang" name="jumlah" value="{{$record->jumlah}}">
        </div> --}}
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