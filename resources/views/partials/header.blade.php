<div class="ui fixed blue menu">
    <a href="{{ url('/dashboard') }}" class="header item" style="letter-spacing: 3px;">
        {{-- <img class="logo" src="{{ asset('img/icon-long.png')}}" style="width: 5em;">&nbsp;&nbsp; --}}
        {{ config('app.name', 'ABSENSI SALES') }}
    </a>
    <div class="menu">
        <a href="#" class="item" onclick="toggleSidebar()">
            <i class="sidebar icon"></i>
        </a>
    </div>
    
    <div class="right menu">
        {{-- @if (auth()->user()) --}}
            <div class="ui pointing dropdown item ">
                <div class="floating ui red small label" id="count-notif">0</div>
                <i class="ui bell icon" style="margin-right: 0;"></i>
                <div class="mfs menu"  {{--style="max-height: 25rem !important;margin-top: 0.14em;" --}}>
                    <div {{--style="padding: 0px !important;width:480px;"--}}>
                        <div class="ui center attached segment mfs " id="area-notif" {{--style="max-height: 25rem !important;overflow-y: scroll;overflow-x: hidden !important;"--}}>
                            <div {{--style="padding: 0px !important;width:400px;"--}} class="notif item">
                                <div data-href="#" style="text-align: center;">
                                    <div style="margin-bottom:-4px;background-color:#fafafa;box-shadow:0 0 0 1px #898b8c63 inset,0 0 0 0 transparent;" class="ui attached message">
                                        <div class="header">
                                        <u>No New Notifications</u>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('jobs/all-notif') }}">
                            <div class="ui bottom attached segment center aligned">
                                See All
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="ui pointing dropdown item" tabindex="0">
                <div class="ui horizontal list">
                  <div class="item">
                    <img class="ui avatar image" src="{!! auth()->user()->showfotopath() !!}">
                    <div class="content">
                      <div class="header">{!! auth()->user()->name !!}</div>
                    </div>
                  </div>
                </div>
                <i class="dropdown icon"></i>
                <div class="menu transition hidden" tabindex="-1">
                    <a class="item" href="{{ url('/konfigurasi/profile') }}"><i class="user icon"></i>Edit Profile</a>
                    <a class="item" href="{{ url('/logout') }}"><i class="sign out icon"></i> Logout</a>
                </div>
            </div>

        {{-- <div class="ui pointing dropdown item" tabindex="0">
            {{ auth()->user()->username }} <i class="dropdown icon"></i>
            <div class="menu transition hidden" tabindex="-1">
                <a class="item" href="{{ url('/konfigurasi/profile') }}"><i class="user icon"></i>Edit Profile</a>
                <a class="item" href="{{ url('/logout') }}"><i class="sign out icon"></i> Logout</a>
            </div>
        </div> --}}
    </div>
</div>