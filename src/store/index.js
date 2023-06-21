import { createStore } from "vuex";
import axios from "axios";

export default createStore({
  state: {
    access_token: null,
    employees: null,
    isLoggedIn: false,
    userRole: null,
  },
  mutations: {
    setUser(state, employees) {
      state.employees = employees;
    },

    setToken(state, access_token) {
      state.access_token = access_token;
    },

    setLoggedIn(state, isLoggedIn) {
      state.isLoggedIn = isLoggedIn;
    },
    SET_USER_ROLE(state, role) {
      state.userRole = role;
    },
    setEmployees(state, data) {
      state.employees = data;
    },
  },
  actions: {
    login({ commit }, { employees, access_token }) {
      commit("setUser", employees);
      commit("setToken", access_token);
      commit("setLoggedIn", true);
    },

    saveEmployees({ commit }, data) {
      commit("setEmployees", data);
    },

    logout({ commit }) {
      axios
        .post("https://api.klikagenda.com/api/logout", null, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          commit("logout");
          localStorage.removeItem("access_token");
          this.$router.push("/login");
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },

  getters: {
    getUserRole(state) {
      return state.userRole;
    },
  },
});
