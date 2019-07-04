<template lang="pug">
.signin-form(v-if="!this.$root.profile" :class='cls')
	//.signin-form-description
		p
			| Я принимаю условиях 
			a(href="javascrip:void(0)") лицензионного соглашения 
			| и даю свое согласие на обработку персональных данных на условиях и целях, определенных 
			a(href="javascrip:void(0)") политикой конфиденциальности

	v-form(@submit.prevent='loginSubmit')
		.form-group
			v-text-field( 
				v-model="user.email"
				:error="err.email ? true : false"
				label="Email"
				placeholder='Введите Ваш email'
				:light='true'
				solo
				@keyup.enter="login"
				data-vv-as='Email'
				data-vv-name='email'
				v-validate=`'required|email'`
				:error-messages="err.email ? err.email : errors.collect('email')"
				required
			)
		.form-group
			v-text-field(
				v-model="user.password"
				:error="err.password ? true : false"
				label="Пароль"
				placeholder="Введите Ваш пароль"
				:light='true'
				solo
				:type="show_password ? 'text' : 'password'"
				:append-icon="show_password ? 'visibility_off' : 'visibility'"
				@click:append="show_password = !show_password"
				@keyup.enter="login"
				data-vv-as='Пароль'
				data-vv-name='password'
				v-validate=`'required|min:6'`
				:error-messages="err.password ? err.password : errors.collect('password')"
				required
			)
			p.text-danger.my-3(v-if='err.message') {{err.message}}
			p.text-primary.my-3(v-if='msg') {{msg}}
			p(v-if="err.error_code == 'register'")
				b-button(
					size='sm' 
					variant='outline-primary' 
					type='button'
					@click='resendMail'
				) Отправить письмо повторно

		.pt-4
			b-button(size='lg' variant='outline-primary' type='submit' :disabled='loading')
				span.px-3 
					|Войти 
					b-spinner(v-if='loading' label='Загрузка...')

</template>

<script>
import Cookies from 'js-cookie';

export default {
	data() {
		return {
			loading: false,
			show_password: false,
			user: {
				email: '',
				password: ''
			},
			err: {},
			msg: null
		};
	},
	props: {
		cls: String
	},
	methods: {
		loginSubmit() {
			this.$validator.validateAll().then(result => {
				if (result) {
					this.formSend()
					return
				}
			});
		},
		async formSend() {
			this.err = {}
			this.loading = true

			const login = await Api.login(this.user)

			if (login.api_token) {
				this.$root.login()
				this.loading = false
				this.err = {}
			} 
			else {
				// if (login.status === 401) {
				this.errInit(login.data.error)
				this.loading = false
			}
		},
		errInit (err)
		{
			Cookies.remove('api_auth')
			this.$root.profile = null
			this.err = err
			this.msg = null
			this.loading = false
		},
		resendMail ()
		{
			axios.post('/api/v1/register/repeateregistermail', {
				email: this.user.email
			})
			.then(resp => {
				if (resp.data.result) {
					this.err = {}
					this.msg = 'Письмо успешно отправлено, перейдите на почту.'
				}
			})
		}
	},
	mounted() {}
};
</script>

<style lang="scss">
@import "../../../../sass/base.scss";

.signin-form {
	margin-bottom: 1.5rem;

	&-description {
		text-align: center;
		margin: 0;
		font-size: 1.2rem;
		line-height: 1.2;
		margin-bottom: 2.5rem;
	}
	.v-form {
		.form-group {
			//margin-bottom: 0;

			p {
				line-height: 1.1;
				font-size: 1.4rem;
			}
		}
	}
}
</style>
