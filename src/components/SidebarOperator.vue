<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <router-link class="nav-link" to="/dashboard-operator">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Agenda</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> 
                  <router-link class="nav-link" to="/agendas-operator">Agenda</router-link>
                </li>
              </ul>
            </div>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> 
                  <router-link class="nav-link" to="/pengajuan-operator">Pengajuan Agenda</router-link>
                </li>
              </ul> 
            </div>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/employees-operator">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Pegawai</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/charts-operator">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Grafik</span>
            </router-link>
          </li>
        </ul>
      </nav>
</template>