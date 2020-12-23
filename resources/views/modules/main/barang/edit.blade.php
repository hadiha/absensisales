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
        	<label>Nama Barang</label>
            <input type="text" placeholder="Nama Barang" value="{{$record->item->name}}" readonly>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Kode Barang</label>
			  <input type="text" placeholder="Kode" value="{{$record->item->kode}}" readonly>
			</div>
			<div class="field">
				<label>Stok</label>
				<input type="text" placeholder="Stock" name="stock" value="{{$record->stock}}">
			</div>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Sale In</label>
			  <input type="text" placeholder="Sale In" name="sale_in" value="{{$record->sale_in}}">
			</div>
			<div class="field">
			  <label>Sale Out</label>
			  <input type="text" placeholder="Sale Out" name="sale_out" value="{{$record->sale_out}}">
			</div>
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