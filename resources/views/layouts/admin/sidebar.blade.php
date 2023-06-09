<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav page-navigation">
        <li class="nav-item @if($page=='dashboard'){{'active'}}@endif">
            <a href="/" class="nav-link">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if($page=='agenda'){{'active'}}@endif">
            <a href="/agenda" class="nav-link">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Agenda</span>
            </a>
        </li>
        <li class="nav-item @if($page=='pegawai'){{'active'}}@endif">
            <a href="/pegawai" class="nav-link">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Pegawai</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-grid-2 menu-icon"></i>
                <span class="menu-title">Kelola</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @if($page=='posisi'){{'active'}}@endif"> 
                        <a href="/posisi" class="nav-link">Posisi Pegawai</a>
                    </li>
                </ul>
            </div> 
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @if($page=='bidang'){{'active'}}@endif">
                        <a href="/bidang" class="nav-link">Bidang</a>
                    </li>
                </ul>
            </div>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @if($page=='kategori'){{'active'}}@endif">
                        <a href="/kategori" class="nav-link">Kategori Agenda</a>
                    </li>
                </ul>
            </div>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item @if($page=='ruangan'){{'active'}}@endif">
                        <a href="/ruangan" class="nav-link">Ruangan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item @if($page=='grafik'){{'active'}}@endif">
            <a href="/grafik" class="nav-link">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Grafik</span>
            </a>
        </li>
    </ul>
</nav>