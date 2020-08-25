<nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-nav-gobierno">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                <li class="nav-item {{ active('rrhh.users.directory') }} ">
                    <a class="nav-link" href="{{ route('rrhh.users.directory') }}">
                        <i class="fas fa-address-book"></i> Telefonos
                    </a>
                </li>

                <li class="nav-item dropdown {{ active('indicators*') }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-chart-line"></i> Estadísticas
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item {{ active('indicators.index') }}"
                           href="{{ route('indicators.index') }}">
                            <i class="fas fa-desktop fa-fw"></i> Indicadores - REM
                        </a>

                        @auth
                            @canany(['LE Extra Plan: Carga','LE Extra Plan: Monitoreo'])
                                <a class="dropdown-item {{ active('le_extra_plans.index') }}"
                                   href="{{ route('le_extra_plans.index') }}">
                                    <i class="far fa-file-alt"></i> LE Plan Extraordinario
                                </a>
                            @endcan
                        @endauth
                    </div>
                </li>

                @canany(['Users: create', 'Users: edit','Users: delete',
                    'OrganizationalUnits: create',
                    'OrganizationalUnits: edit',
                    'OrganizationalUnits: delete',
                    'Authorities: manager',
                    'Authorities: view'])
                <li class="nav-item dropdown @active(['rrhh.users.*','rrhh.organizationalUnits.*']">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-users"></i> RRHH
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @canany(['Users: create', 'Users: edit','Users: delete'])
                        <a class="dropdown-item @active('rrhh.users.index')"
                            href="{{ route('rrhh.users.index') }}">
                            <i class="fas fa-user fa-fw"></i> Usuarios
                        </a>
                        @endcan

                        @canany(['OrganizationalUnits: create', 'OrganizationalUnits: edit', 'OrganizationalUnits: delete'])
                        <a class="dropdown-item @active('rrhh.organizationalUnits.*')"
                            href="{{ route('rrhh.organizationalUnits.index') }}">
                            <i class="fas fa-sitemap fa-fw"></i> Unidades organizacionales
                        </a>
                        @endcan

                        @canany(['Authorities: manager', 'Authorities: view'])
                        <a class="dropdown-item @active('rrhh.authorities.*')"
                            href="{{ route('rrhh.authorities.index') }}">
                            <i class="fas fa-chess-king fa-fw"></i> Autoridades
                        </a>
                        @endcan
                    </div>

                </li>
                @endcan

                @role('Drugs: admin|Drugs: receptionist|Drugs: basic')
                <li class="nav-item {{ active('drugs*') }}">
                    <a class="nav-link" href="{{ route('drugs.receptions.index') }}">
                        <i class="fas fa-cannabis"></i> Drogas</a>
                </li>
                @endrole

                @canany(['Pharmacy: SSI (id:1)', 'Pharmacy: REYNO (id:2)', 'Pharmacy: APS (id:3)'])
                    <li class="nav-item {{ active('pharmacies.*') }}">
                        <a class="nav-link" href="{{ route('pharmacies.index') }}">
                            @canany(['Pharmacy: SSI (id:1)', 'Pharmacy: REYNO (id:2)']) <i class="fas fa-prescription-bottle-alt"></i> Droguería @endcan
                            @can('Pharmacy: APS (id:3)') <i class="fas fa-list-ul"></i> Bodega APS @endcan
                        </a>
                    </li>
                @endcan

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
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
