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
        	<label>Nama Sales</label>
            <select name="user_id" class="ui search dropdown">
				{!! \App\Models\Authentication\User::options('name','id',[],'Pilih Nama') !!}
			</select>
        </div>
        <div class="field">
        	<label>Nama Area</label>
            <select name="area_id" class="ui search dropdown">
				{!! \App\Models\Master\Area::options('name','id',[],'Pilih Area') !!}
			</select>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Mulai Tanggal</label>
			  <div class="ui calendar" id="rangestart">
				<div class="ui input left icon">
				  <i class="calendar icon"></i>
				  <input type="text" name="start_date" placeholder="Mulai" tabindex="0" class="">
				</div>
			  </div>
			</div>
			<div class="field">
			  <label>Sampai Tanggal</label>
			  <div class="ui calendar" id="rangeend">
				<div class="ui input left icon">
				  <i class="calendar icon"></i>
				  <input type="text" name="end_date" placeholder="Sampai" tabindex="0" class="">
				</div>
			  </div>
			</div>
		</div>
		<div class="field">
        	<label>Koordinator</label>
            <select name="koordinator_id" class="ui search dropdown">
				{!! \App\Models\Authentication\User::options('name','id',[],'Pilih Nama') !!}
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