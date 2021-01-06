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
        	<label>Username</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Username" name="username" value="{{ old('username') }}">
            </div>
        </div>
        <div class="field">
        	<label>E-Mail</label>
            <div class="ui left icon input">
                <i class="mail icon"></i>
                <input type="email" placeholder="E-Mail" name="email" value="{{ old('email') }}">
            </div>
        </div>
        <div class="field">
        	<label>Nama Lengkap</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Nama" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="field">
        	<label>Phone</label>
            <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" placeholder="Phone" name="phone" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="field">
        	<label>Hak Akses</label>
			<select name="roles[]" class="ui fluid multiple dropdown" multiple>
				{!! App\Models\Authentication\Role::options('display_name', 'id', [], 'Pilih Hak Akses') !!}
			</select>
        </div>
        <div class="field">
        	<label>Password</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="password" placeholder="Password">
            </div>
        </div>
        <div class="field">
        	<label>Confirm Password</label>
            <div class="ui left icon input">
                <i class="unlock alternate icon"></i>
                <input type="password" name="confirm_password" placeholder="Confirm Password">
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