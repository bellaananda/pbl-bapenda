<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @if($page=='dashboard'){{'active'}}@endif">
            <a href="/" class="nav-link">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Agenda</span>
                <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @if($page=='agenda'){{'active'}}@endif"> 
                        <a class="nav-link" href="/agenda">Agenda</a>
                    </li>
                </ul>
            </div>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @if($page=='pengajuan'){{'active'}}@endif"> 
                        <a class="nav-link" href="/pengajuan">Pengajuan Agenda</a>
                    </li>
                </ul> 
            </div>
        </li>
        <li class="nav-item @if($page=='pegawai'){{'active'}}@endif">
            <a class="nav-link" href="/pegawai">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Pegawai</span>
            </a>
        </li>
        <li class="nav-item @if($page=='grafik'){{'active'}}@endif">
            <a class="nav-link" href="/grafik">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Grafik</span>
            </a>
        </li>
    </ul>
</nav>