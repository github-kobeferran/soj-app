<nav id="system-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{url('storage/images/system/logo/logo.png')}}" style="width: 200px !important; height: auto !important;" alt="" class="img-fluid">
    </a>
  

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
   

    <div class="collapse navbar-collapse justify-content-around" id="navbarsExample08">
       
        <ul class="navbar-nav ">

            <li class="nav-item ">    
                <a class="nav-link" href="{{ route('register') }}">{{ __('Home,') }}</a>
            </li>
            <li class="nav-item">    
                <a class="nav-link" href="{{ route('dishes.clientview') }}">{{ __('Restaurant,') }}</a>
            </li>
            <li class="nav-item mr-4">    
                <a class="nav-link" href="{{ route('roomtypes.clientview') }}">{{ __('Hotel.') }}</a>
            </li>

            

            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link ml-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">    
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" style="font-family: 'Open Sans', sans-serif !important;"  aria-labelledby="navbarDropdown">

                        @if (auth()->user()->isAdmin())

                            <a class="dropdown-item" href="/admin">
                                Admin Dashboard
                            </a>
                            <a class="dropdown-item" href="/clients">
                                Clients
                            </a>
                            <a class="dropdown-item" href="/dishes">
                                Dishes
                            </a>
                            <a class="dropdown-item" href="/rooms">
                                Rooms
                            </a>
                            
                        @else

                            <a class="dropdown-item" href="/profile">
                                My Profile
                            </a>
                            
                        @endif

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest                        

        </ul>

        
    </div>
</nav>

