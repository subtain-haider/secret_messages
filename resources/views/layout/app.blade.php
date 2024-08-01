<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <!-----bootstrap css link---->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" >
</head>
<body>
    <!------>


    <nav class="navbar navbar-expand-lg navbar-light white" >
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                {{ env('APP_NAME') }}
              </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }} ">Dashboard</a>
                    <a href="{{ route('messages.index') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'messages.index' ? 'active' : '' }}">Messages</a>


                </div>
                <div class="navbar-nav ms-auto ">
                    <div class="nav-item dropdown" style="margin-right: 38px;">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    @yield('script')
</body>
</html>
