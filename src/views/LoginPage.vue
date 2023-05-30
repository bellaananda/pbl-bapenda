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
              <form class="pt-3" @submit.prevent="login">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" v-model="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" v-model="password" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary btn-block my-4">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</template>

<script> 
import axios from "axios";
import router from "../router";
export default {
  name: "LoginPage",
  data() {
    return {
      email: "",
      password: ""
    };
  },

  methods:{
    login() { 
        axios.post("https://api.klikagenda.com/api/login", {
          email: this.email,
          password: this.password,
        })
        .then(response => {
          const access_token = response.data.access_token;
          localStorage.setItem("access_token", access_token);
          router.push("/dashboard-user");
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
};
</script>