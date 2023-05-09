<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <router-link class="nav-link" to="/dashboard-user">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/suggestions-user">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Ajukan Agenda</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/history-user">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">History</span>
            </router-link>
          </li>
        </ul>
      </nav> 
</template>