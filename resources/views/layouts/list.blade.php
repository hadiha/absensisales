@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.semanticui.css') }}">
    <style type="text/css">
        td.details-control.button {
            background: green no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control.button {
            background: red no-repeat center center;
        }
        .text-center {
            text-align: center !important;
        }
    </style>
@append

@section('js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script> --}}
    <script src="{{ asset('plugins/sweetalert/sweetalert2.js') }}"></script>
    {{-- <script src="{{ asset('plugins/jquery-numeric/jquery-numeric.min.js') }}"></script> --}}
@append

@section('scripts')
    <script type="text/javascript">
        // global
        var dt = "";
        var formRules = [];
        var onShow = function(){
            $('.checkbox').checkbox();
            $('.ui.dropdown').dropdown({
                onChange: function(value) {
                    var target = $(this).dropdown();
                    if (value!="") {
                        target
                            .find('.dropdown.icon')
                            .removeClass('dropdown')
                            .addClass('delete')
                            .on('click', function() {
                                target.dropdown('clear');
                                $(this).removeClass('delete').addClass('dropdown');
                                return false;
                            });
                    }
                }
            });
            // force onChange  event to fire on initialization
            $('.ui.dropdown')
                .closest('.ui.selection')
                .find('.item.active').addClass('qwerty').end()
                .dropdown('clear')
                    .find('.qwerty').removeClass('qwerty')
                .trigger('click');

            return false;
        };

        $.fn.form.settings.prompt = {
            empty                : '{name} tidak boleh kosong',
            checked              : '{name} harus dipilih',
            email                : '{name} tidak valid',
            url                  : '{name} tidak valid',
            regExp               : '{name} is not formatted correctly',
            integer              : '{name} must be an integer',
            decimal              : '{name} must be a decimal number',
            number               : '{name} hanya boleh berisikan angka',
            is                   : '{name} must be "{ruleValue}"',
            isExactly            : '{name} must be exactly "{ruleValue}"',
            not                  : '{name} cannot be set to "{ruleValue}"',
            notExactly           : '{name} cannot be set to exactly "{ruleValue}"',
            contain              : '{name} cannot contain "{ruleValue}"',
            containExactly       : '{name} cannot contain exactly "{ruleValue}"',
            doesntContain        : '{name} must contain  "{ruleValue}"',
            doesntContainExactly : '{name} must contain exactly "{ruleValue}"',
            minLength            : '{name} setidaknya haru memiliki {ruleValue} karakter',
            length               : '{name} must be at least {ruleValue} characters',
            exactLength          : '{name} must be exactly {ruleValue} characters',
            maxLength            : '{name} tidak boleh lebih dari {ruleValue} karakter',
            match                : '{name} must match {ruleValue} field',
            different            : '{name} must have a different value than {ruleValue} field',
            creditCard           : '{name} must be a valid credit card number',
            minCount             : '{name} must have at least {ruleValue} choices',
            exactCount           : '{name} must have exactly {ruleValue} choices',
            maxCount             : '{name} must have {ruleValue} or less choices'
        };
        
        $(document).on('click', '.ui.add.button', function(event) {
            event.preventDefault();
            // /* Act on the event */
            loadModal({
                'url' : '{{ url($pageUrl) }}/create',
                'modal' : '.{{ $modalSize }}.modal',
                'formId' : '#dataForm',
                'onShow' : function(){ 
                    onShow();
                },
            })
        });
        
        $(document).on('click', '.ui.edit.button', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            // /* Act on the event */
            loadModal({
                'url' : '{{ url($pageUrl) }}/'+id+'/edit',
                'modal' : '.{{ $modalSize }}.modal',
                'formId' : '#dataForm',
                'onShow' : function(){ 
                    onShow();
                },
            })
        });

        $(document).on('click', '.ui.custom.button', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var url = $(this).data('url');
            // /* Act on the event */
            loadModal({
                'url' : url,
                'modal' : '.{{ $modalSize }}.modal',
                'formId' : '#dataForm',
                'onShow' : function(){ 
                    onShow();
                },
            })
        });
    </script>
    @yield('rules')
    @yield('init-modal')
    
    @include('scripts.datatable')
    @include('scripts.action')
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
    <div class="ui grid">
        <div class="sixteen wide column main-content">
            <div class="ui segments">
                <div class="ui segment">
                    <form class="ui filter form">
                        <div class="inline fields">
                            {{-- <div class="field">
                                <select name="filter[entri]" id="" class="ui compact selection dropdown">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div> --}}
                            @section('filters')
                                <div class="ui one wide field">
                                    <select name="filter[page]">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="ui three wide field">
                                    <input name="filter[search]" placeholder="No.Pendaftaran/Nama/UN" type="text">
                                </div>
                                <button type="button" class="ui teal icon filter button" data-content="Cari Data">
                                    <i class="search icon"></i>
                                    &nbsp;&nbsp;Cari
                                </button>
                            @show
                            <div style="margin-left: auto; margin-right: 1px;">
                                @section('toolbars')
                                    @if($pagePerms == '' || auth()->user()->can($pagePerms.'-add'))
                                    <button type="button" class="ui blue @if($pagePerms != '' && !auth()->user()->can($pagePerms.'-add')) disabled @endif button add">
                                        <i class="add icon"></i>
                                        Tambah Data
                                    </button>
                                    @endif
                                @show
                            </div>
                        </div>
                    </form>

                    @section('subcontent')
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
                    @show
                </div>
            </div>
        </div>
    </div>
    @show
@endsection

@section('modals')

@append