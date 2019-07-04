<template lang="pug">
.auth-content
	.auth-content-logo
		logoheader
	.auth-content-form
		.row
			.col-lg-6
				transition(name='fade' mode='out-in')
					.modal-content-pwdresset(v-if='isShowPasswordReset' key='1')
						h4.mb-4 Сброс пароля
						PasswordReset(class='mb-3')
						b-button(variant='link' @click='togglePasswordReset') Войти
						
					.modal-content-login(v-else key='2')
						h4.mb-4 Войдите
						Signin
						b-button(variant='link' @click='togglePasswordReset') Забыли пароль?

			.col-lg-6
				h4.mb-4 или
				.pt-4
					b-button(size='lg' variant='outline-primary' @click='gotoRegister') 
						.px-5 Зарегистрируйтесь

</template>

<script>
import Signin from './Signin'
import PasswordReset from './PasswordReset'

export default {
	components: {
		Signin,
		PasswordReset,
	},
	data() {
		return {
			isShowPasswordReset: false,
		}
	},
	methods: {
		gotoRegister ()
		{
			this.$emit('hideModalSignin')
			this.$router.push({name: 'register'})
		},
		togglePasswordReset ()
		{
			this.isShowPasswordReset = !this.isShowPasswordReset
		},
	},
}
</script>

<style lang="scss" scope>
@import '../../../../sass/base.scss';

.auth-content {
	text-align: center;
	padding: 0 3rem;

	&-logo {
		margin: 0 0 2.5rem;

		svg {
			width: 12rem;
			height: 2.6rem;
		}
	}
	&-form {
		padding-top: 2.5rem;
		border-top: .1rem dashed $light;

		[class^='modal-content-'] {
			max-width: 29rem;
			margin: 0 auto;
		}
		& > .row > [class^='col-']:first-child {
			@include media-breakpoint-up(lg) {
				border-right: .1rem dashed $light;
			}
			@include media-breakpoint-down(md) {
				border-bottom: .1rem dashed $light;
				padding-bottom: 1.5rem;
				margin-bottom: 1.5rem;
			}
		}

		h4 {
			font-size: 1.6rem;
		}
	}
	.btn-link {
		font-size: 1.4rem;
	}
}
</style>
