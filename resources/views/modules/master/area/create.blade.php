<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Buat {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
		@if (auth()->user()->client_id == null)
			<div class="field">
				<label>Nama Klien</label>
				<select name="client_id" class="ui search dropdown">
					{!! \App\Models\Master\Client::options('name','id',[],'Pilih Klien') !!}		
				</select>
			</div>
		@else
			<input type="hidden" name="client_id" value="{{auth()->user()->client_id}}">
		@endif
        <div class="field">
        	<label>Kode Area</label>
            <input type="text" placeholder="Kode Area" name="kode">
        </div>
        <div class="field">
        	<label>Nama Area</label>
            <input type="text" placeholder="Nama Area" name="name">
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