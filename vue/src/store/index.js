import { createStore } from 'vuex'
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css';
import axios from 'axios';

export default createStore({
	state: {
		baseUrl:"http://localhost/bidsportal_new/laravel2/public/",
		// baseUrl:"http://139.59.39.99/",
		token:null,
		user:null,
		cart:[],
		alert:[],
		bidsdetails:[],
		naics:[],
		pscs:[],
		selected_naics:[],
		selected_pscs:[],
		page:'',
		filters:[],
		searchfilter:{},
		current_page:''
	}, 
	
	mutations: {
		setFilters(state, filters){
			state.filters = filters
		},
		setSearchFilter(state, searchfilter){
			state.searchfilter = searchfilter
		},
		setNaics(state, naics){
			state.naics = naics
		},
		setPscs(state, pscs){
			state.pscs = pscs
		},
		setSelectedNaics(state, selected_naics){
			state.selected_naics = selected_naics
		},
		setSelectedPscs(state, selected_pscs){
			state.selected_pscs = selected_pscs
		},
		setToken(state, token){
			state.token = token;
		},
		setUser(state, user){
			state.user = user;
		},
		setPage(state, page){
			state.page = page;
		},
		setCurrentPage(state, current_page){
			state.current_page = current_page;
		},
		setCartProducts(state, cart) {
			state.cart = cart;
		},
		setAlert(state, alert) {
			state.alert = alert;
		},
		setBidsDetails(state,bidsdetails){
			state.bidsdetails = bidsdetails
		},
		
		addTocart(state, product) {
            product.sub_total = product.price * product.quantity
            state.cart.push(product);
        },
		removeFromCart(state, product) {
			let index = state.cart.indexOf(product);
			state.cart.splice(index, 1);
			// localStorage.setItem("cartItems", JSON.stringify(state.cart));
		},

	},

	getters: {
		filters(state){
			return state.filters
		},
		searchfilter(state){
			return state.searchfilter
		},
		naics(state){
			return state.naics
		},
		pscs(state){
			return state.pscs
		},
		baseUrl(state){
			return state.baseUrl;
		},
		selected_naics(state){
			return state.selected_naics
		},
		selected_pscs(state){
			return state.selected_pscs
		},
		token(state){
			return state.token;
		},
		user(state){
			return state.user;
		},
		page(state){
			return state.page;
		},
		current_page(state){
			return state.current_page;
		},
		cartItems(state){
			return state.cart
		},
		alert(state){
			return state.alert
		},
		bidsdetails(state){
			return state.bidsdetails
		},
	},

	actions: {
		async setFilters(context,payload) {
			await context.commit('setFilters',payload);
		},
		async setSearchFilter(context,payload) {
			await context.commit('setSearchFilter',payload);
		},
		async setUser(context,payload) {
			await context.commit('setUser',payload);
		},
		async setNaics(context,payload) {
			await context.commit('setNaics',payload);
		},
		async setPscs(context,payload) {
			await context.commit('setPscs',payload);
		},
		async setPage(context,payload) {
			await context.commit('setPage',payload);
		},
		async setCurrentPage(context,payload) {
			await context.commit('setCurrentPage',payload);
		},
		async setSelectedNaics(context,payload) {
			await context.commit('setSelectedNaics',payload);
		},
		async setSelectedPscs(context,payload) {
			await context.commit('setSelectedPscs',payload);
		},
		async setAlert(context,payload) {
			await context.commit('setAlert',payload);
		},
		async setBidsDetails(context,payload) {
			await context.commit('setBidsDetails',payload);
		},
		
		async setToken(context,payload) {
			await context.commit('setToken',payload);
		},
		async setCartProducts(context,cart) { 
			await context.commit("setCartProducts",cart);
	   },
		
		auth(context,payload) {
			return new Promise((resolve, reject) => {
				axios.post(this.state.baseUrl+'api/'+payload.uri,payload.data,{
					headers: {
                        'Authorization': 'Bearer' + ' ' + context.getters.token
                    }
				})
				.then(function (response) {
					resolve(response);
				})
				.catch(function (error) {
					reject(error);
				});
			});
		},

		get(context,payload) {
			return new Promise((resolve, reject) => {
				axios.get(this.state.baseUrl+'api/'+payload.uri,payload.data, {
                    headers: {
                        'Authorization': 'Bearer' + ' ' + context.getters.token
                    }
                }).then(function (response) {
					resolve(response);
				})
				.catch(function (error) {
					reject(error);
				});
			});
		},
		delete(context,payload) {
			return new Promise((resolve, reject) => {
				axios.delete(this.state.baseUrl+'api/'+payload.uri,payload.data, {
                    headers: {
                        'Authorization': 'Bearer' + ' ' + context.getters.token
                    }
                }).then(function (response) {
					resolve(response);
				})
				.catch(function (error) {
					reject(error);
				});
			});
		},

		post(context,payload) {
			return new Promise((resolve, reject) => {
				axios.post(this.state.baseUrl+'api/'+payload.uri,payload.data, {
                    headers: {
                        'Authorization': 'Bearer' + ' ' + context.getters.token
                    },
					cancelToken: payload.cancel_token,
                }).then(function (response) {
					resolve(response);
				})
				.catch(function (error) {
					reject(error);
				});
			});
		},

		async error(context,description) {
			await createToast({
				title: 'Error',
				description: description || "The given data was invalid."
			},
			{
				showIcon: true,
				hideProgressBar: true,
				type: 'danger',
				position: 'top-right'
			})
		},

		async success(context,description) {
			await createToast({
				title: 'Success',
				description: description || "Data is successfuly subbmited."
			},
			{
				showIcon: true,
				hideProgressBar: true,
				type: 'success',
				position: 'top-right'
			})
		},
	}
})
