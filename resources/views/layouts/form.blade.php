@extends('layouts.base')

@section('css')
@append

@section('styles')
    <style type="text/css">
        .text-center {
            text-align: center !important;
        }
        .ui.radio.checkbox {
            margin: 0px !important;
        }
        .results.transition.visible{
            width: 31em !important;
        }
        .min-content {
            min-height: 250px;
        }
    </style>
@append

@section('js')
    <script src="{{ asset('plugins/input-mask/jquery.mask.js') }}"></script>
    <script src="{{ asset('plugins/jquery-numeric/jquery-numeric.min.js') }}"></script>
@append

@section('scripts')
    @include('scripts.action')
    <script type="text/javascript">     
        $(document).on('click', '.save.page.button', function(e){
            swal({
                title: "Simpan Data",
                text: "Apakah data yang ingin anda simpan sudah sesuai?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result) {
                    saveData('dataForm');
                }
            })
        })

        $(document).on('click', '.draft.page.button', function(e){
            saveData('dataForm');
        })

        $(document).on('click', '.deny.page.button', function(e){
            location.href = "{{ url($pageUrl) }}";
        })

        $(document).on('click', '.back.page.button', function(e){
            location.href = "/";
        })

    </script> 
@append

@section('content')
    @section('content-header')
    <div class="ui breadcrumb">
        <div class="active section"><i class="home icon"></i></div>
        <i class="right chevron icon divider"></i>
        <?php $i=1; $last=count($breadcrumb);?>
        @foreach ($breadcrumb as $name => $link)
            @if($i++ != $last)
                <a href="{{ $link }}" class="section">{{ $name }}</a>
                <i class="right chevron icon divider"></i>
            @else
                <div class="active section">{{ $name }}</div>
            @endif
        @endforeach
    </div>
    <h2 class="ui header">
      <div class="content">
        {!! $title or '-' !!}
        <div class="sub header">{!! $subtitle or ' ' !!}</div>
      </div>
    </h2>
    @show

    <div class="ui clearing divider" style="border-top: none !important; margin:10px"></div>

    @section('content-body')
    <div class="ui centered grid">
        <div class="{{ isset($form_class)?$form_class:'' }} column main-content">
            <div class="ui segments">
                <div class="ui segment">
                    @yield('form')
                </div>
            </div>
        </div>
    </div>
    @show
@endsection


@section('modals')
<div class="ui big modal" id="formModal">
    <div class="ui inverted loading dimmer">
        <div class="ui text loader">Loading</div>
    </div>
</div>
@append
