import { createStore } from "vuex";
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";
import axios from "axios";

export default createStore({
	state: {
		apiUrl: "https://bidsportal.com/",
		// apiUrl: "http://64.227.157.66/",
		// apiUrl: "http://localhost/bidsportal_new/laravel/public/",
		user: null,
		token: "",
		selected_naics: [],
		selected_pscs: [],
		// permissions: [],
		authenticated: false,
		is_all_naics: false,
		is_all_pscs: false
	},
	mutations: {
		setUser(state, user) {
			state.user = user;
		},
		setToken(state, token) {
			state.token = token;
		},
		setUrl(state, url) {
			state.apiUrl = url;
		},
		setSelectedNaics(state, selected_naics) {
			state.selected_naics = selected_naics
		},
		setSelectedPscs(state, selected_pscs) {
			state.selected_pscs = selected_pscs
		},
		setAllNaics(state, is_all_naics) {
			state.is_all_naics = is_all_naics
		},
		setAllPscs(state, is_all_pscs) {
			state.is_all_pscs = is_all_pscs
		},
		// setPermissions(state, permissions) {
		//     state.permissions = permissions;
		// },
	},
	getters: {
		user(state) {
			return state.user;
		},
		token(state) {
			return state.token;
		},
		apiUrl(state) {
			return state.apiUrl;
		},
		selected_naics(state) {
			return state.selected_naics
		},
		selected_pscs(state) {
			return state.selected_pscs
		},
		is_all_naics(state) {
			return state.is_all_naics
		},
		is_all_pscs(state) {
			return state.is_all_pscs
		},
		// permissions(state) {
		//     return state.permissions;
		// },
	},

	actions: {
		async setUser(context, payload) {
			await context.commit("setUser", payload);
		},
		async setToken(context, payload) {
			await context.commit("setToken", payload);
		},
		async setSelectedNaics(context, payload) {
			await context.commit('setSelectedNaics', payload);
		},
		async setSelectedPscs(context, payload) {
			await context.commit('setSelectedPscs', payload);
		},
		// async setPermissions(context, payload) {
		//     await context.commit("setPermissions", payload);
		// },
		async setAllNaics(context, payload) {
			await context.commit('setAllNaics', payload);
		},
		async setAllPscs(context, payload) {
			await context.commit('setAllPscs', payload);
		},

		async logout(context) {
			await context.commit("setUser", null);
			await context.commit("setToken", "");
			// await context.commit("setPermissions", []);
		},
		auth(context, payload) {
			return new Promise((resolve, reject) => {
				axios
					.post(this.state.apiUrl + 'api/' + payload.uri, payload.data)
					.then(function (response) {
						resolve(response);
					})
					.catch(function (error) {
						reject(error);
					});
			});
		},

		get(context, payload) {
			return new Promise((resolve, reject) => {
				axios
					.get(this.state.apiUrl + payload.uri, payload.data, {
						headers: {
							Authorization: "Bearer" + " " + context.getters.token,
						},
					})
					.then(function (response) {
						resolve(response);
					})
					.catch(function (error) {
						reject(error);
					});
			});
		},

		post(context, payload) {
			return new Promise((resolve, reject) => {
				axios
					.post(this.state.apiUrl + 'api/' + payload.uri, payload.data, {
						headers: {
							Authorization: "Bearer" + " " + context.getters.token,
						},
					})
					.then(function (response) {
						resolve(response);
					})
					.catch(function (error) {
						// console.log("Error",error);
						reject(error);
						if (error.response.data.message == "Unauthenticated.") {
							context.dispatch("logout");
							window.location.href = "/#/";
							window.location.reload();
						}
					});
			});
		},

		multipart_formdata(context, payload) {
			return new Promise((resolve, reject) => {
				axios
					.post(this.state.apiUrl + 'api/' + payload.uri, payload.data, {
						headers: {
							Authorization: "Bearer" + " " + context.getters.token,
							"Content-Type": "multipart/form-data"
						},
					})
					.then(function (response) {
						resolve(response);
					})
					.catch(function (error) {
						// console.log("Error",error);
						reject(error);
						if (error.response.data.message == "Unauthenticated.") {
							context.dispatch("logout");
							window.location.href = "/#/";
							window.location.reload();
						}
					});
			});
		},

		async info(context, description) {
			await createToast({
				title: 'Info',
				description: description || "The given data was invalid."
			},
				{
					showIcon: true,
					hideProgressBar: true,
					type: 'info',
					position: 'top-right'
				})
		},

		async error(context, description) {
			await createToast(
				{
					title: "Error",
					description: description || "The given data was invalid.",
				},
				{
					showIcon: true,
					hideProgressBar: true,
					type: "danger",
					position: "top-right",
				}
			);
		},

		async success(context, description) {
			await createToast(
				{
					title: "Success",
					description: description || "Data is successfuly subbmited.",
				},
				{
					showIcon: true,
					hideProgressBar: true,
					type: "success",
					position: "top-right",
				}
			);
		},
	},
});
