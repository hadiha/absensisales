<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Ubah Data {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="id" value="{{ $record->id }}">
        <div class="field">
            <label>Nama Hak Akses</label>
            <input type="text" placeholder="Nama Hak Akses" name="display_name" value="{{ $record->display_name }}">
        </div>
        <div class="field">
            <label>Kode</label>
            <input type="text" placeholder="Kode Hak Akses" name="name" value="{{ $record->name }}">
        </div>
        <div class="field">
            <label>Deskripsi</label>
            <textarea name="description" placeholder="Deskripsi Hak Akses" style="resize: none;" rows="3">{!! nl2br(e($record->description)) !!}</textarea>
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