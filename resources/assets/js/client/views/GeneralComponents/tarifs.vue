<template lang="pug">
.tarifs
	.tarifs-filter
		b-btn(
			:class="{'active': isTarifs}"
			@click.stop="toggle('tarifs')"
			size='sm'
			variant='outline-primary'
		) Тарифы

		b-btn(
			:class="{'active': isServices}"
			@click.stop="toggle('services')"
			size='sm'
			variant='outline-primary'
		) Услуги

	div(v-show='isTarifs')
		ul.tarifs-list.row(
			v-if='tarifsList.length'
		)
			li.col-md-3(
				v-for='(item, ind) in tarifsList' 
				:key='item.id'
			)
				.tarif-item(
					:class="[ item.is_active ? `m-${item.slug} active` : `m-${item.slug}` ]"
				)
					h4.tarif-title 
						|{{item.name}}
						//- div(v-if='item.duration_days') {{item.duration_days|countableDays}}

					.tarif-price
						span(v-if='item.cost') {{priceFormat(item.cost)}}&nbsp;&#8381;
						span(v-else) Бесплатно

					.tarif-info
						div
							p {{item.description}}

					.footer-info
						div(v-if='$root.isAuth')
							template(v-if='item.is_active')
								div Срок действия
								div до {{dateEnd(item.started_at, item.duration_days)}}

							template(v-else)
								template(v-if='item.is_promo')
									template(v-if='item.is_possible_activate')
										span Активируйте, когда потребуется
									template(v-else)
										span Действие тарифа завершилось

								template(v-else)
									router-link(
										class='btn btn-outline-primary'
										:to="{name: 'lk.tarifs.checkout', params: {id: item.id}}"
									) Выбрать
									
						div(v-else)
							button.btn.btn-outline-primary(
								v-on:click="$bvModal.show('modalSignin')"
							) Выбрать
							
					.current-tarif(
						v-if='item.is_active'
					)
						span Активный тариф
					.free-tarif(
						v-if='!item.is_active && item.is_possible_activate && item.is_promo'
					)
						button.btn.btn-outline-danger(
							v-if='$root.isAuth'
							v-on:click='activate()'
						) Активировать
						button.btn.btn-outline-danger(
							v-else
							v-on:click="$bvModal.show('modalSignin')"
						) Активировать

		.tarifs-list(v-else)
			p Ожидайте тарифов
					
	div(v-show='isServices')
		ul.tarifs-list.row(
			v-if='servicesList.length'
		)
			li.col-md-3(
				v-for='(item, ind) in servicesList' 
				:key='item.id'
			)
				.service-item
					h4.tarif-title 
						|{{item.name}}
						div(v-if='item.duration_days') 
							|{{item.duration_days|countableDays}}
					.tarif-price
						span(v-if='item.cost') {{priceFormat(item.cost)}}&nbsp;&#8381;
						span(v-else) Бесплатно
					.tarif-info
						div 
							p {{item.description}}

		.tarifs-list(v-else)
			p Ожидайте услуг

</template>
<script>
export default {
	data() {
		return {
			tarifsList: [],
			servicesList: [],
			isTarifs: true,
			isServices: false
		}
	},
	filters: {
		countableDays(n) {
			return n % 10 == 1 && n % 100 != 11
				? n + " день"
				: n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20)
				? n + " дня"
				: n + " дней"
		}
	},
	// если пользователь авторизован - сразу перенаправляем его на страницу тарифов в ЛК
	beforeRouteEnter(to, from, next) {
		next(vm => {
			if (vm.$root.profile != null) {
				next({ name: "lk.tarifs" })
			}
		})
	},
	computed: {
		getLinkTarifs () {
			if (this.$root.isAuth) return '/api/v1/paymentservice/tariffsavailableforuser'
			return '/api/v1/paymentservice/tariffsavailableforall'
		},
		getLinkServices () {
			if (this.$root.isAuth) return '/api/v1/paymentservice/servicesavailableforuser'
			return '/api/v1/paymentservice/servicesavailableforall'
		},
	},
	watch: {
		'$root.isAuth' (val) {
			if (val) {
				this.$router.replace({ name: 'lk.tarifs' })
			}
		}
	},
	methods: {
		getTarifs() {
			this.$parent.loading = true
			axios
				.get(this.getLinkTarifs)
				.then(resp => {
					this.tarifsList = resp.data.data.data
					this.tarifsList.sort((a, b) => {
						// if (a.is_active) {
						// 	return -1
						// } else 
						if (a.is_promo) {
							return -1
						}
						else {
							return 1
						}
						return 0
					})
				})
				.catch(error => {
					this.printErrorOnConsole(error)
				})
				.then(() => {
					this.$parent.loading = false
				})
		},
		getServices() {
			this.$parent.loading = true
			axios
				.get(this.getLinkServices)
				.then(resp => {
					this.servicesList = resp.data.data.data
				})
				.catch(error => {
					this.printErrorOnConsole(error)
				})
				.then(() => {
					this.$parent.loading = false
				})
		},
		toggle(type) {
			switch (type) {
				case "tarifs":
					this.isTarifs = true
					this.isServices = false
					break
				case "services":
					this.isTarifs = false
					this.isServices = true
					break
			}
		},
		dateEnd(dStart, dateDuration) {
			let endDate = new Date(dStart)
			endDate.setDate(endDate.getDate() + dateDuration)

			return endDate
				.toISOString()
				.slice(0, 10)
				.split("-")
				.reverse()
				.join(".")
		},
		activate() {
			axios
			.post("/api/v1/paymentservice/subscriptions/payment_all_in_3_days/activate")
			.then(resp => {
				if (resp.data.result == true) {
					this.$store.commit('setSnackbar', {color: 'success', text: 'Подарок активирован', toggle: true})
					this.$emit("profileUpdateEmit");
				}
				else {
					this.$store.commit('setSnackbar', {color: 'error', text: resp.data.error, toggle: true})
				}
			})
			.catch(error => {
				this.printErrorOnConsole(error)
				this.$store.commit('setSnackbar', {color: 'error', text: 'Ошибка', toggle: true})
			})
		},
	},
	mounted() {
		this.getTarifs()
		this.getServices()
	},
};
</script>
<style lang="scss" scoped>
@import "../../../../sass/base.scss";

.tarifs {

	.tarifs-filter {
		margin-bottom: 1.5rem;

		.btn {
			padding-left: 2.5rem;
			padding-right: 2.5rem;
			border-color: $gray;
			color: $gray;
			background: $white;

			&.active {
				background: $white;
				border-color: $primary;
				color: $primary;
			}

			& + .btn {
				margin-left: 1.5rem;
			}
		}
	}
}
.centralized {
	float: right;
	margin-top: .7rem;
	font-size: 1.5rem;
}
.tarifs-list {
	list-style: none;
	padding: 0;

	@include media-breakpoint-down(md) {
		margin-right: 1rem;
	}

	li {
		
	}
}
.service-item,
.tarif-item {
	position: relative;
	height: calc(100% - 5rem);
	box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0);
	border: solid 1px $light-gray;
	background-color: $white;
	padding: 1rem;
	margin-bottom: 5rem;
	transition: box-shadow .2s ease, transform .2s ease;

	@include hover-focus {
		box-shadow: 0 3px 6px 0 rgba(0, 0, 0, .16);
		transform: translateY(-.1rem);
	}
}
.tarif-item {
	&.m-payment_all_in_3_days {
		.tarif-title {
			color: $success;
		}
	}
	&.m-payment_all_in {
		.tarif-title {
			color: $secondary;
		}
	}
	&.m-payment_all_in_3_months {
		.tarif-title {
			color: $primary;
		}
	}
	&.m-payment_all_in_6_months {
		.tarif-title {
			color: $danger;
		}
	}
}
.service-item {
	.tarif-info {
		padding-bottom: 2.5rem;
		min-height: 15rem;
	}
}
.current-tarif {
	background-color: $primary;
	font-size: 1.4rem;
	font-weight: 500;
	color: $white;
	height: 4.5rem;
	width: 90%;
	margin: 0 auto;
	text-align: center;
	line-height: 4.5rem;
	position: absolute;
	bottom: -4.5rem;
	left: 5%;

	&.active {
		
	}
}
.tarif-title {
	font-size: 1.6rem;
	font-weight: 500;
	text-align: left;
	margin: 1rem 0;
	font-weight: 500;
	line-height: 1;
	height: 4.8rem;
	overflow: hidden;
	padding: 0;
}
.tarif-price {
	font-size: 2rem;
	font-weight: 500;
	text-align: left;
	color: $body-color;
	line-height: 1;
	height: 2rem;
	overflow: hidden;
	margin-bottom: 2rem;
}
.tarif-info {
	border-top: .1rem dotted $gray;
	padding: 2.5rem 1rem 7.5rem;
	margin: 0 -1rem;
	font-size: 1.4rem;
	font-weight: normal;
	min-height: 26rem;
	display: flex;
	align-items: center;
	font-style: italic;
	color: $secondary;

	p {
		
		margin: 0;
	}
}
.footer-info {
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	height: 7rem;
	padding: 1rem;
	text-align: center;
	font-size: 1.4rem;
	font-weight: normal;
	font-style: italic;
	color: $light;

	.btn {
		font-style: normal;
		font-size: 1.8rem;
		padding: .7rem 3rem;
	}
}
.current-tarif {
	background: transparent;
	height: auto;
	line-height: inherit;
	background-color: $primary;
	font-size: 1.6rem;
	font-weight: 500;
	color: $white;
	height: 4.5rem;
	width: 90%;
	margin: 0 auto;
	text-align: center;
	line-height: 4.5rem;
	position: absolute;
	bottom: -4.5rem;
	left: 5%;
}
.free-tarif {
	height: auto;
	line-height: inherit;
	height: 4.5rem;
	width: 100%;
	margin: 0 auto;
	text-align: center;
	line-height: 4.5rem;
	position: absolute;
	bottom: -5rem;
	left: 0;
	padding: 0 1rem;

	.btn {
		font-size: 1.5rem;
		padding: .7rem 2.5rem;
	}
}
</style>
