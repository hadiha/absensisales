<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Style --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/app-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mfs.css') }}">
    <style type="text/css">
        .ui.file.input input[type="file"] {
            display: none;
        }
        .ui.button>.ui.floated.label {
            position: absolute;
            top: 15px;
            right: -10px;
        }
        .table tr th{
            white-space: nowrap;
        }
    </style>
    @yield('css')
    @yield('styles')

    {{-- google map --}}
    {{-- <script src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyA8WTG1zwwvBcVhFGOgg2WHPInYYIZZrDs&libraries=places" type="text/javascript"></script> --}}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119518882-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-119518882-2');
    </script> --}}

</head>

<body id="app">
    <header>
        @include('partials.header')
    </header>

    <div class="ui sidebar visible vertical menu">
        <div class="ui fluid accordion" id="sideMenu">
            @include('partials.menu', ['items' => $mainMenu->roots()])
            {{-- @include('partials.menu') --}}
        </div>
    </div>
    <div id="cover">
        <div class="ui active inverted dimmer">
            <div class="ui text loader">Loading</div>
        </div>
    </div>

    <div class="pusher content shown">
        <message></message>
        <div class="main ui fluid container" id="main-container">
            @yield('content')
        </div>

        <footer class="ui vertical footer fixed segment">
            <div class="ui grid blue">
                <div class="ui sixteen wide column center aligned">
                    <span><i>2018 &copy; {{ config('app.longname') }}</i></span>
                </div>
            </div>
        </footer>
    </div>

    {{-- @include('partials.footer') --}}

    {{-- form modals --}}
    @yield('modals')
    <div class="ui mini modal">
        <div class="ui inverted loading dimmer">
            <div class="ui text loader">Loading</div>
        </div>
    </div>

    <div class="ui tiny modal">
        <div class="ui inverted loading dimmer">
            <div class="ui text loader">Loading</div>
        </div>
    </div>

    <div class="ui small modal">
        <div class="ui inverted loading dimmer">
            <div class="ui text loader">Loading</div>
        </div>
    </div>

    <div class="ui large modal">
        <div class="ui inverted loading dimmer">
            <div class="ui text loader">Loading</div>
        </div>
    </div>

    <div class="ui fullscreen modal">
        <div class="ui inverted loading dimmer">
            <div class="ui text loader">Loading</div>
        </div>
    </div>

    {{-- Script --}}
    <script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!}
    </script>
    {{-- <script src="{{ asset('js/es6-promise.auto.min.js') }}"></script> --}}
    
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('plugins/jQuery/jquery.form.min.js') }}"></script>
    <script src="{{ asset('plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('semantic/semantic.min.js') }}"></script>
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>

    <script src="{{ asset('js/app-v2.js') }}"></script>
    {{-- <script src="{{ asset('js/global-variable.js') }}"></script> --}}
    @yield('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sideMenu').find('.ui.content').each(function(e){
                if(!$.trim($(this).html())){
                    $(this).prev('.ui.title').hide('fast');
                    $(this).hide('fast');
                }
            });

            // initialize and add onChange event
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

            $('.message .close').on('click', function() {
                $(this).closest('.message').transition('fade');
            });

            getNotification();
        });

        $(document).on('click', '.ui.file.input input:text, .ui.button', function(e) {
            $(e.target).parent().find('input:file').click();
        });

        $(document).on('change', '.ui.file.input input:file', function(e) {
            console.log(name);
            var file = $(e.target);
            var name = '';

            for (var i=0; i<e.target.files.length; i++) {
              name += e.target.files[i].name + ', ';
            }
            // remove trailing ","
            name = name.replace(/,\s*$/, '');

            $('input:text', file.parent()).val(name);
        });

        function getNotification() {
            var html = '';
            $.ajax({
                url: '{{ url("absensi/notif") }}',
                type: 'GET',
                success: function(resp){
                    if(resp.record.length !== 0){
                        $.each(resp.record,function(k,v){
                            var url = '{{url('')}}'+'/'+v.notifiable_type+'/'+v.notifiable_id;
                            const time = moment(v.created_at).fromNow();
                            html += `
                                <div class="item">
                                    <i class="large calendar check middle aligned icon"></i>
                                    <div class="content detail-notif" data-href="`+url+`">
                                        <a class="header">`+ v.type +`</a>
                                        <div class="description">
                                            <i class="clock icon"></i> `+ time +`
                                        </div>
                                    </div>
                                </div>`;
                        });
                    }else{
                        html += `<div class="item">
                                    <i class="bell icon"></i>
                                    <div class="content">
                                        <u>Belum Ada Notif</u>
                                    </div>
                                </div>`;
                    }
                    $('#count-notif').html(resp.lengths);
                    $('#area-notif').html(html);
                    $('.ui.dropdown.teals').dropdown();
                    $('.ui.accordion').accordion();
                }, error : function(resp){

                }
            });
        }

        $(document).on('click','.detail-notif', function(e){
            var url = $(this).data('href');

            loadModal({
                'url' : url,
                'modal' : '.{{ $modalSize }}.modal',
                'formId' : '#dataForm',
                'onShow' : function(){ 
                    // onShow();
                },
            })
        });


    </script>
        
    @yield('scripts')
    @yield('addmore')
</body>
</html>
