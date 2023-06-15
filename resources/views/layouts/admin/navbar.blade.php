<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <router-link to="/" class="navbar-brand brand-logo mr-5"><img src="asset/images/logo-bapenda.svg" class="mr-2" alt="logo"/></router-link>
        <router-link to="/" class="navbar-brand brand-logo-mini"><img src="asset/images/logo-bapenda.svg" alt="logo"/></router-link>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                {{ Session::get('details')['name'] }}
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="asset/images/profile.png" alt="profil"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#">
                        <table>
                            <tr>
                                <td>
                                    <h6>{{ Session::get('details')['name'] }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="text-primary">
                                        {{ Str::title(Session::get('details')['role']) }}
                                    </h6>
                                </td>
                            </tr>
                        </table>
                    </a>
                    <a class="dropdown-item" href="/profil">
                        <i class="ti-user text-primary"></i>
                        Profil
                    </a>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>