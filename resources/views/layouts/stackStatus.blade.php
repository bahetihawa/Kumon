<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/logo.jpg" style="
                            height: auto;
                            width: 100px;
                            margin: -8px;
                        ">
                    </a>
                    <a class="navbar-brand" href="{{ url('/') }}" style="border-right: 1px solid">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav ">
                        @if(Auth::check())
                            @if(Auth::user()->role == 1)
                                @include('include.topnav')
                            @elseif(Auth::user()->role == 2)
                                @include('include.topnavC')
                            @elseif(Auth::user()->role == 3)
                                @include('include.topnavW')
                            @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                          
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if(Auth::user()->role == 1)
                                    Super User :
                                @else
                                    Warehouse:
                                @endif    
                                   {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-danger" id="crumb">{{ config('app.breadcrumb')[Request::route()->getName()]}}</div>
@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-danger text-center') }}">{{ Session::get('message') }}</div>
@endif
        @yield('content')
        @include('include.footer')
    </div>

    <!-- Scripts -->
    <script>
    $("input").on("click",function(){
        var cent = $(this).val();
        if(cent == 2 ){ var d = "center";}else{ var d = "warehouse";}
        $("#assign").text(d);
        $(".registrationShow").removeClass("fade");
        $.post("/utility/registerCenter",{data:cent},function(r){
            $("#asigned").html(' <option value="0">-------Select-------</option>').append(r);
        });
    });
</script>
    <script src="/js/app.js"></script>
</body>
</html>
