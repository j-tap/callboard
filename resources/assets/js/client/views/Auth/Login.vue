<template lang="pug">
div
	|Login page!
	form(@submit="login")
		input(v-model="auth.email" type="email" placeholder="email")
		input(v-model="auth.password" type="password" placeholder="password")
		button(type="submit") Login!
		button(type="button" @click="profile") Profile!

</template>
<script>
import Cookies from 'js-cookie'

export default {
	data() {
		return {
			auth: {
				email: null,
				password: null,
			}
		}
	},
	methods: {
		login (event)
		{
			event.preventDefault();

			axios.post('/api/v1/user/login', this.auth).then((resp) => {
				Cookies.set('api_auth', resp.data.data.api_token)
			}).catch((error) => {

			})
		},
		profile ()
		{
			axios.get('/api/user/profile').then((resp) => {

			})
		}
	}
}
</script>