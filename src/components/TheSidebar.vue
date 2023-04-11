<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <router-link to="/" class="nav-link">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/agendas" class="nav-link">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Agenda</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/employees" class="nav-link">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Pegawai</span>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Kelola</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <router-link to="/positions" class="nav-link">Posisi Pegawai</router-link></li>
              </ul>
            </div>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <router-link to="/departments" class="nav-link">Department</router-link></li>
              </ul>
            </div>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <router-link to="/categories" class="nav-link">Kategori Agenda</router-link></li>
              </ul>
            </div>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <router-link to="/rooms" class="nav-link">Ruang</router-link></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <router-link to="/charts" class="nav-link">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Grafik</span>
            </router-link>
          </li>
        </ul>
      </nav>
</template>