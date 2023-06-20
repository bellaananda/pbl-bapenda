<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @if($page=='dashboard'){{'active'}}@endif">
            <a class="nav-link" href="/">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if($page=='add_pengajuan'){{'active'}}@endif">
            <a class="nav-link" href="/ajuan-agenda">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Ajukan Agenda</span>
            </a>
        </li>
        <li class="nav-item @if($page=='pengajuan'){{'active'}}@endif">
            <a class="nav-link" href="/pengajuan">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Riwayat Pengajuan</span>
            </a>
        </li>
    </ul>
</nav>