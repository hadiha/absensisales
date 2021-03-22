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
		<input type="hidden" name="client_id" value="{{$record->client_id}}">
        <div class="field">
        	<label>Nama Sales</label>
            <select name="user_id" class="ui search dropdown" disabled>
				@foreach ($user as $val)
					<option value="{{ $val->id }}" {{ $val->id==$record->user_id?'selected':'' }}>{{ $val->name }}</option>
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
		<div class="two fields">
			<div class="field">
			  <label>Mulai Tanggal</label>
			  <div class="ui calendar" id="rangestart">
				<div class="ui input left icon">
				  <i class="calendar icon"></i>
				  <input type="text" name="start_date" placeholder="Mulai" tabindex="0" class="" value="{{$record->start_date}}">
				</div>
			  </div>
			</div>
			<div class="field">
			  <label>Sampai Tanggal</label>
			  <div class="ui calendar" id="rangeend">
				<div class="ui input left icon">
				  <i class="calendar icon"></i>
				  <input type="text" name="end_date" placeholder="Sampai" tabindex="0" class="" value="{{$record->end_date}}">
				</div>
			  </div>
			</div>
		</div>
		<div class="field">
        	<label>Koordinator</label>
            <select name="koordinator_id" class="ui search dropdown">
				@foreach ($user as $val)
					<option value="{{ $val->id }}" @if($val->id==$record->koordinator_id) selected @endif>{{ $val->name }}</option>
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