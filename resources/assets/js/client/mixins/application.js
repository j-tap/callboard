import Cookies from 'js-cookie'
import Echo from 'laravel-echo'

var mixins = {
	data () {
		return {
			profile: null,
			errorCode: null,
			notification: null,
			isAuth: false,
		};
	},

	created () {
		const CancelToken = axios.CancelToken;
		axios.interceptors.request.use((request) => {
			this.errorCode = false;
			if (Cookies.get('api_auth')) {
				request.headers = {
					Authorization: 'Bearer ' + Cookies.get('api_auth'),
				}
			}
			return request
		});

		axios.interceptors.response.use((config) => {
			return config
		}, 
		(error) => {
			this.printErrorOnConsole(error)

			if (!error.response) {
				console.log("%cError: internet connection", "color:red;")
				this.errorCode = true
				return Promise.reject(null)
			}
			if (error.response.status == 429) {
				console.log("%cError: Too many requests", "color:red;")
				this.errorCode = error.response.status
				return Promise.reject(null)
			}
			return Promise.reject(error)
		});

		this.load()
	},

	methods: {

		async load () {
			// const loc = await Api.loadLocation()
			// this.$store.commit('setCity', { id: loc.city })
			await this.login()
			this.initLaravelEcho()
			this.$mount('#app')
		},

		initLaravelEcho () {
			if (window.isDevMode) {
				console.log('%cInit ECHO', 'color:green;')
			}

			if (this.isAuth) {
				
				window.Echo = new Echo({
					broadcaster: 'socket.io',
					host: window.location.hostname + ':6001',
					auth: {
						headers: {
							Authorization: 'Bearer ' + Cookies.get('api_auth'),
						},
					},
				})
				// window.Echo.private('dialog.1').listen('ChatMessage', (e) => {
				//     this.notification = true;
				// });
				// TODO: Message
				// window.Echo.private('dialog.organization.' + this.profile.company.id).listen('DialogMessage', (e) => {
				//     this.notification = true;
				// })
				
				if (this.isAuth) {
					setInterval(() => {
						this.checkNewMsg()
					}, 1000 * 20)
				}
			}

			window.EchoPublic = new Echo({
				broadcaster: 'socket.io',
				host: window.location.hostname + ':6001',
			})
		},

		async login () {
			const profile = await Api.loadProfile()
			this.isAuth = (profile)
			this.profile = profile
		},
		logout () {
			Cookies.remove('api_auth')
			this.profile = null
			this.isAuth = false
			this.$store.commit('setProfile', null)
		},

		async checkNewMsg ()
		{
			if (this.isAuth) {
				const unreadMsg = await Api.getCountUnreadedMsg()
				this.$store.commit('setProfile', { unreadMsg })
				/*
				this.$root.sendBrowserNotifications('У вас есть новое сообщение', {
					body: e[0].user.name +': '+ e[0].message,
				})
				*/
			}
		},

		sendBrowserNotifications (title, options) {
			console.log('sendBrowserNotifications', title, options)
			if (!('Notification' in window)) {
				this.printErrorOnConsole('HTML Notifications not supported', 'warning')
				return
			} 
			else if (Notification.permission === 'granted') {
				_send()
			} else if (Notification.permission !== 'denied') {
				Notification.requestPermission(function (permission) {
					if (permission === 'granted') {
						_send()
					} else {
						this.printErrorOnConsole('Notification is not allowed', 'warning')
					}
				})
			} else {
				this.printErrorOnConsole('Нou didn`t allow notifications', 'warning')
			}

			function _send () {
				console.log('sendBrowserNotifications _send')
				const notification = new Notification(title, {
					body: options.body || '',
					tag: options.tag || '',
					icon: options.icon || '/images/emails/logo.png',
					dir: 'auto',
					lang: 'ru',
				})
				notification.onclick = function () { // Events: onclick, onshow, onerror, onclose
					// console.log('is event')
				}
			}
		}
	},
}

export default mixins;
