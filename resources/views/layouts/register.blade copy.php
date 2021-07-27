<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Site Properties -->
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">

    <style type="text/css">
    body {
        {{-- background: url({{ asset('img/bg.jpg') }}) center center no-repeat transparent; --}}
        /*background-color: #2cace2;*/
        background-size: cover;
        background-position: top center;
        background-attachment: fixed;
        position: relative;
    }
    body > .grid {
        min-height: 100%;
    }
    .image {
        margin-top: -100px;
    }
    .column {
        /*max-width: 450px;*/
        z-index: 2;
    }
    body:before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        background-color: rgba(0,0,0,0.6);
    }
    .ui.header .content{
        text-shadow: 0px 0px 6px #fff;
    }
    .title {
        margin-top: 0
    }
    .title-logo {
        /*max-width: 480px;*/
        /*min-width: 800px;*/
        width: 100%;
        color: #fff;
        /*filter: drop-shadow(0 0 3px rgba(255,255,255,0.4));*/
        letter-spacing: 3px;
    }
    /*.title-logo img {*/
    img.title-logo {
        width: 100%;
        max-width: 300px;
    }
    .ui.grid {
        margin: 0;
    }
    .login.container {
        justify-content: space-evenly!important;
    }

    .ui.grid.compact > .column {
        padding: 0
    }

    /*
    @media(min-width: 768px) {
        .title-logo {
            max-width: 540px;
        }
        .title-logo img {
            max-width: 540px
        }
    }

    @media(min-width: 960px) {
        .title-logo {
            max-width: 540px;
        }
        .title-logo img {
            max-width: 540px
        }
    }
    */
</style>
@yield('style')
</head>
<body>
    <div class="overlay"></div>
    @yield('content')

    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('plugins/jQuery/jquery.form.min.js') }}"></script>
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('semantic/semantic.min.js') }}"></script>
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
    <script src="{{ asset('semantic/semantic.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function($) {
            $('.message .close')
            .on('click', function() {
                $(this)
                .closest('.message')
                .transition('fade')
                ;
            });

            $('.ui.calendar').calendar({
              monthFirst: false,
              type: 'date',
              formatter: {
                date: function (date, settings) {
                  if (!date) return '';
                  var day = date.getDate();
                  var month = date.getMonth() + 1;
                  var year = date.getFullYear();
                  return day + '/' + month + '/' + year;
                }
              }
          });
        });


        $(document).ready(function() {
            // $('.ui.form')
            // .form({
            //     fields: {
            //         email: {
            //             identifier  : 'email',
            //             rules: [
            //             {
            //                 type   : 'empty',
            //                 prompt : 'Please enter your e-mail'
            //             },
            //             {
            //                 type   : 'email',
            //                 prompt : 'Please enter a valid e-mail'
            //             }
            //             ]
            //         },
            //         password: {
            //             identifier  : 'password',
            //             rules: [
            //             {
            //                 type   : 'empty',
            //                 prompt : 'Please enter your password'
            //             },
            //             {
            //                 type   : 'length[6]',
            //                 prompt : 'Your password must be at least 6 characters'
            //             }
            //             ]
            //         }
            //     }
            // })

            $('.ui.dropdown').dropdown();
            // force onChange  event to fire on initialization
            $('.ui.dropdown')
                .closest('.ui.selection')
                .find('.item.active').addClass('qwerty').end()
                .dropdown('clear')
                .find('.qwerty').removeClass('qwerty')
                .trigger('click');
        })
        ;
    </script>

    @yield('scripts')
</body>
</html>
