import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		loading: false,
		snackbar: {
			color: 'undefined',
			text: '',
			toggle: false,
			timeout: 600,
		},
		city: {
			id: null,
			name: null,
		},
		profile: {
			active_payment_subscriptions: [],
			company: {},
			permissions: {},
			profile: {},
			unreadMsg: 0,
		},
		modalMsg: {
			toggle: false,
			content: '',
			btns: [],
			size: 'md',
		},
	},
	getters: {},
	mutations: {
		setLoading(state, loading)
		{
			state.loading = loading
		},

		setSnackbar(state, snackbar)
		{
			Object.assign(state.snackbar, snackbar)
		},

		setModalMsg(state, modal)
		{
			Object.assign(state.modalMsg, modal)
		},

		setCity(state, city)
		{
			Object.assign(state.city, city)
		},

		setProfile(state, profile)
		{
			if (profile) {
				Object.assign(state.profile, profile)
			} else {
				state.profile.active_payment_subscriptions = null
				state.profile.company = null
				state.profile.permissions = null
				state.profile.profile = null
				state.profile.unreadMsg = null
			}
		},
	},
	actions: {},
});