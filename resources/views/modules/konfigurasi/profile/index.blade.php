@extends('layouts.form')

@section('css')
@append

@section('js')
@append
@section('scripts')
    <script type="text/javascript">
    $(document).ready(function() {
        $('#birth').calendar({
            type: 'date',
        });
	});

    $('.special.cards .image').dimmer({
      on: 'hover'
    });

    $('div.change.picture.button').on('click', function (e) {
        var filebutton = $(this).parents('.card').find('input[type="file"]');
        console.log(filebutton);
        filebutton.trigger('click');
    });

    $('input[type="file"]').on('change', function (f) {
        var loading = `<div class="ui active inverted dimmer">
                        <div class="ui small text loader">Loading</div>
                    </div>`;

        var elem = $(this);
        var url = $(this).data('url');

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('id', '{{ auth()->user()->id }}');
        formData.append('picture', f.target.files[0]);

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend : function () {
                elem.parents('.card').append(loading);
            },
            data : formData,
            success: function(resp){
                console.log(resp);
                elem.parents('.card').find('.ui.active.inverted.dimmer').remove();
                elem.parents('.card').find('img').attr('src', resp.url);
            },
            error : function(resp){
            },
        })
    });


    $(document).on('click', '.save-change.password.button', function(e){
        swal({
            title: "Ubah Password",
            text: "Apakah Anda Yakin?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                $('#dataPassword').find('.loading.dimmer').addClass('active');

                // begin submit
                $("#dataPassword").ajaxSubmit({
                    success: function(resp){
                        console.log('save...')
                        swal({
                            title:'Tersimpan!',
                            text:'Data berhasil disimpan.',
                            type:'success',
                            allowOutsideClick: false,
                            showCancelButton: false,

                            confirmButtonColor: '#0052DC',
                            confirmButtonText: 'Tutup',
                            
                            cancelButtonColor: '#6E6E6E',
                            cancelButtonText: 'Print'
                        }).then((result) => { // ok
                            location.href = '{{ url($pageUrl) }}';

                        }, function(dismiss) { // cancel
                            
                        })
                    },
                    error: function(resp){
                        $('#dataPassword').find('.loading.dimmer').removeClass('active');
                        // $('#cover').hide();
                        var response = resp.responseJSON;
                        $.each(response.errors, function(index, val) {
                            clearFormError(index,val);
                            showPasswordError(index,val);
                        });
                        time = 5;
                        interval = setInterval(function(){
                            time--;
                            if(time == 0){
                                clearInterval(interval);
                                $('.pointing.prompt.label.transition.visible').fadeOut('slideUp', function(e) {
                                    $(this).remove();
                                });
                                $('.error').each(function (index, val) {
                                    $(val).removeClass('error');
                                });
                            }
                        },1000)
                    }
                });
            }
        })
    })

        
	function showPasswordError(key, value)
	{
		if(key.includes("."))
		{
			res = key.split('.');
			key = res[0] + '[' + res[1] + ']';
			if(res[1] == 0)
			{
				key = res[0] + '\\[\\]';
			}
		}
		var elm = $('#dataPassword' + ' [name=' + key + ']').closest('.field');
		$(elm).addClass('error');
		var message = `<div class="ui basic red pointing prompt label transition visible">`+ value +`</div>`;

		var showerror = $('#dataPassword' + ' [name=' + key + ']').closest('.field');
		$(showerror).append('<div class="ui basic red pointing prompt label transition visible">' + value + '</div>');
	}

    </script>
@append


@section('form')
    <form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
        <div class="sub header"><b> Profile</b></div>
        <div class="ui grid">
            <div class="sixteen wide column">
                <table class="ui borderless very basic table">
                    <tbody>
                        <tr>
                            <td rowspan="4" class="five wide center aligned top aligned">
                                <div class="ui special cards">
                                    <div class="card">
                                        <input type="file" class="hidden" name="foto" accept="image/*" data-url="{{ url($pageUrl.'foto/') }}">
                                        <div class="blurring dimmable image">
                                            <div class="ui dimmer">
                                                <div class="content">
                                                    <div class="center">
                                                        <div class="ui inverted change picture button">Ganti</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="{{ auth()->user()->showfotopath() }}">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td colspan="2" style="padding-left:0px;">
                                <div class="field">
                                    <label>Nama</label>
                                    <div class="ui icon input" style="width: 100%; height: 35px">
                                        <input type="text" placeholder="Nama" name="name" value="{{ auth()->user()->name }}">
            							<i class="user icon"></i>
            						</div>
                                </div>
                            </td>
                            <td>
                                <div class="field maxdate">
            						<label>Email</label>
            						<div class="ui icon input" style="width: 100%; height: 35px">
                                        <input type="email" name="email" style="height: 35px;" value="{{auth()->user()->email}}" readonly>
                                        <i class="envelope icon"></i>
            						</div>
            					</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:0px;">
                                <div class="field">
                                    <label>Gender</label>
                                    <div class="inline fields">
                                        <div class="field">
                                            <div class="ui radio checkbox">
                                                <input type="radio" name="gender" value="male" {{ auth()->user()->gender != NULL ?( auth()->user()->gender == 'male' ? 'checked' : '') : '' }}>
                                                <label>Male</label>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="ui radio checkbox">
                                                <input type="radio" name="gender" value="female" {{ auth()->user()->gender != NULL ?( auth()->user()->gender == 'female' ? 'checked' : '') : '' }}>
                                                <label>Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td colspan="2">
                                <div class="field">
            						<label>Phone</label>
            						<div class="ui icon input" style="width: 100%; height: 35px">
            							<input type="text" name="phone" style="height: 35px;" value="{{auth()->user()->phone}}">
            							<i class="phone icon"></i>
            						</div>
            					</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="field">
            						<label>Tempat Lahir</label>
            						<div class="ui icon input" style="width: 100%; height: 35px">
            							<input type="text" name="birth_place" style="height: 35px;" value="{{auth()->user()->birth_place}}">
            							<i class="map pin icon"></i>
            						</div>
            					</div>
                            </td>
                            <td>
                                <div class="field" id="birth">
            						<label>Tanggal Lahir</label>
            						<div class="ui icon input" style="width: 100%; height: 35px">
            							<input type="text" name="birth_date" style="height: 35px;" value="{{auth()->user()->birth_date}}">
            							<i class="calendar alternate icon"></i>
            						</div>
            					</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ui grid">
            <div class="right aligned column">
                <div class="ui positive right labeled icon save as page button">
                    Update
                    <i class="checkmark icon"></i>
                </div>
            </div>
        </div>
    </form>
    <hr style="margin-top: 15px">
    <form class="ui data form" id="dataPassword" action="{{ url($pageUrl.auth()->user()->id) }}" method="POST">
        {!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
        <div class="sub header"><b> * Change Password</b></div>
        <div class="ui grid">
            <div class="sixteen wide column">
                <table class="ui borderless very basic table">
                    <tbody>
                        <tr>
                            <td>
                                <div class="field">
                                    <label>Password Lama</label>
                                    <div class="ui icon input" style="width: 100%; height: 35px">
                                        <input type="password" placeholder="Password Lama" name="password_lama">
                                        <i class="lock icon"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="field">
                                    <label>Password Baru</label>
                                    <div class="ui icon input" style="width: 100%; height: 35px">
                                        <input type="password" placeholder="Passwor Baru" name="password">
                                        <i class="lock icon"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="field maxdate">
                                    <label>Confirmasi Password</label>
                                    <div class="ui icon input" style="width: 100%; height: 35px">
                                        <input type="password" name="confirm_password" style="height: 35px;" placeholder="Confirm Password">
                                        <i class="lock icon"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    	<div class="ui two column grid">
    		<div class="left aligned column">
    			<a class="ui labeled icon button" href="javascript:history.back()">
    				<i class="chevron left icon"></i>
    				Back
    			</a>
    		</div>
    		<div class="right aligned column">
                <div class="ui positive right labeled icon save-change password button">
                    Change Password
                    <i class="checkmark icon"></i>
                </div>
    		</div>
    	</div>
    </form>
@endsection
