<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Buat Data {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
        <div class="field">
        	<label>Nama Hak Akses</label>
            <input type="text" placeholder="Nama Hak Akses" name="display_name" value="{{ old('display_name') }}">
        </div>
        <div class="field">
        	<label>Kode</label>
            <input type="text" placeholder="Kode Hak Akses" name="name" value="{{ old('name') }}">
        </div>
        <div class="field">
        	<label>Deskripsi</label>
            <textarea name="description" placeholder="Deskripsi Hak Akses" style="resize: none;" rows="3"></textarea>
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