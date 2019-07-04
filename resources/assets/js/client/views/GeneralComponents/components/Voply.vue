<template lang="pug">
aside.voply#voply(ref='voply')
	.voply-header
		.voply-header-title Актуальные закупки
		a.text-primary(
			v-if='this.isToggleVoply'
			href='javascript:void(0)' 
			role='button'  
			title='Заявки о покупке'
			:title="isActive ? 'Скрыть' : 'Показать'"
			@click='toggleVoply()'
		)
			feather(type='volume-1')
		span.text-primary(v-else)
			feather(type='volume-1')

	ul.voply-list(v-if='voply')
		li(v-for='bid in voply')
			router-link(
				v-if='!bid.error'
				:to="{name: 'bids.detail', params: {id: bid.id}}" 
				class='card voply-card'
				:id="'voplyCard-'+ bid.id"
			)
				.card-body
					.d-flex.justify-content-between.align-items-top.mb-3
						h5.card-title.w-100 {{bid.name}}
						.card-btn-favorite.flex-shrink-1
							Favorite(:bid='bid')

					.price-row.d-flex.justify-content-between.align-items-center.mb-3
						.w-100.card-price
							Budget(
								:type='bid.type_deal'
								:from='bid.budget_from'
								:to='bid.budget_to'
							)

						.d-flex.align-items-center.flex-shrink-1
							.card-ifograph(
								v-if='false'
								title='Отклики'
							)
								feather(type='user')
								span 0
							.card-ifograph.ml-3(title='Просмотры')
								feather(type='eye')
								span {{bid.count_views}}

					p.card-descr
						span(v-if='bid.description') {{shortDescr(bid.description)}}

				.card-footer
					.card-ifograph
						feather(type='map-pin')
						span.text-small {{bid.cities[0].name}}

					span.text-small {{dateFormat(bid.date_create.date)}}

	p(v-if='!voply || voply.count == 0') Заявки ещё не добавлены
			
</template>

<script>
import Favorite from './Favorite'
import Budget from './Budget'

export default {
	components: {
		Favorite,
		Budget,
	},
	data() {
		return {
			voply: [],
			isToggleVoply: false,
			isActive: true,
		}
	},
	computed: {},
	methods: {
		getVoply () 
		{
			//loading
			axios
			.get('/api/v1/deals/list?type_deal=buy').then((resp) => {
				if (resp.data.data.items) this.voply = resp.data.data.items
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			}).then(() => {
				//loading
			})
		},
		listenVoply ()
		{
			window.EchoPublic.channel('deals.buy.public')
			.listen('.dealsBuy', event => {
				console.log('%cAdded on chanel Buy [public]', 'color:green;')
				switch (event.message) {
					case 'deleted':
						this.removeFromList(event.deal[0].id)
						break
					case 'added':
						this.addFromList(event.deal[0])
						break
					case 'goto_moderation_with_update':
                        this.removeFromList(event.deal[0].id)
                        break
					case 'updated':
						this.addFromList(event.deal[0])
						break
					default:
						break;
				}
			})
		},
		removeFromList (id)
		{
			this.voply = this.voply.filter(function (item) {
				return item.id !== id
			})
		},
		addFromList (item)
		{
			this.voply.unshift(item)
		},
		addFavorite (id)
		{
			axios.post('/api/v1/user/favourites/store', {deal_id: id}).then((resp) => {
				
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			return false
		},
		checkToggleVoply ()
		{
			this.isToggleVoply = (window.innerWidth <= 1750)
		},
		toggleVoply ()
		{
			if (this.isToggleVoply) {
				this.isActive = !this.isActive
				this.$refs.voply.classList.toggle('active')
			}
		},
		shortDescr (descr)
		{
			if (descr.length) 
				return descr.replace(/^(.{50}[^\s]*).*/, "$1")
			return null
		},
	},
	mounted () {
		this.getVoply()
		this.listenVoply()

		this.checkToggleVoply()
		window.addEventListener('resize', () => {
			this.checkToggleVoply()
		})
	}
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

$padding: 1rem;

.height-gift ~ .main {
	.voply {
		top: $height-gift-height;

		@include media-breakpoint-down(sm) {
			top: $height-gift-height-sm;
		}
	}
}
.voply {
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	width: $voply-width;
	background: $white;
	padding: $padding;
	// padding-top: ($height-header + 1rem);
	z-index: 999;
	transition: right .4s ease;
	box-shadow: $box-shadow;

	@media (max-width: 1750px) {
		right: -$voply-width;
	}
	&.active {
		@media (max-width: 1750px) {
			right: 0;
		}
	}

	&-header {
		margin-bottom: 1rem;
		text-align: right;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-top: -$padding;
		margin-left: -$padding;
		margin-right: -$padding;
		padding: $padding;
		min-height: 5rem;
		line-height: 1;

		&-title {
			font-size: 1.4rem;
			color: $primary;
			font-weight: 500;
		}

		.feather--volume-1 {
			width: 2.6rem;
			height: 2.6rem;
		}
	}
	&-list {
		list-style: none;
		overflow-y: auto;
		max-height: calc(100vh - #{$height-gift-height});

		@include media-breakpoint-down(sm) {
			max-height: calc(100vh - #{$height-gift-height-sm});
		}

		li {
			padding: 1rem 0;
			// border-bottom: .1rem dashed $light;
			margin-right: 1rem;

			&:first-child {
				border-top: .1rem solid $light-gray;
			}
		}
	}
	&-card {
		text-decoration: none;
		color: inherit;
		box-shadow: none;
		transform: translateY(0);
		border: solid .1rem $light-gray;
		transition: box-shadow .2s ease, transform .2s ease;

		&:visited {
			.card-footer {
				i.feather {
					&--eye {
						
					}
				}
			}
		}
		@include hover-focus {
			box-shadow: $box-shadow;
			transform: translateY(-.1rem);
		}

		i.feather {
			width: 1.6rem;
			height: 1.6rem;
		}
		
		.card-title {
			font-size: 1.5rem;
			font-weight: 500;
			line-height: 1.5;
			height: 4.6rem;
			overflow: hidden;
			margin: 0;

			a {
				color: inherit;
				text-decoration: none;
			}
		}
		.card-btn-favorite {
			.btn {
				color: $light;
			}
		}
		.price-row {
			font-size: 1.1rem;
			color: $secondary;
		}
		.card-price {
			font-size: 1.7rem;
			white-space: nowrap;
			font-weight: 700;
			color: $primary;
		}
		.card-descr {
			font-size: 1.4rem;
			color: $secondary;
			line-height: 1.6;
			height: 4.6rem;
			overflow: hidden;
		}
		.card-footer {
			background: none;
			border: none;
			font-size: 1.1rem;
			color: $light;
			display: flex;
			align-items: flex-end;
			justify-content: space-between;
			padding-top: 0;

			i.feather {
				vertical-align: middle;
				width: 1.8rem;
				height: 1.8rem;

				&--map-pin {
					width: 1.4rem;
					height: 1.4rem;
					color: inherit;
				}
			}
		}
	}
}
</style>