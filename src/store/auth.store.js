// import $http from "../api";

// const state = () => ({

// });

// const mutations = () => ({
    
// });

// const actions = () => ({
//     login
// });

// export default {
//     namespaced: true,
//     state,
//     mutations,
//     actions
// };

// function login({ commit }, payload) {
//     return new Promise(async (resolve, reject) => {
//         try {
//             let network = await $http.post("auth/login", payload);
//             localStorage.setItem("access_token", network.data.token);
//             commit("_set_token", network.data.token, { root: true });
//             resolve(network);
//         } catch (e) {
//             reject(e);
//         }
//     });
// }