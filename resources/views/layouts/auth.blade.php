<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>{{ config('app.longname') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/semantic.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}">

    <link href="{{ asset('css/login/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">

    <style type="text/css">
        html, body{
            min-height: 100%;
        }
        body {
            /*background: url({{ asset('img/bg-alt.png') }});*/
            background-size: cover;
            background-position: bottom;
            position: relative;
        }
        body > .grid {
            height: 100%;
        }
        .image {
            margin-top: -100px;
        }
        .column {
            max-width: 450px;
            z-index: 2;
        }
        .overlay{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-color: rgba(0,0,0,0.1); /*dim the background*/
        }
    </style>
<script>
    // $(document)
    // .ready(function() {
    //     $('.ui.form')
    //     .form({
    //         fields: {
    //             username: {
    //                 identifier  : 'text',
    //                 rules: [
    //                 {
    //                     type   : 'empty',
    //                     prompt : 'Please enter your username'
    //                 }
    //                 ]
    //             },
    //             password: {
    //                 identifier  : 'password',
    //                 rules: [
    //                 {
    //                     type   : 'empty',
    //                     prompt : 'Please enter your password'
    //                 }
    //                 ]
    //             }
    //         }
    //     })
    //     ;
    // })
    // ;
</script>
</head>
<body style="background-image:url('{{ asset('img/backgrounds/img.jpg') }}'); background-position: 0rem;">
    <div class="w-100 h-100">
        <div class="row mx-0 h-100 align-items-center">
    
          <div class="d-none d-lg-flex col-lg-7 col-sm-7 px-0">
            <div class="w-75 px-3 ml-auto mr-5 text-right">
                <h2 class="text-white">
                    ABSENSI SALES
                </h2>
              {{-- <img src="{{ asset('src/img/logo-edited.png') }}" class="heading-img" alt="Main Icon" height="150vh"> --}}
              <hr class="my-4">
              <h3 class="text-white">
                {{ env('APP_LONGNAME', 'Time Is Gold') }}
              </h3>
            </div>
    
            <div class="footer px-5 py-3 text-white text-right" style="width:57%">
              Copyright &copy; 2020 PRAGMA INFORMATIKA All rights reserved.
              {{-- <a href="#">Terms of Use</a> · <a href="#">Privacy policy</a> --}}
            </div>
          </div>
    
          <div class="col-sm-5 px-0 h-100 bg-white d-flex">
            @yield('content')
          </div>
        </div>
      </div>
    {{-- <div class="overlay"></div>
    @yield('content') --}}

    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('plugins/jQuery/jquery.form.min.js') }}"></script>
    <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('semantic/semantic.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function($) {
            $('.message .close')
              .on('click', function() {
                $(this)
                  .closest('.message')
                  .transition('fade')
                ;
              })
            ;
        });
    </script>
</body>
</html>
