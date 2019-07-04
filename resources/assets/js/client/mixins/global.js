import moment from 'moment'

var mixin = {
	computed: {
		isMobile () 
		{
			return (window.innerWidth < 768)
		},
		isTablet () 
		{
			return (window.innerWidth < 992)
		},
	},
    methods: {
        getProfile () 
		{
            return this.$store.state.profile
        },

        getCity () 
		{
            return this.$root.currentCity
        },

		dateFormat (d, s = 'D MMMM YYYY') 
		{
			const date = moment(d)
			if (date.isValid())
				return date.locale('ru').format(s)
			return false
		},
		dateTimeformat (d) 
		{
			const date = moment(d)
			if (date.isValid())
				return date.locale('ru').calendar(null, {
				sameElse: 'D MMMM YYYY'
			})
			return false
		},
		priceFormat (price)
		{
			const p = parseInt(price, 10)
			if (p === 0) {
				return p
			} else {
				if (p !== null && p !== false) {
					return p.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ')
				}
			}
		},
		phoneFormat (p)
		{
			if (p) return p.toString().replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, '+7 ($1) $2-$3-$4')
		},

		onlyNumber (e, isFloat) 
		{
			const evt = (e) ? e : window.event
			const charCode = (evt.which) ? evt.which : evt.keyCode
			let dot = true
			
			if (isFloat) dot = (charCode !== 46)
			if ((
				(charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105))
			) && dot) {
				evt.target.addEventListener('change', (evtChange) => {
					setTimeout(() => {
						const newVal = evtChange.target.value.replace(/[^\d]/, '')
						evtChange.target.value = newVal
					}, 15)
				}, {once: true})
				evt.returnValue = false
				evt.preventDefault()
				evt.stopPropagation()
				return false
			} else {
				return true
			}
		},

		getCookie (name) 
		{
			var matches = document.cookie.match(new RegExp(
				"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
			));
			return matches ? decodeURIComponent(matches[1]) : undefined
		},
		setCookie (name, value, options) 
		{
			options = options || {}

			let expires = options.expires

			if (typeof expires == 'number' && expires) {
				var d = new Date();
				d.setTime(d.getTime() + expires * 1000)
				expires = options.expires = d
			}
			if (expires && expires.toUTCString) {
				options.expires = expires.toUTCString()
			}

			if (!options.path) options.path = '/'

			value = encodeURIComponent(value)

			let updatedCookie = name + '=' + value

			for (let propName in options) {
				updatedCookie += '; ' + propName
				const propValue = options[propName]
				if (propValue !== true) {
					updatedCookie += '=' + propValue
				}
			}
			document.cookie = updatedCookie
		},
		deleteCookie (name) 
		{
			setCookie(name, '', {
				expires: -1
			})
		},

		// TODO: may need to replace on https://docs.sentry.io/platforms/javascript/vue/
		printErrorOnConsole (err, type = 'danger', msg)
		{
			let color
			let title = 'Error'
			if (msg) msg = msg + ' '

			switch (type) {
				case 'danger':
					color = 'color:red;'
					break;
				case 'warning':
					color = 'color:orange;'
					title = 'Warning'
					break;
				case 'info':
					color = 'color:gray;'
					title = 'Info'
					break;
			}

			if (window.isDevMode) {
				console.group(`%c${title}:`, color)
				if (msg) 
					console.log(`%c${msg}`, color)
				if (typeof err === 'string') {
					console.log(`%c%s`, color, err)
				}
				else {
					console.log(`%c%o`, color, err)
					// if (err.response) {}
					// else if (err.message) {}
				}
				console.groupEnd()
			} else {
				switch (type) {
					case 'danger':
						if (typeof err === 'string') {
							console.error(err)
						} else {
							console.error('Произошла ошибка')
						}
						break;
					case 'warning':
						if (typeof err === 'string') {
							console.warn(err)
						} else {
							console.warn('Возможна не корректная работа')
						}
						break;
					case 'info':
						if (typeof err === 'string') {
							console.info(err)
						}
						break;
				}
			}

			this.writeLogOnServer({
				url: window.location.href,
				msg: `${msg}${title}`,
				err,
			})
		},

		writeLogOnServer (data)
		{
			$.post('/api/v1/log/js', data).fail((trace, type, msg) => {
				console.error(`Error write log\n${type}: ${msg}`)
			})
		},
		
		setTitle (title)
		{
			document.title = `${APPNAME} - ${title}`
			this.$route.meta.title = `${APPNAME} - ${title}`
		},

		paralaxMouse (evt, target, layer = 1, strength = 20, wrapper = window) {
			if (target) {
				const layerCoeff = strength / layer
				const x = (evt.pageX - (wrapper.offsetWidth / 2)) / layerCoeff
				const y = (evt.pageY - (wrapper.offsetHeight / 2)) / layerCoeff
				target.style.transform = `translate(${x}px, ${y}px)`
			}
		}
    },
}

export default mixin
