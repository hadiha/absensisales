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
				{!! \App\Models\Authentication\User::options('username','id',[],'Pilih Nama') !!}
			</select>
        </div>
        <div class="field">
        	<label>Nama Area</label>
            <select name="area_id" class="ui search dropdown">
				{!! \App\Models\Master\Area::options('name','id',[],'Pilih Area') !!}
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