<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <router-link class="navbar-brand brand-logo mr-5" to="/"><img src="asset/images/logo-bapenda.svg" class="mr-2" alt="logo"/></router-link>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <a class="btn btn-primary btn-sm" href="#" data-toggle="dropdown" id="profileDropdown">Login</a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <router-link class="dropdown-item" to="/dashboard-admin">
            ADMIN
          </router-link>
          <router-link class="dropdown-item" to="/dashboard-operator">
            OPERATOR
          </router-link>
          <router-link to="/dashboard-user" class="dropdown-item">
            USER
          </router-link>
        </div>
      </div>
    </nav>
</template>