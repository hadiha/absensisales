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
        	<label>Nama Barang</label>
            <select name="barang_id" class="ui search dropdown">
				{!! \App\Models\Master\Barang::options('name','id',[],'Pilih Barang') !!}
			</select>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Tanggal Laporan</label>
			  <input type="text" placeholder="Tanggal" name="tanggal">
			</div>
			<div class="field">
				<label>Stok</label>
				<input type="text" placeholder="Stock" name="stock">
			</div>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Sale In</label>
			  <input type="text" placeholder="Sale In" name="sale_in">
			</div>
			<div class="field">
			  <label>Sale Out</label>
			  <input type="text" placeholder="Sale Out" name="sale_out">
			</div>
		</div>
		
		<div class="sixteen wide field">
			<label>Reference Files</label>
			<div class="ui action input">
				<input type="text" name="fileupload" placeholder="Search..." readonly>
				<input type="file" style="display:none !important;" accept="image/*" multiple>
				<button class="ui button browse file">Cari..</button>
			</div>
	  	</div>
		<div class="field showbrowse file">
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