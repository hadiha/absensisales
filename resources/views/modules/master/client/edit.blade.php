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
        	<label>Kode Klien</label>
            <input type="text" placeholder="Kode Klien" name="code" value="{{$record->code}}">
        </div>
        <div class="field">
        	<label>Nama Klien</label>
            <input type="text" placeholder="Nama Klien" name="name" value="{{$record->name}}">
        </div>
        <div class="sixteen wide field">
			<label>Logo</label>
			<div class="ui action input">
				<input type="text" placeholder="Logo" name="file" value="{{$record->filename}}" readonly>
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