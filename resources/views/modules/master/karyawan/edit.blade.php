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
        	<label>Username</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Username" name="username" value="{{ $record->username }}">
            </div>
        </div>
        <div class="field">
        	<label>E-Mail</label>
            <div class="ui left icon input">
                <i class="mail icon"></i>
                <input type="email" placeholder="E-Mail" name="email" value="{{ $record->email }}">
            </div>
        </div>
        <div class="field">
        	<label>Hak Akses</label>
			<select name="roles[]" class="ui fluid multiple dropdown" multiple>
				{!! App\Models\Authentication\Role::options('display_name', 'id', ['selected' => $record->roles->pluck('id')->toArray()], 'Pilih Hak Akses') !!}
			</select>
        </div>
        <div class="field">
        	<label>Password Lama</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="password_lama" placeholder="Password Lama">
            </div>
        </div>
        <div class="field">
        	<label>Password</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="password" placeholder="Password Baru">
            </div>
        </div>
        <div class="field">
        	<label>Konfirmasi Password</label>
            <div class="ui left icon input">
                <i class="unlock alternate icon"></i>
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password">
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