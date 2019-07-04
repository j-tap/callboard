<template lang="pug">
.card.profile-card.mb-5
	.card-body
		.wallet(v-if='profile && tarif')
			.form-checkout
				h3.form--title Оплата
				.checkout-section.checkout-structure
					h4.checkout-section-title Состав заказа
					dl.price-info
						dt Стоимость
						dd {{priceFormat(tarif.cost)}} руб.
					dl.service-info
						dt Услуги
						dd {{tarif.name}}
					.tarif-descr {{tarif.description}}
				.checkout-section.checkout-userinfo
					h4.checkout-section-title Плательщик
					.user-info-wrapper
						dl.user-info
							dt Договор
							dd
								span(v-if='company') {{company}}, 
								span Публичная Оферта, 387364934
						dl.wallet-info
							dt На счету
							dd {{priceFormat(balance)}} руб.

				.checkout-section.checkout-payments(v-if='possibleWallet')
					template(v-if='possibleWallet.is_possible && !possibleWallet.is_pro_account')
						h4.checkout-total-title С вашего кошелька будет снято {{priceFormat(possibleWallet.cost_of_service)}} руб.

						.v-text-field.d-flex.justify-content-between
							.text-center
								b-button(
									variant='outline-primary'
									:disabled='loading'
									@click.stop='payFromWallet'
								) 
									span.px-3 
										span Оплатить
										b-spinner(v-if='loading' label='Загрузка...')

					template(v-else)
						h4.checkout-section-title Способ оплаты
						.form-group.payment-element
							label.payment-element-wrapper
								input.payment-element-value(
									name="paymenttype"
									v-model="form.paymenttype"
									type="radio"
									value="bank-transaction"
								)
								span.payment-element-title
									i.payment-element-icon.i
										bank-icon
									i.payment-element-text Банковский перевод

						.checkout-section.checkout-total
							h4.checkout-total-title Общая стоимость заказа {{priceFormat(tarif.cost)}} руб.
							.form-group
								p.total-price К оплате: {{priceFormat(Math.abs(balance - tarif.cost))}} руб.
								.v-text-field.d-flex.justify-content-between
									.text-center
										b-button(
											variant='outline-primary'
											:disabled='loading'
											@click.stop='checkout'
										) 
											span.px-3 
												span Выписать счёт
												b-spinner(v-if='loading' label='Загрузка...')

</template>
<script>
import { Validator } from "vee-validate";
import vue from "vue";
import { Stream } from "stream";

vue.component("bank-icon", {
  template: `
	<svg xmlns="http://www.w3.org/2000/svg" width="28.018" height="28.004" viewBox="0 0 28.018 28.004">
		<defs>
		</defs>
		<g id="bank-building" transform="translate(0 -.012)">
				<g id="Layer_1_78_" transform="translate(0 .012)">
						<g id="Group_1032" data-name="Group 1032">
								<path id="Path_50" d="M26.732 42.718H1.273a1.273 1.273 0 0 0 0 2.547h25.459a1.273 1.273 0 0 0 0-2.547z" style="fill:#85db4b" data-name="Path 50" transform="translate(0 -17.26)"/>
								<path id="Path_51" d="M3.942 28.54a1.274 1.274 0 0 0 0 2.547h22.277a1.274 1.274 0 0 0 0-2.547H25.9V17.083h.318a.636.636 0 0 0 0-1.272H3.942a.636.636 0 0 0 0 1.272h.318V28.54h-.318zm19.413-11.457V28.54h-3.819V17.083zm-6.365 0V28.54h-3.819V17.083zm-10.183 0h3.819V28.54h-3.82z" style="fill:#85db4b" data-name="Path 51" transform="translate(-1.078 -6.393)"/>
								<path id="Path_52" d="M1.273 8.285h25.471a1.273 1.273 0 0 0 .413-2.478L14.526.123a1.276 1.276 0 0 0-1.044 0L.751 5.851a1.273 1.273 0 0 0 .522 2.434z" style="fill:#85db4b" data-name="Path 52" transform="translate(0 -.012)"/>
						</g>
				</g>
		</g>
</svg>`
});

export default {
	props: {
		profile: Object,
	},
	data() {
		return {
			err: {},
			formData: new FormData(),
			form: {
				price: null,
				paymenttype: 'bank-transaction'
			},
			tarif: null,
			possibleWallet: null,
			loading: false,
		}
	},
	computed: {
		balance ()
		{
			return this.profile.profile.ballance || 0
		},
		company ()
		{
			if (this.profile.is_org_created)
				return this.profile.company.organization.name
			return null
		},
	},
	methods: {
		getTarif ()
		{
			this.$parent.loading = true;
			axios
			.get('/api/v1/paymentservice/subscriptions/' + this.$route.params.id)
			.then((resp) => {
				this.tarif = resp.data.data[0]
				this.isPossibleFromWallet()
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				this.$router.replace({ name: 'page404' })
			})
			.then(() => {
				this.$parent.loading = false
			})
		},
		isPossibleFromWallet ()
		{
			this.$parent.loading = true
			axios
			.get('/api/v1/paymentservice/' + this.tarif.slug)
			.then((resp) => {
				this.possibleWallet = resp.data.data
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			.then(() => {
				this.$parent.loading = false
			})
		},
		payFromWallet ()
		{
			this.$parent.loading = true
			axios
			.post('/api/v1/paymentservice/subscriptions/'+ this.tarif.slug +'/payment', {})
			.then((resp) => {
				if (resp.data.result) {
					this.$store.commit('setSnackbar', {color: 'success', text: 'Тариф '+ this.tarif.name +'активирован', toggle: true})
					const profile = this.$store.state.profile.profile
					profile.ballance = (profile.ballance - this.possibleWallet.cost_of_service)
					this.$store.commit('setProfile', {profile: profile})
					this.$router.push({name: 'lk.tarifs'})
				} else {
					if (resp.data.error)
						this.$store.commit('setSnackbar', {color: 'error', text: resp.data.error, toggle: true})
				}
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			.then(() => {
				this.$parent.loading = false
			})
		},
		checkout ()
		{
			this.$parent.getBillPay({
				price: parseInt(this.possibleWallet.cost_of_service, 10),
			})
		},
	},
	mounted () {
		this.getTarif()
	},
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/base.scss';

.checkout-section-title {
	font-family: Roboto;
	font-size: 18px;
	font-weight: 500;
	text-align: left;
	color: #010101;
	border-bottom: 0.2rem dotted #dadada;
	padding-bottom: 5px;
	margin-bottom: 20px;
}
.checkout-section {
	margin-top: 30px;
}
.user-info-wrapper {
	display: flex;
	background: $body-bg-gray;
	margin: 5rem -1.5rem 0;
	padding: 1.5rem;
	
	dl {
		dt {
			margin-top: -5rem;
			margin-bottom: 3rem;
		}
		dd {
			font-size: 1.8rem;
			font-weight: 500;
			margin: 0;
		}
	}
}
dt {
	font-size: 1.4rem;
	color: $light;
	font-weight: normal;
}
.price-info {
	text-align: right;
	float: right;

	dd {
		font-size: 2.5rem;
		font-weight: 500;
	}
	dt {
		margin-bottom: 8px;
	}
}
.service-info {
	dt {
		margin-bottom: 10px;
	}
	dd {
		font-size: 2.5rem;
		color: $success;
	}
}
.tarif-descr {
	border-top: .2rem dotted #dadada;
	padding-top: 10px;

	p {
		font-size: 1.4rem;
		text-align: left;
		margin-bottom: 5px;
	}
}
.user-info,
.wallet-info {
	width: 100%;
	flex-direction: column;
	display: flex;
}
.user-info {
	dl {
		font-family: Roboto;
		font-size: 18px;
		color: #010101;
	}
}
.wallet-info {
	text-align: right;

	dl {
		flex: 1;
		align-items: center;
		justify-content: end;
	}
}
.user-info dl {
	font-family: Roboto;
	font-size: 18px;
	color: #010101;
	flex: 1;
	min-height: 72px;
	align-items: center;
}
.user-info dl,
.wallet-info dl {
	background: #e6e9ec;
	display: flex;
}
.wallet-info dt,
.user-info dt {
	margin-bottom: 10px;
}
.wallet-info dl {
	font-family: Roboto;
	font-size: 20px;
	color: #010101;
}
.form--title {
	font-size: 2rem;
	font-weight: normal;
	font-style: normal;
	font-stretch: normal;
	line-height: 2;
	letter-spacing: normal;
	text-align: left;
	color: $secondary;
	border-bottom: 2px dotted $body-color;
}
.form-checkout .v-input--is-focused .v-input__slot {
	border-radius: 10px;
	box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16) !important;
	border-color: $light !important;
	background-color: $white;
}
.input-title,
.payment-type-title {
	font-family: Roboto;
	font-size: 18px;
	text-align: center;
	color: #cfcccc;
	display: block;
}
.checkout-payments {
	margin-bottom: 35px;
}
.payment-type-title {
	margin-bottom: 3px;
}
.form-group {
	max-width: 290px;
	margin: 2rem auto;
}
.payment-element-wrapper {
	display: flex;
	align-items: center;
	position: relative;
}
.payment-element-value {
	width: 17px;
	height: 17px;
	position: relative;
	z-index: -1;
}
.payment-element-value:checked + .payment-element-title::before {
	border-radius: 5px;
	border: solid 4px #0071bc;
	width: 17px;
	height: 17px;
	content: "";
	transition: all 0.1s 0.1s;
}
.payment-element-title::before {
	content: "";
	transition: all 0.1s 0.1s;
	width: 17px;
	height: 17px;
	position: absolute;
	border-radius: 5px;
	border: solid 1px #e6e9ec;
	left: 0px;
	top: 17px;
}

.payment-element-title {
	padding: 1rem;
	border: 1px solid #e6e9ec;
	border-radius: 10px;
	width: 100%;
	margin-left: 15px;
}

.payment-element-wrapper:hover > .payment-element-title,
.payment-element-value:checked + .payment-element-title {
	box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
	transition: all 0.1s 0.1s;
}
.payment-element-icon {
	margin-right: 20px;
}
.payment-element-text {
	font-family: Roboto;
	font-size: 16px;
	text-align: left;
	color: #010101;
	font-style: normal;
}
.checkout-total-title {
	font-family: Roboto;
	font-size: 14px;
	text-align: left;
	color: $secondary;
	border-bottom: 2px dotted #808080;
	padding-bottom: 10px;
}
.total-price {
	font-family: Roboto;
	font-size: 20px;
	font-weight: 500;
	text-align: center;
	color: #010101;
	margin-bottom: 15px;
}
.form-checkout .text-center .btn {
	font-size: 1.8rem;
	font-weight: normal;
	line-height: 2;
	letter-spacing: normal;
	max-width: 255px;
	width: 100%;
}
.form-checkout {
	padding-bottom: 2rem;
}
@media (max-width: 540px) {
	.price-info {
		float: none;
	}
	.service-info dd {
		font-size: 25px;
	}
	.user-info-wrapper {
		display: block;
	}
	.wallet-info dt {
		text-align: left;
		padding-left: 1.5rem;
	}
	.wallet-info dl {
		text-align: left;
		display: block;
		padding-left: 1.5rem;
		padding-top: 1rem;
		padding-bottom: 1rem;
	}
}
</style>
