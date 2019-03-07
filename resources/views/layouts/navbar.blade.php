<nav class="navbar navbar-expand-md navbar-light navbar-laravel{{ isset($compact) ? ' d-none d-lg-block' : ''}}">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="/logo.png" alt="tag" height="16px"/>
            Grande<b>Annotation</b>.fr
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/home') }}">Thèmes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/my-overview') }}">Ma synthèse</a>
                </li>
            </ul>
            @auth
                <a href="/levels">
                    <span id="myScore" class="badge badge-pill badge-{{ Auth::user()->badgeColor() }}"
                          style="font-size: 14px;">
                        {{ Auth::user()->scores['total'] }} - {{ Auth::user()->badgeText() }}
                    </span>
                </a>
                @if (count(Auth::user()->unreadMessages) > 0)
                    &nbsp;
                    <a href="/messages">
                        <span class="badge badge-pill badge-danger" style="font-size: 14px;">
                            {{ count(Auth::user()->unreadMessages) . (count(Auth::user()->unreadMessages) > 1 ? ' nouveaux messages' : ' nouveau message') }}
                        </span>
                    </a>
                @endif
            @endauth
        <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/faq') }}">FAQ</a>
                </li>
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/account">
                                Mon compte
                            </a>
                            @if (count(Auth::user()->messages) > 0)
                                <a class="dropdown-item" href="/messages">
                                    Mes messages
                                    @if (count(Auth::user()->unreadMessages) > 0)
                                        <span class="badge badge-pill badge-danger">
                                            {{ count(Auth::user()->unreadMessages) }}
                                        </span>
                                    @endif
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Se déconnecter
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
