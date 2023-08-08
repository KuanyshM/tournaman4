<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Real reaction') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top shadow  bg-white">
        <div class="container-fluid">
            <a class="navbar-brand text-black text-uppercase" href="{{ url('/') }}">
               {{ config('app.name', 'Real reaction') }}
            </a>



            <button class="navbar-toggler  bg-opacity-10 bg-black" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
{{--                    <li class="nav-item">
                        <a href="{{ url('/teams') }}"
                           class="nav-link text-black">
                            Teams
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/rankings') }}"
                           class="nav-link text-black">
                            Rankings
                        </a>
                    </li>
                    --}}
                    <li class="nav-item">
                        <a href="{{ url('/events/addVideo') }}"
                           class="nav-link text-black">
                            {{ __('messages.Add Tournament') }}
                        </a>
                    </li>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link text-black" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
                            </li>
                        @endif

                    @else
                        <li class="nav-item dropdown px-lg-5">
                            <a class="nav-link text-black dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                <li><a class="dropdown-item" href="{{ url("/profile") }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ url("/events/myVideos") }}">My Videos</a></li>
{{--
                                <li><a class="dropdown-item" href="{{ url("/events/my") }}">My Tournaments</a></li>
--}}
                            @can('settings-list')
                                    <li><a class="dropdown-item" href="{{ url("/settings") }}">Settings</a></li>
                                @endcan
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
        <div class="bg-light rounded">
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
                <p>&copy; <?php echo date("Y"); ?> Real reaction,  {{__('messages.All rights reserved')}}.</p>
                <p><a href="{{url("events/presentation/")}}">Demo</a></p>
                <p><a href="https://docs.google.com/presentation/d/1JXS8zp2p42WluhsHSInUBwyz9R4migd-z5E0IY0DZZc/edit?usp=sharing">Presentation</a></p>
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

    var url = "{{ route('changeLang') }}";


    function changeLang(){
        var element = document.getElementById('changeLang');
        window.location.href = url + "?lang="+ element.value;


    }
</script>
</html>
