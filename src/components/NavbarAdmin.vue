<template>
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div
      class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center"
    >
      <a class="navbar-brand brand-logo mr-5" href="dashboard.html"
        ><img src="asset/images/logo-bapenda.svg" class="mr-2" alt="logo"
      /></a>
      <a class="navbar-brand brand-logo-mini" href="dashboard.html"
        ><img src="asset/images/logo-bapenda.svg" alt="logo"
      /></a>
    </div>
    <div 
      class="navbar-menu-wrapper d-flex align-items-center justify-content-end"
    >
      <button
        class="navbar-toggler navbar-toggler align-self-center"
        type="button"
        data-toggle="minimize"
      >
        <span class="icon-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            data-toggle="dropdown"
            id="profileDropdown"
          >
            <img src="asset/images/profilefix3.png" alt="profile" />
          </a>
          <span>{{ employeeData.name }}</span>
          <div
            class="dropdown-menu dropdown-menu-right navbar-dropdown"
            aria-labelledby="profileDropdown"
          >
            <a class="dropdown-item">
              <i class="ti-user text-primary"></i>
              Login sebagai {{ employeeData.role }}
            </a>
            <router-link class="dropdown-item" to="/profile-user">
              <i class="ti-user text-primary"></i>
              Profile
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
  name: "NavbarAdmin",
  computed: {
    employeeData() {
      return this.$store.state.employees;
    },

    userRole() {
      return this.$store.state.userRole; // Retrieve the user role from the Vuex store
    },
  },
  methods: {
    logout() {
      this.$store.dispatch("logout");
    },
  },
  created() {
    const employeesData = localStorage.getItem("employees");
    if (employeesData) {
      this.$store.commit("setEmployees", JSON.parse(employeesData));
    }

    const userRole = localStorage.getItem("userRole");
    if (userRole) {
      this.$store.commit("SET_USER_ROLE", userRole);
    }
  },
};
</script>
