import { createStore } from "vuex";
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";
import axios from "axios";

export default createStore({
    state: {
        // apiUrl: "https://bidsportal.com/api/",
        // apiUrl: "http://64.227.157.66/",
        apiUrl: "http://192.168.0.174/bidsportal_new/laravel/public/",
        user: null,
        token: "",
        // permissions: [],
        authenticated: false,
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
        // async setPermissions(context, payload) {
        //     await context.commit("setPermissions", payload);
        // },

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

        async info(context,description) {
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
