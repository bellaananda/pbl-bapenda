<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/"><img src="asset/images/logo-bapenda.svg" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="/"><img src="asset/images/logo-bapenda.svg" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-bold float-left dropdown-header">Notifikasi Ajuan Agenda</p>
                    @foreach ($notify as $notification)
                        <a class="dropdown-item preview-item" onclick="event.preventDefault(); document.getElementById('notifyForm-{{ $notification['id'] }}').submit();">
                            <div class="preview-thumbnail">
                                <div class="preview-icon {{ $notification['status'] == 1 || $notification['status'] == 3 ? 'bg-success' : 'bg-danger' }}">
                                    <i class="{{ $notification['status'] == 1 || $notification['status'] == 3 ? 'ti-check' : 'ti-close' }} mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <div>
                                    <p class="text-info mb-1 word-wrap-width">{{ $notification['title'] }}</p>
                                    @if ($notification['status'] == 1 || $notification['status'] == 3)
                                        <p class="mb-0">Ajuan agenda diterima</p>
                                    @elseif ($notification['status'] == 2)
                                        <p class="mb-0">Ajuan agenda ditolak</p>
                                    @endif
                                    <small>{{ $notification['hour'] }}</small><br>
                                    <small>{{ date('d-m-Y', strtotime($notification['date'])) }}</small>
                                </div>
                            </div>
                        </a>

                        <form id="notifyForm-{{ $notification['id'] }}" method="POST" action="/notify" style="display: none;">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $notification['id'] }}">
                        </form>
                    @endforeach
                </div>
            </li>
            <li class="nav-item nav-profile dropdown mr-2">
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
            <li class="nav-item dropdown ml-0">
                {{ Session::get('details')['name'] }}
            </li>
        </ul>
    </div>
</nav>