import { createStore } from 'vuex'
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css';
import axios from 'axios';

export default createStore({
	state: {
		// baseUrl: 'http://192.168.0.213/bidsportal.com/laravel/public/',
		// appUrl: 'http://192.168.0.213:8080/#/',
		// baseUrl: 'http://192.168.0.174/bidsportal_new/laravel/public/',
		// appUrl: 'http://192.168.0.174/#/',
		baseUrl: "http://64.227.157.66/",
		appUrl: 'http://64.227.157.66/#/',
		token: null,
		user: null,
		cart: [],
		alert: [],
		bidsdetails: [],
		federal_tender: null,
		state_tender: null,
		private_tender: null,
		international_tender: null,
		naics: null,
		naics_time: null,
		pscs: null,
		pscs_time: null,
		selected_naics: [],
		selected_pscs: [],
		page: '',
		filters: [],
		searchfilter: {},
		current_page: '',
		federal_notices: [],
		states: [],
		federal_agencies: [],
		state_notices: [],
		private_notices: [],
		international_notices: [],
		categories: [],
		state_agencies: [],
		private_agencies: [],
		set_asides: [],
		international_agencies: [],
		page_redirect: null,
		user_plan: {},
		tender_cart: {
			items: 0,
			total: 0
		},
		state_tender: {
			title: null,
			tender_no: null,
		},

		header_menu: {
			show_pricing: null,
			show_upgrade: null,
			show_bidsearch: null
		},
		is_all_naics: false,
		is_all_pscs: false
	},

	mutations: {
		setSetAsides(state, set_asides) {
			state.set_asides = set_asides
		},
		setAllNaics(state, is_all_naics) {
			state.is_all_naics = is_all_naics
		},
		setAllPscs(state, is_all_pscs) {
			state.is_all_pscs = is_all_pscs
		},
		setHeaderMenu(state, header_menu) {
			state.header_menu = header_menu
		},
		setTenderCart(state, tender_cart) {
			state.tender_cart = tender_cart
		},
		setUserPlan(state, user_plan) {
			state.user_plan = user_plan
		},
		setPageRedirect(state, page_redirect) {
			state.page_redirect = page_redirect
		},
		setFederalTender(state, federal_tender) {
			state.federal_tender = federal_tender
		},

		setStateTender(state, state_tender) {
			state.state_tender = state_tender
		},
		setPrivateTender(state, private_tender) {
			state.private_tender = private_tender
		},
		setInternationalTender(state, international_tender) {
			state.international_tender = international_tender
		},

		setFederalNotices(state, federal_notices) {
			state.federal_notices = federal_notices
		},

		setStates(state, states) {
			state.states = states
		},

		setFederalAgencies(state, federal_agencies) {
			state.federal_agencies = federal_agencies
		},

		setStateNotices(state, state_notices) {
			state.state_notices = state_notices
		},

		setPrivateNotices(state, private_notices) {
			state.private_notices = private_notices
		},

		setInternationalNotices(state, international_notices) {
			state.international_notices = international_notices
		},

		setCategories(state, categories) {
			state.categories = categories
		},

		setStateAgencies(state, state_agencies) {
			state.state_agencies = state_agencies
		},
		setPrivateAgencies(state, private_agencies) {
			state.private_agencies = private_agencies
		},
		setInternationalAgencies(state, international_agencies) {
			state.international_agencies = international_agencies
		},
		setFilters(state, filters) {
			state.filters = filters
		},
		setSearchFilter(state, searchfilter) {
			state.searchfilter = searchfilter
		},
		setNaics(state, naics) {
			state.naics = naics
		},
		setPscs(state, pscs) {
			state.pscs = pscs
		},
		setPscsTime(state, pscs_time) {
			state.pscs_time = pscs_time
		},
		setSelectedNaics(state, selected_naics) {
			state.selected_naics = selected_naics
		},
		setSelectedPscs(state, selected_pscs) {
			state.selected_pscs = selected_pscs
		},
		setToken(state, token) {
			state.token = token;
		},
		setUser(state, user) {
			state.user = user;
		},
		setPage(state, page) {
			state.page = page;
		},
		setCurrentPage(state, current_page) {
			state.current_page = current_page;
		},
		setCartProducts(state, cart) {
			state.cart = cart;
		},
		setAlert(state, alert) {
			state.alert = alert;
		},
		setBidsDetails(state, bidsdetails) {
			state.bidsdetails = bidsdetails
		}
	},

	getters: {
		set_asides(state) {
			return state.set_asides
		},
		is_all_naics(state) {
			return state.is_all_naics
		},
		is_all_pscs(state) {
			return state.is_all_pscs
		},
		header_menu(state) {
			return state.header_menu
		},
		tender_cart(state) {
			return state.tender_cart
		},
		user_plan(state) {
			return state.user_plan
		},
		page_redirect(state) {
			return state.page_redirect
		},
		federal_tender(state) {
			return state.federal_tender
		},

		state_tender(state) {
			return state.state_tender
		},
		private_tender(state) {
			return state.private_tender
		},
		international_tender(state) {
			return state.international_tender
		},
		federal_notices(state) {
			return state.federal_notices
		},
		states(state) {
			return state.states
		},
		federal_agencies(state) {
			return state.federal_agencies
		},
		state_notices(state) {
			return state.state_notices
		},
		private_notices(state) {
			return state.private_notices
		},
		international_notices(state) {
			return state.international_notices
		},
		categories(state) {
			return state.categories
		},

		state_agencies(state) {
			return state.state_agencies
		},
		private_agencies(state) {
			return state.private_agencies
		},
		international_agencies(state) {
			return state.international_agencies
		},
		filters(state) {
			return state.filters
		},
		searchfilter(state) {
			return state.searchfilter
		},
		naics(state) {
			return state.naics
		},
		pscs(state) {
			return state.pscs
		},
		pscs_time(state) {
			return state.pscs_time
		},
		appUrl(state) {
			return state.appUrl;
		},
		baseUrl(state) {
			return state.baseUrl;
		},
		selected_naics(state) {
			return state.selected_naics
		},
		selected_pscs(state) {
			return state.selected_pscs
		},
		token(state) {
			return state.token;
		},
		user(state) {
			return state.user;
		},
		page(state) {
			return state.page;
		},
		current_page(state) {
			return state.current_page;
		},
		cartItems(state) {
			return state.cart
		},
		alert(state) {
			return state.alert
		},
		bidsdetails(state) {
			return state.bidsdetails
		},
	},

	actions: {
		async setSetAsides(context, payload) {
			await context.commit('setSetAsides', payload);
		},
		async setAllNaics(context, payload) {
			await context.commit('setAllNaics', payload);
		},
		async setAllPscs(context, payload) {
			await context.commit('setAllPscs', payload);
		},
		async setHeaderMenu(context, payload) {
			await context.commit('setHeaderMenu', payload);
		},
		async setStateTender(context, payload) {
			await context.commit('setStateTender', payload);
		},
		async setPrivateTender(context, payload) {
			await context.commit('setPrivateTender', payload);
		},
		async setInternationalTender(context, payload) {
			await context.commit('setInternationalTender', payload);
		},
		async setTenderCart(context, payload) {
			await context.commit('setTenderCart', payload);
		},
		async setUserPlan(context, payload) {
			await context.commit('setUserPlan', payload);
		},
		async setPageRedirect(context, payload) {
			await context.commit('setPageRedirect', payload);
		},

		async setFederalTender(context, payload) {
			await context.commit('setFederalTender', payload);
		},

		async setStateTender(context, payload) {
			await context.commit('setStateTender', payload);
		},

		async setFederalNotices(context, payload) {
			await context.commit('setFederalNotices', payload);
		},

		async setStates(context, payload) {
			await context.commit('setStates', payload);
		},

		async setFederalAgencies(context, payload) {
			await context.commit('setFederalAgencies', payload);
		},

		async setStateNotices(context, payload) {
			await context.commit('setStateNotices', payload);
		},
		async setPrivateNotices(context, payload) {
			await context.commit('setPrivateNotices', payload);
		},
		async setInternationalNotices(context, payload) {
			await context.commit('setInternationalNotices', payload);
		},

		async setCategories(context, payload) {
			await context.commit('setCategories', payload);
		},

		async setStateAgencies(context, payload) {
			await context.commit('setStateAgencies', payload);
		},
		async setPrivateAgencies(context, payload) {
			await context.commit('setPrivateAgencies', payload);
		},
		async setInternationalAgencies(context, payload) {
			await context.commit('setInternationalAgencies', payload);
		},


		async setFilters(context, payload) {
			await context.commit('setFilters', payload);
		},
		async setSearchFilter(context, payload) {
			await context.commit('setSearchFilter', payload);
		},
		async setUser(context, payload) {
			await context.commit('setUser', payload);
		},
		async setNaics(context, payload) {
			await context.commit('setNaics', payload);
		},
		async setPscs(context, payload) {
			await context.commit('setPscs', payload);
		},
		async setPscsTime(context, payload) {
			await context.commit('setPscsTime', payload);
		},
		async setPage(context, payload) {
			await context.commit('setPage', payload);
		},
		async setCurrentPage(context, payload) {
			await context.commit('setCurrentPage', payload);
		},
		async setSelectedNaics(context, payload) {
			await context.commit('setSelectedNaics', payload);
		},
		async setSelectedPscs(context, payload) {
			await context.commit('setSelectedPscs', payload);
		},
		async setAlert(context, payload) {
			await context.commit('setAlert', payload);
		},
		async setBidsDetails(context, payload) {
			await context.commit('setBidsDetails', payload);
		},

		async setToken(context, payload) {
			await context.commit('setToken', payload);
		},
		async setCartProducts(context, cart) {
			await context.commit("setCartProducts", cart);
		},

		auth(context, payload) {
			return new Promise((resolve, reject) => {
				axios.post(this.state.baseUrl + 'api/' + payload.uri, payload.data, {
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

		get(context, payload) {
			return new Promise((resolve, reject) => {
				axios.get(this.state.baseUrl + 'api/' + payload.uri, payload.data, {
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
		delete(context, payload) {
			return new Promise((resolve, reject) => {
				axios.delete(this.state.baseUrl + 'api/' + payload.uri, payload.data, {
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

		post(context, payload) {
			return new Promise((resolve, reject) => {
				axios.post(this.state.baseUrl + 'api/' + payload.uri, payload.data, {
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

		async success(context, description) {
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
