import { createStore } from 'vuex'
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css';
import axios from 'axios';

export default createStore({
	state: {
		baseUrl:"http://localhost/bidsportal_new/laravel/public/",
		// baseUrl:"http://139.59.39.99/",
		appUrl:'http://localhost:8080/#/',
		token:null,
		user:null,
		cart:[],
		alert:[],
		bidsdetails:[],
		federal_tender:null,
		state_tender:null,
		naics:null,
		pscs:null,
		selected_naics:[],
		selected_pscs:[],
		page:'',
		filters:[],
		searchfilter:{},
		current_page:'',
		federal_notices:[],
		states:[],
		federal_agencies:[],
		state_notices:[],
		categories:[],
		state_agencies:[],
		page_redirect:null
	}, 
	
	mutations: {
		setPageRedirect(state, page_redirect){
			state.page_redirect = page_redirect
		},
		setFederalTender(state, federal_tender){
			state.federal_tender = federal_tender
		},

		setStateTender(state, state_tender){
			state.state_tender = state_tender
		},

		setFederalNotices(state, federal_notices){
			state.federal_notices = federal_notices
		},

		setStates(state, states){
			state.states = states
		},

		setFederalAgencies(state, federal_agencies){
			state.federal_agencies = federal_agencies
		},

		setStateNotices(state, state_notices){
			state.state_notices = state_notices
		},

		setCategories(state, categories){
			state.categories = categories
		},

		setStateAgencies(state, state_agencies){
			state.state_agencies = state_agencies
		},

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
		page_redirect(state){
			return state.page_redirect
		},
		federal_tender(state){
			return state.federal_tender
		},

		state_tender(state){
			return state.state_tender
		},

		federal_notices(state){
			return state.federal_notices
		},
		states(state){
			return state.states
		},
		federal_agencies(state){
			return state.federal_agencies
		},
		state_notices(state){
			return state.state_notices
		},

		categories(state){
			return state.categories
		},

		state_agencies(state){
			return state.federal_agencies
		},

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
		appUrl(state){
			return state.appUrl;
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
		
		async setPageRedirect(context,payload) {
			await context.commit('setPageRedirect', payload);
		},

		async setFederalTender(context,payload) {
			await context.commit('setFederalTender', payload);
		},

		async setStateTender(context,payload) {
			await context.commit('setStateTender', payload);
		},

		async setFederalNotices(context,payload) {
			await context.commit('setFederalNotices', payload);
		},

		async setStates(context,payload) {
			await context.commit('setStates', payload);
		},

		async setFederalAgencies(context,payload) {
			await context.commit('setFederalAgencies', payload);
		},

		async setStateNotices(context,payload) {
			await context.commit('setStateNotices', payload);
		},

		async setCategories(context,payload) {
			await context.commit('setCategories', payload);
		}, 

		async setStateAgencies(context,payload) {
			await context.commit('setStateAgencies', payload);
		},


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
