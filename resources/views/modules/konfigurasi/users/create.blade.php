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
			<select name="roles[]" class="ui fluid dropdown hak-akses">
				{!! App\Models\Authentication\Role::options('display_name', 'id', [], 'Pilih Hak Akses') !!}
			</select>
        </div>
        @if (auth()->user()->client_id == null)
            <div class="field">
                <label>Klien</label>
                <select name="client_id" class="ui fluid dropdown hak-akses">
                    {!! App\Models\Master\Client::options('name', 'id', [], 'Pilih Klien') !!}
                </select>
            </div>
        @else
            <input type="hidden" name="client_id" value="{{auth()->user()->client_id}}">    
        @endif
        <div class="field chose-area" style="display: none">
        	<label>Area</label>
            <div class="ui left icon input">
                <i class="lock icon"></i>
                @if (auth()->user()->client_id == null)
                    <select name="area_id" class="ui fluid dropdown">
                        {!! App\Models\Master\Area::options('name', 'id', [], 'Pilih Area') !!}
                    </select>
                @else
                <select name="area_id" class="ui fluid dropdown">
                    <option value="">Pilih Area</option>
                    @foreach (App\Models\Master\Area::where('client_id', auth()->user()->client_id)->get() as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @endif
            </div>
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