<template lang="pug">
.not-visible-contact
	div
		feather(type='briefcase')
		p Компания
	div
		b-button(
			class='btn-get-contacts'
			size='lg' 
			variant='outline-primary'
			block
			@click='showContacts'
		) Запросить контакты
	div
		feather(type='user')
		p Продавец

</template>

<script>
export default {
	data() {
		return {
			
		}
	},
	props: {
		cost: Number,
	},
	computed: {},
	methods: {
		showContacts ()
		{
			if (this.$root.isAuth) {
				let content
				
				if (this.$root.profile.profile.ballance >= this.cost) {
					this.$store.commit('setModalMsg', {
						toggle: true,
						content: '<p>Оплата услуги просмотр контакта: <br><b>'+ this.cost +'&nbsp;руб.</b></p>',
						btns: [{
							text: 'Оплатить',
							action: () => {
								this.payforContacts();
								this.$store.commit('setModalMsg', {toggle: false})
							}
						}]
					})
				}
				else {
					content = '<p>У Вас на счету недостаточно средств. Стоимость услуги: <b>'+this.cost+'&nbsp;руб.</b></p>'
					this.$store.commit('setModalMsg', {
						toggle: true,
						content: content,
						btns: [{
							text: 'Перейти в кошелёк',
							action: () => {
								this.$router.push({name: 'lk.wallet',params:{cost: (this.cost).toString()}})
								this.$store.commit('setModalMsg', {toggle: false})
							}
						}]
					})
				}
				
				if (window.isProdMode) window.ym(53902132, 'reachGoal', 'viev_contact_info')
			} 
			else {
				this.$bvModal.show('modalSignin')
			}
		},
		payforContacts(){
			let url = '/api/v1/paymentservice/subscriptions/payment_once_deal_buy_get_contacts/payment'
			axios.post(url, {deal_id: this.$route.params.id}).then(resp =>{
				// console.log(resp.data.result)
				if (resp.data.result){
					this.getDeal()
					window.Api.loadProfile()

				}
			}).catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
	},
	watch: {},
	mounted () {},
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.not-visible-contact {
	text-align: center;
	color: $primary;
	font-size: 1.5rem;

	& > div {
		& + div {
			border-top: .1rem dotted $gray;
			padding: 1rem 1.5rem;
		}
	}
	.btn-get-contacts {

	}
	i.feather {
		width: 5.6rem;
		height: 5.6rem;
		color: inherit;
		margin: 2.5rem 0 1rem;

		svg {
			stroke-width: .1rem;
		}
	}
	p {
		margin: 0 0 2.5rem
	}
}
</style>