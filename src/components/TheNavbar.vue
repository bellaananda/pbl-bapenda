<template>
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
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-bold float-left dropdown-header">Notifications</p>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <div>
                    <p class="text-info mb-1">Ajuan Agenda</p>
                    <p class="mb-0">Operator menyetujui ajuan agenda ...</p>
                    <small>9:30 am</small>
                  </div>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <div>
                    <p class="text-info mb-1">Ajuan Agenda</p>
                    <p class="mb-0">Operator menyetujui ajuan agenda ...</p>
                    <small>10:30 am</small>
                  </div>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <div>
                    <p class="text-info mb-1">Ajuan Agenda</p>
                    <p class="mb-0">Operator menyetujui ajuan agenda ...</p>
                    <small>10:30 am</small>
                  </div>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="asset/images/faces/face28.jpg" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-user text-primary"></i>
                Armidham Azhaf R.
              </a>
              <a class="dropdown-item" href="#">
                <i class="ti-user text-primary"></i>
                Internal Profile
              </a>
              <router-link to="landing-page" class="dropdown-item">
                <i class="ti-power-off text-primary"></i>
                Logout
              </router-link>
            </div>
          </li>
        </ul>
      </div>
    </nav>
</template>