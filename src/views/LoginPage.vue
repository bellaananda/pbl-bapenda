<template>
  <div class="content-wrapper d-flex align-items-center auth px-0">
    <div class="row w-100 mx-0">
      <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
          <div class="brand-logo">
            <img src="asset/images/logo-bapenda.svg" alt="logo" />
          </div>
          <h3>Login</h3>
          <h6 class="font-weight-light">
            Masukkan email dan password untuk dapat login
          </h6>
          <form class="pt-3" @submit.prevent="submitLogin">
            <div class="form-group">
              <input
                type="email"
                class="form-control form-control-lg"
                id="email"
                v-model="form.email"
                placeholder="Email"
                required
              />
            </div>
            <div class="form-group">
              <input
                type="password"
                class="form-control form-control-lg"
                id="password"
                v-model="form.password"
                placeholder="Password"
                required
              />
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-primary btn-block my-4">
                Login
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    async submitLogin() {
      try {
        const response = await this.$axios.post("/login", this.form);
        if (response.data.success) {
          const access_token = response.data.access_token;
          localStorage.setItem("access_token", access_token);

          const employeesId = response.data.id;
          const userResponse = await this.$axios.get(
            `/employees/${employeesId}`
          );
          const userRole = userResponse.data.data[0].role;
          this.$store.commit("SET_USER_ROLE", userRole);
          this.$store.dispatch("saveEmployees", userResponse.data.data[0]);
          localStorage.setItem(
            "employees",
            JSON.stringify(userResponse.data.data[0])
          );

          this.form.user_id = employeesId;
          this.form.person_in_charge = employeesId;

          if (userRole === "admin") {
            this.$router.push("/dashboard-admin");
          } else if (userRole === "user") {
            this.$router.push("/dashboard-user");
          } else if (userRole === "operator") {
            this.$router.push("/dashboard-operator");
          } else {
            console.log("Invalid role", userRole);
          }
        } else {
          console.log("Invalid user");
        }
      } catch (error) {
        console.log(error);
      }
    },
  },

  created() {
    // ...
    this.submitLogin();
  },
};
</script>
