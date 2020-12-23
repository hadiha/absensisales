@extends('layouts.form')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-lite.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
<script src="{{ asset('plugins/summernote/summernote-lite.js') }}"></script>
<script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append


@section('rules')
<script type="text/javascript">
	formRules = {
		judul: 'empty',
		sub_judul: 'empty',
		url: 'url',
	};
</script>
@endsection

@section('styles')
@append

@section('scripts')
<script type="text/javascript">

</script>
@append

@section('content-header')
<h2 class="ui header">
	<div class="content">
		{!! $title or '-' !!}
		<div class="sub header">{!! $subtitle or '' !!}</div>
	</div>
</h2>
@endsection

@section('form')
<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header"></div>
<div class="content">
	{!! $message or '' !!}
	<form class="ui large form" id="dataForm" role="form" method="POST" action="{{ url('ganti-password').'/'.$user->id }}" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
		{!! csrf_field() !!}        
		<div class="ui grid">
			{{-- <div class="sixteen wide tablet column">
				<h4 class="ui horizontal divider header">
					<i class="address book icon"></i>
					Profile Detail
				</h4>
			</div> --}}
			<input type="hidden" name="id" value="{{ $user->id }}">
			<div class="sixteen wide tablet eight wide computer column">
				<div class="two fields">
					<div class="eleven wide field">
						<div class="two fields">
							<div class="five wide field">
								<label for="oldpassword" style="text-align: left;">Password Lama</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="password"  placeholder="Password Lama" name="oldpassword" required>
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Password Baru</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="password" name="newpassword" placeholder="Password baru" " required autocomplete="off">
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Confirm Password Baru</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="password" name="confirmnewpassword" placeholder="Confirm Password Baru" required autocomplete="off">
								</div>
							</div>
						</div>      
					</div>
				</div>             
			</div> <!-- end -->
			<div class="sixteen wide tablet eight wide computer column">
			</div> <!-- end column 2 -->
		</div> <!-- end Grid -->
		<div class="actions" align="right">
			<div class="ui black deny page button">
				Batal
			</div>
			<button class="ui positive right labeled icon button" type="submit" > 
				Simpan
				<i class="checkmark icon">		
				</i>
			</button>
			{{-- <div class="ui positive right labeled icon save page button">
				Simpan
				<i class="checkmark icon"></i>
			</div> --}}
		</div>
	</form>
</div>
@endsection
