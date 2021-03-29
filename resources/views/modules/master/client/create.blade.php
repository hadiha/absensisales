<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Buat {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST" enctype="multipart/form-data">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
        <div class="field">
        	<label>Kode Klien</label>
            <input type="text" placeholder="Kode Klien" name="code">
        </div>
        <div class="field">
        	<label>Nama Klien</label>
            <input type="text" placeholder="Nama Klien" name="name">
        </div>
		<div class="sixteen wide field">
			<label>Logo</label>
			<div class="ui action input">
				<input type="text" placeholder="Logo" name="file" readonly>
				<input type="file" name="logo" style="display:none !important;" accept="image/*">
				<div class="ui icon button">
				Cari
				</div>
			</div>
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