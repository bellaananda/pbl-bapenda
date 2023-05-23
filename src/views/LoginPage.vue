<template>
    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="asset/images/logo-bapenda.svg" alt="logo">
              </div>
              <h3>Login</h3>
              <h6 class="font-weight-light">Masukkan email dan password untuk dapat login</h6>
              <form class="pt-3">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" v-model="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" v-model="password" placeholder="Password">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-primary btn-lg font-weight-bold auth-form-btn" @click="login">Login</a>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Ingat saya
                    </label>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</template>

<script>
export default {
  name: "LoginPage",
  data() {
    return {
      email: "",
      password: ""
    };
  },

  methods: {
    login() {
      if(this.email === "" && this.password === "") {
        this.$store.commit("setAuthenticated", true);
        this.$store.commit("setUserRole", "admin");
        this.$router.push("/dashboard");
      } else {
        alert("Email atau password salah");
      }
    }
  }
};
</script>