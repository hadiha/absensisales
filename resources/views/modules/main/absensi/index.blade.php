@extends('layouts.form')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.semanticui.css') }}">
@append

@section('js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/sweetalert2.js') }}"></script>
@append

@section('styles')
    <style type="text/css">
        
    </style>
@append

@section('js-filters')
    d.date = $("input[name='filter[date]']").val();
@endsection

@section('scripts')
    @include('scripts.datatable')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#date').calendar({
                type: 'date',
            });

        });
        
        $('.absen-masuk').on('click', function(e){
            var user_id = '{{auth()->user()->id}}';
            var elem = $(this);
            // console.log(elem);

            $.ajax({
                type: "POST",
                url: "{{ url($pageUrl) }}",
                data: {
					'_token' : '{{ csrf_token() }}',
                    'user_id' : user_id, 
                    'status' : 'hadir' 
                    },
                success: function (response) {
                    if(response.success == true){
                        swal(
                        'Yeaay!',
                        'Anda telah Absen Masuk hari ini.',
                        'success'
                        ).then((result) => {
                            // location.reload();
                            // elem.attr("disabled", true);
                            dt.draw('page');
                            return true;
                        })
                    }else{
                        swal(
                        'Upps!',
                        'Data gagal disimpan.',
                        'error'
                        ).then((result) => {
                            return true;
                        })
                    }
                }
            });
        });

        $('.absen-pulang').on('click', function(e){
            var user_id = '{{auth()->user()->id}}';
            var elem = $(this);
            console.log(user_id);

            $.ajax({
                type: "PUT",
                url: "{{ url($pageUrl) }}/out",
                data: {
					'_token' : '{{ csrf_token() }}',
                    // 'id' : id, 
                    'user_id' : user_id, 
                    },
                success: function (response) {
                    console.log(response);
                    if(response.status == 'berhasil'){
                        swal(
                        'Yeaay!',
                        'Anda telah Absen Pulang hari ini.',
                        'success'
                        ).then((result) => {
                            // location.reload();
                            // elem.attr("disabled", true);
                            dt.draw('page');
                            return true;
                        })
                    }else if(response.status == 'empty'){
                        swal(
                        'Upps!',
                        'Anda Belum Absen Masuk Hari ini.',
                        'error'
                        ).then((result) => {
                            return true;
                        })
                    }else{
                        swal(
                        'Upps!',
                        'Data gagal disimpan.',
                        'error'
                        ).then((result) => {
                            return true;
                        })
                    }
                }
            });
        });

        $('.absen-pengajuan').on('click', function(event) {
            event.preventDefault();
            // /* Act on the event */
            loadModal({
                'url' : '{{ url($pageUrl) }}/create',
                'modal' : '.{{ $modalSize }}.modal',
                'formId' : '#dataForm',
                'onShow' : function(){ 
                    // onShow();
                },
            })
        });
    </script>
    

@append


@section('form')
	{{-- <h1 class="ui center aligned header" style="line-height: 500px">
		U N D E R &nbsp; &nbsp; C O N S T R U C T I O N
    </h1> --}}
    <div class="ui three column doubling stackable grid container">
        <div class="column">
            <div class="ui cards"> 
                <div class="card">
                    <div class="content">
                        <div class="header">Hai, {{auth()->user()->name }}</div>
                        <div class="description">
                            Jangan Lupa untuk mengisi Absen Masuk hari ini dan selamat bekerja.
                        </div>
                    </div>
                    <button class="ui bottom green button absen-masuk" @if($record != 0) disabled @endif>
                        <i class="sign in icon"></i>
                        Absen Masuk
                    </button>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui cards">
                <div class="card">
                    <div class="content">
                        <div class="header">Hai, {{auth()->user()->name }}</div>
                        <div class="description">
                            Jangan Lupa untuk mengisi Absen Pulang hari ini dan selamat beristirahat.
                        </div>
                    </div>
                    <button class="ui bottom brown button absen-pulang">
                        <i class="sign out icon"></i>
                        Absen Pulang
                    </button>
                </div>
            </div>
        </div>
        <div class="column">
          <div class="ui cards">
            <div class="card">
                <div class="content">
                    <div class="header">Hai, {{auth()->user()->name }}</div>
                    <div class="description">
                        Apabila Anda tidak masuk kerja (Izin, Sakit, Cuti) silakan isi permohonan disini.
                    </div>
                </div>
                <button class="ui bottom teal button absen-pengajuan">
                    <i class="add icon"></i>
                    Ajukan
                </button>
            </div>
            </div>
        </div>
    </div>

        
    <div class="ui segments" style="margin-top: 25px">
        <div class="ui segment">
            <form class="ui filter form">
                <div class="inline fields">
                    <div class="field">
                        <div class="ui month" id="date">
                            <div class="ui input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" name="filter[date]"  placeholder="Tanggal">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="ui teal icon filter button" data-content="Cari Data">
                        <i class="search icon"></i>
                    </button>
                    <button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
                        <i class="refresh icon"></i>
                    </button>
                </div>

                @if(isset($tableStruct))
                <table id="listTable" class="ui celled compact red table display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @foreach ($tableStruct as $struct)
                                <th class="center aligned">{{ $struct['label'] or $struct['name'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @yield('tableBody')
                    </tbody>
                </table>
                @endif
            </form>
        </div>
    </div>
@endsection


