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
        	<label>Nama Sales</label>
            <select name="user_id" class="ui search dropdown">
				@foreach ($user as $val)
					<option value="{{ $val->id }}" {{ $val->id==$record->user_id?'selected':'' }}>{{ $val->username }}</option>
				@endforeach
			</select>
        </div>
        <div class="field">
        	<label>Nama Area</label>
            <select name="area_id" class="ui search dropdown">
				@foreach ($area as $val)
					<option value="{{ $val->id }}" {{ $val->id==$record->area_id?'selected':'' }}>{{ $val->name }}</option>
				@endforeach
			</select>
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