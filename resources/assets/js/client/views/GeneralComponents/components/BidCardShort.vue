<template lang="pug">
router-link(
	v-if='show'
	:class="cardClass"
	:id="'bidCardShort-'+ bid.id"
	:to="{name: 'bids.detail', params: {id: bid.id}}"
)
	.card-img-wrap(
		v-if="bid.type_deal == 'sell'"
	)
		.card-img-head(
			v-if='bid.categories.length'
		)
			//- .card-img-label.m-text-lg.m-left.m-success(title='Скидка')
				span 15%
			//- .card-img-label.m-right.m-danger(title='Отлик')
				span
					|+3
					br
					small Отлик

			//- span(:class=`'tile float-right ' + (bid.categories[0].cl_background)` :title='bid.categories[0].name')
				component(:is='bid.categories[0].cl_icon')

		img(
			v-if='bid.imagesDeals.length'
			:src='bid.imagesDeals[0].path' 
			alt=' '
		)
		img.img-nophoto(
			v-else
			src='/images/no-photo.svg' 
			alt=' '
		)

		.card-img-foot
			span &nbsp;
			.card-btn-favorite
				Favorite(
					:bid='bid'
					@removeFavorite='removeFavorite'
				)

	.card-body
		.card-manage-bar(v-if="type === 'edit' && $root.isAuth")
			b-btn(
				class='m-edit'
				:to="{name: 'lk.deals.edit', params: {id: bid.id}}" 
				variant='link' 
			)
				feather(type='edit-3')
				span Редактировать

			b-btn(
				class='m-remove'
				@click.prevent='deleteBid($event)' 
				variant='link' 
			)
				feather(type='x-square')
				span Удалить

		.d-flex.justify-content-between.align-items-center.mb-3(
			v-if="bid.type_deal == 'buy'"
		)
			h3.card-title {{bid.name}}
			.card-btn-favorite.m-gray.text-right
				Favorite(
					:bid='bid'
					@removeFavorite='removeFavorite'
				)

		.d-flex.justify-content-between.align-items-center.mb-3
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

		template(v-if="bid.type_deal == 'sell'")
			h3.card-title {{bid.name}}
		p.card-descr(v-if='shortDescr') {{shortDescr}}

	.card-footer
		.card-ifograph
			feather(type='map-pin')
			span.text-small {{bid.cities[0].name}}
		//- .text-secondary.text-small.mr-3(v-if='bid.deadline_deal && dateFormat(bid.deadline_deal)') 
			|завершается {{dateFormat(bid.deadline_deal).toLowerCase()}}

		span.text-small {{dateFormat(bid.date_create.date)}}
			
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
			show: true,
		}
	},
	props: {
		bid: Object,
		index: Number,
		type: String, // favorites edit
	},
	computed: {
		cardClass ()
		{
			let cls = 'card bid-card-short'
			cls += ' m-'+ this.bid.type_deal
			if (this.type) cls += ' m-'+ this.type
			return cls
		},
		linkDetail ()
		{
			if (this.type === 'edit' && this.$root.isAuth)
				return 'lk.deals.edit'
			else
				return 'bids.detail'
		},
		shortDescr ()
		{
			if (this.bid.description) 
				return this.bid.description.replace(/^(.{50}[^\s]*).*/, "$1")
			return null
		},
	},
	methods: {
		deleteBid (evt)
		{
			this.$store.commit('setLoading', true)
			axios
			.post('/api/v1/deals/'+ this.bid.id +'/finish')
			.then((resp) => {
				this.$parent.removeFromList(this.index)
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			.then(() => {
				this.$store.commit('setLoading', false)
			})

			evt.preventDefault()
			evt.stopPropagation()
			return false
		},
		removeFavorite (id)
		{
			if (this.type === 'favorites') {
				this.show = false
			}
		},
	},
	mounted () {}
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

$manage-bar-height: 4.5rem;

.bid-card-short {
	text-decoration: none;
	color: inherit;
	overflow: hidden;
	transition: $transition-card;
	box-shadow: $box-shadow;
	height: 100%;

	&.m-edit {
		&.m-buy {
			.card-body {
				margin-top: $manage-bar-height;
			}
		}
		.card-img-wrap {
			.card-img-foot {
				background: none;
			}
		}
	}

	.card-body {
		position: relative;
		padding-top: 1rem;
		padding-bottom: 0;
		min-height: 13rem;
	}

	@include hover-focus {
		box-shadow: $box-shadow-fx;
		transform: translateY(-.2rem);
		
		.card-btn-favorite {
			opacity: 1;
		}
	}
	&:visited {
		i.feather {
			&--eye {
				
			}
		}
	}

	.card-img-wrap {
		overflow: hidden;
		position: relative;
		height: 17rem;
		line-height: 17rem;
		text-align: center;
		font-size: 0;

		@include media-breakpoint-down(sm) {
			height: 14rem;
			line-height: 14rem;
		}

		img {
			@include imgCenter();

			&.img-nophoto {
				max-width: 7rem;
			}
		}
		.card-img-foot,
		.card-img-head {
			position: absolute;
			z-index: 2;
			left: 0;
			padding: 1rem;
			width: 100%;
			line-height: 1;
			font-size: $font-size-base;
		}
		.card-img-head {
			top: 0;
		}
		.card-img-foot {
			height: 7rem;
			display: flex;
			align-items: flex-end;
			justify-content: space-between;
			bottom: 0;
			background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 50%, rgba(0, 0, 0, 0.3) 100%);
		}
	}

	& > a {
		color: inherit;
		text-decoration: none;
	}
	.card-manage-bar {
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
		position: absolute;
		left: 0;
		right: 0;
		top: -$manage-bar-height;
		z-index: 2;

		.btn {
			height: $manage-bar-height;
			line-height: $manage-bar-height;
			padding: 0 1.5rem;
			width: 100%;
			color: $white;
			background: rgba($secondary, .3);
			border-radius: 0;
			transition: background .2s ease;
			text-decoration: none;

			@include hover-focus {
				background: rgba($secondary, .6);
			}

			&.m-edit {
				background: rgba($primary, .3);
				@include hover-focus {
					background: rgba($primary, .6);
				}
			}
			&.m-remove {
				
			}
			i.feather {
				color: inherit;
				width: 2.5rem;
				height: 2.5rem;
				margin-right: 1.5rem;
			}
		}
	}
	.badge {
		padding: 0;
		width: 3.5rem;
		height: 3.5rem;
		line-height: 3.5rem;
	}
	.tile {
		margin: 0;
	}
	.card-img-label {
		top: -9rem;
		position: absolute;
		font-size: 1.6rem;
		text-align: center;
		white-space: nowrap;
		color: #fff;
		width: 18rem;
		height: 18rem;
		line-height: 25rem;
		border-radius: 7rem;
		/* transform: rotate(-45deg); */

		&.m-text-lg {
			font-size: 2.6rem;
		}

		&.m-left {
			left:  -9rem;
			padding-left: 7rem;
		}
		&.m-right {
			right:  -9rem;
			padding-right: 7rem;
		}

		&.m-success {
			background: rgba($success, .85);
		}
		&.m-danger {
			background: rgba($danger, .85);
		}
		&.m-primary {
			background: rgba($primary, .85);
		}

		& > * {
			line-height: 1.4;
			display: inline-block;
			vertical-align: middle;
		}
	}
	.card-price {
		font-size: 1.7rem;
		white-space: nowrap;
		font-weight: 700;
		color: $primary;
	}
	.card-btn-favorite {

		&.m-gray {
			/deep/ .btn {
				color: $light;
			}
		}
	
		/deep/ .btn {
			color: $white;

			&.active {
				i.feather {
					svg {
						fill: currentColor;
					}
				}
			}

			i.feather {
				width: 2.5rem;
				height: 2.5rem;

				svg {
					stroke-width: .2rem;
				}
			}
		}
	}
	.card-title {
		color: $body-color;
		font-weight: 500;
		font-size: 1.7rem;
		margin: 0 0 .5rem;
		line-height: 1.4;
		overflow: hidden;
		max-height: 4.7rem;
	}
	.card-descr {
		font-size: 1.4rem;
		color: $secondary;
		line-height: 1.6;
		overflow: hidden;
		max-height: 4.2rem;
	}
	.card-footer {
		position: relative;
		background: none;
		border: none;
		font-size: 1.4rem;
		color: $light;
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
	}
	i.feather {
		color: $secondary;
		vertical-align: middle;

		&--eye {
			
		}
		&--map-pin {
			color: $light;
		}
	}
	&-views {
		text-align: right;
		white-space: nowrap;

		& > * {
			vertical-align: middle;
		}
		i.feather {
			margin-right: .5rem;
		}
	}
	.buttons-control {
		position: relative;
		width: 100%;
		padding-right: 1rem;
		display: flex;
		align-items: center;
		justify-content: space-between;

		.btn {
			width: 100%;

			@include media-breakpoint-down(md) {
				padding-top: 1.2rem;
				padding-bottom: 1.2rem;
			}
		}
	}
}
</style>