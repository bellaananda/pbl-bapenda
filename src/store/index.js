import { createStore } from "vuex";
import axios from "axios";

export default createStore({
	state: {
        // isAuthenticated: false
		access_token: localStorage.getItem("access_token") || "",
    	employees: null,
	},
	mutations: {
        // setAuthenticated(state, value) {
        //     state.isAuthenticated = value;
        // }
		setToken(state, access_token) {
			state.access_token = access_token;
			localStorage.setItem("access_token", access_token);
		},
		setUser(state, employees) {
			state.employees = employees;
		},
		logout(state) {
			state.access_token = "";
			state.employees = null;
			localStorage.removeItem("access_token");
		},
	},
	actions: {
		login({ commit }, access_token) {
			commit("setToken", access_token);
		},
		logout({ commit }) {
			axios.post("https://api.klikagenda.com/api/logout")
        	.then(() => {
          		commit("logout");
				  this.$router.push({name: "landing-page"});
        	})
        	.catch(error => {
          		console.error("Error:", error);
        	});
		},
		setUser({ commit }, employees) {
			commit("setUser", employees);
		},

	},
    getters: {
		isLoggedIn: state => !!state.access_token,
    	currentUser: state => state.employees,
	},
});
