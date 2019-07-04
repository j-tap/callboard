<template lang="pug">
.password-resset
	transition(name='fade')
		.password-resset-success(v-if='success')
			p На вашу почту отправлено письмо с новым паролем.
			p Перейдите по ссылке из письма и выполните вход.

		.password-resset-form(v-else)
			v-form(@submit.prevent='ressetSubmit')

				v-text-field(
					v-model="email"
					label="E-mail"
					data-vv-as='E-mail'
					data-vv-name='email'
					v-validate=`'required|email'`
					:error-messages="err.email ? err.email : errors.collect('email')"
					required
					@input='change'
				)

				.pt-4
					b-button(variant='outline-primary' type='submit' :disabled='loading') 
						span.px-3 
							|Отправить 
							b-spinner(v-if='loading' label='Загрузка...')

</template>

<script>
export default {
	data() {
		return {
			email: '',
			loading: false,
			err: {},
			success: false,
		}
	},
	methods: {
		ressetSubmit ()
		{
			this.$validator.validateAll().then((result) => {
				if (result) {
					this.formSend()
					return
				}
			})
		},
		formSend () 
		{
			this.err = {}
			this.loading = true

			axios.post('/api/v1/user/passwordreset', {email: this.email})
			.then((resp) => {
				this.loading = false
				if (resp.data.result) {
					this.success = true
				} else if (resp.data.error) {
					this.err = resp.data.error
				} else {
					console.log('%cResponse not valid: %O', 'color:orange;', resp.data)
				}
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				this.loading = false
			})
		},
		change ()
		{
			this.err = {}
		}
	},
}
</script>

<style lang="scss">
.password-resset {

}
</style>
