<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="dashboard.html"><img src="asset/images/logo-bapenda.svg" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.html"><img src="asset/images/logo-bapenda.svg" alt="logo"/></a>
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
              <a class="dropdown-item preview-item" >
                <!-- <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>  -->
                <div class="preview-item-content">
                  <div>
                    <!-- <p class="text-info mb-1">Ajuan Agenda</p> -->
                    <p class="mb-0">{{ suggestions.notes_of_refusal }}</p>
                    <small>{{suggestions.updated_at}}</small>
                  </div>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="asset/images/profilefix3.png" alt="profile"/>
            </a>
            <span>user</span>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-user text-primary"></i>
                user
              </a>
              <router-link class="dropdown-item" to="/profile-user">
                <i class="ti-user text-primary"></i>
                Internal Profile
              </router-link>
              <button class="dropdown-item" @click.prevent="logout">
                <i class="ti-power-off text-primary"></i>
                Logout
              </button> 
            </div>
          </li>
        </ul>
      </div>
    </nav>
</template>
<script>

export default {
  name: "NavbarUser",
  data() {
    return {
      suggestions: [], // Menyimpan data notifikasi pengajuan agenda
    };
  },
  computed: {
    isLoggedIn : function(){ return this.$store.getters.isLoggedIn;},
    name : function(){ return this.$store.getters.employeDetail.name;},
  },
	methods: {
    logout() {
      this.$store.dispatch("logout");
    },

    async notification(){
      try {
        const response = await this.$axios.get("/notify"); // Ganti URL dengan endpoint API Anda
        this.suggestions = response.data;
      } catch (error) {
        console.log(error);
      }
    }
  },

};
</script>