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
        <div class="ui pointing dropdown item" tabindex="0">
            {{ auth()->user()->username }} <i class="dropdown icon"></i>
            <div class="menu transition hidden" tabindex="-1">
                <a class="item" href="{{ url('/profile') }}"><i class="user icon"></i> Profile</a>
                <a class="item" href="{{ url('/get-change') }}"><i class="lock icon"></i> Change Password</a>
                <a class="item" href="{{ url('/logout') }}"><i class="sign out icon"></i> Logout</a>
            </div>
        </div>
    </div>
</div>