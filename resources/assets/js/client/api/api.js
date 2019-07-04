import Cookies from 'js-cookie'
import {store} from '../store'

window.Api = {

	async login (user) {
		return new Promise((resolve, reject) => {
			axios.post('/api/v1/user/login', user)
			.then((resp) => {
				Cookies.set('api_auth', resp.data.data.api_token)
				resolve(resp.data.data)
			}).catch((error) => {
				resolve(error.response)
			})
		})
	},

	async loadProfile () {
		const profile = await this.getProfile()
		if (profile) {
			profile.unreadMsg = await Api.getCountUnreadedMsg()
		}
		store.commit('setProfile', profile)
		if (window.isDevMode) {
			console.log('%cProfile: %O', 'color:gray;', profile)
		}
		return profile
	},

	async getProfile () {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/user/profile')
			.then((resp) => {
				const profile = resp.data.data
				resolve(profile)
			}).catch((error) => {
				Cookies.remove('api_auth')
				resolve(null)
			})
		})
	},

	async getCountUnreadedMsg() {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/dialogs/messages/countunreaded')
			.then((resp) => {
				const unread = resp.data.data
				resolve(unread)
			}).catch((error) => {
				resolve(error.response)
			})
		})
	},

	toQuery(obj) {
		let query = [];
		Object.keys(obj).map((k, v) => {
			if (obj[k]) {
				query.push(k + '=' + obj[k])
			}
		});
		if (query.length > 0) {
			return '?' + query.join('&');
		} else {
			return [];
		}
	},
	isEmptyObject(obj) {
		for (var item in obj) {
			return false;
		}
		return true;
	},

	async loadLocation(location) {
		var loc = '';
		if (location) loc = '?city=' + location;

		return new Promise((resolve, reject) => {
			axios.get('/api/v1/kladr/position' + loc)
			.then((resp) => {
				resolve(resp.data.data)
			}).catch((error) => {
				resolve(error)
			});
		});
	},

	async loadCountry(country) {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/kladr/country/' + country).then((resp) => {
				resolve(resp.data.data)
			}).catch((error) => {
				resolve(error)
			});
		});
	},

	async loadRegion(region) {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/kladr/region/' + region).then((resp) => {
				resolve(resp.data.data)
			}).catch((error) => {
				resolve(error)
			});
		});
	},

	async loadOrganizationInfo(id) {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/organization/' + id + '/info').then((resp) => {
				resolve(resp.data.data)
			}).catch((error) => {
				resolve(error)
			});
		});
	},
	async loadOrganizationReviews(id) {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/organization/' + id + '/ratings').then((resp) => {
				resolve(resp.data.data)
			}).catch((error) => {
				resolve(error)
			});
		});
	},

	async getCities(region_id) {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/kladr/cities/' + region_id).then((resp) => {
				resolve(resp.data.data);
			}).catch((error) => {
				reject(error)
			})
		})
	},

	async getRegions(country_id) {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/kladr/regions/' + country_id).then((resp) => {
				resolve(resp.data.data)
			})
		})
	},

	async getCountries() {
		return new Promise((resolve, reject) => {
			axios.get('/api/v1/kladr/countries').then((resp) => {
				resolve(resp.data.data)
			})
		})
	},

	cleanData(data) {
		Object.keys(data).forEach((key) => (data[key] == null) && delete data[key]);
		return data;
	},
};
