import { createStore } from "vuex";
import axios from "axios";

export default createStore({
	state: {
		access_token: localStorage.getItem("access_token") || "",
    	employees: {},
	},
	mutations: {
		setToken(state, access_token) {
			state.access_token = access_token;
			localStorage.setItem("access_token", access_token);
		},

		employeDetail(state, employees) {
			state.employees = employees;
		},
		logout(state) {
			state.access_token = "";
			state.currentUser = null;
			localStorage.removeItem("access_token");
		},
	},
	actions: {
		login({ commit }, {access_token}) {
			commit("setToken", access_token);
		},

		logout({ commit }) {
			axios.post("https://api.klikagenda.com/api/logout", null,{
				headers: {
					Authorization: "Bearer " + localStorage.getItem("access_token"),
				  },
			})
        	.then(() => {
          		commit("logout");
				localStorage.removeItem("access_token");
				this.$router.push("/login");
        	})
        	.catch(error => {
          		console.error("Error:", error);
        	});
		},
		
	},
    getters: {
		isLoggedIn: (state) => !!state.access_token,
    	currentUser: (state) => state.employees,
		employeDetail: state => state.employees
	},
});
