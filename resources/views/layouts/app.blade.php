<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tournaman') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{url('trophy_3.webp')}}" width="34" height="34">
                {{ config('app.name', 'Tournaman') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ url('/events/add') }}"
                           class="nav-link">
                            {{ __('messages.Add Tournament') }}
                        </a>
                    </li>
                {{--                        <li class="nav-item">
                                            <a href="{{ url('/events/add') }}"
                                               class="nav-link text">
                                                City
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/events/add') }}"
                                               class="nav-link text">
                                                English
                                            </a>
                                        </li>--}}
                <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown px-lg-5">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                <li><a class="dropdown-item" href="{{ url("/profile") }}">Profile</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="bg-light p-5 rounded">
            @yield('content')
        </div>
    </main>
    <div class="container">
        <footer class="py-5">
            <div class="row">

                <div class="row">
                    <div class="col-md-2 col-md-offset-6 text-right">
                        <strong>{{ __('messages.slectLanguage') }}: </strong>
                    </div>
                    <div class="col-md-4">
                        <select id="changeLang"  onChange="changeLang('changeLang');" class="form-control changeLang">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ru" {{ session()->get('locale') == 'ru' ? 'selected' : '' }}>Russian</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between py-4 my-4 border-top">
                <p>&copy; <?php echo date("Y"); ?> Tournaman,  {{__('messages.All rights reserved')}}.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
                </ul>
            </div>
        </footer>
    </div>

</div>
</body>
<script type="text/javascript">


</script>.

<script type="text/javascript">

    var url = "{{ route('changeLang') }}";


    function changeLang(){
        var element = document.getElementById('changeLang');
        window.location.href = url + "?lang="+ element.value;


    }
</script>
</html>
