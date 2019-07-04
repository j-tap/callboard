<template lang="pug">
section.bid-detail.container(v-if='data.id')
	.row
		.col-md-7
			.bid-detail-title 
				Goback(:cls="$route.name.replace('.','-')")
				h1 {{data.name}}
			//- span
				span(
					:class="'tile float-right ' + (data.categories[0].cl_background)"
					:title='data.categories[0].name'
				)
					component(:is='data.categories[0].cl_icon')
			.row
				.col-md-7.d-none.d-md-block
					.bid-detail-image-big
						.bid-detail-image-inner(
							v-if='imgSelected.id'
							v-b-modal="'modal-photos'"
						)
							img(:src='imgSelected.path' alt=' ')

						.bid-detail-image-inner(v-else)
							img(:src='imgSelected.path' alt=' ')

				.col-md-5
					.bid-detail-price(v-if='data.budget_to != 0') 
						b {{priceFormat(data.budget_to)}}
						|&nbsp;&#8381;

					
					.row.align-items-end
						.col-6.col-md-12
							.bid-detail-mute-info
								//- .bid-detail-id(v-if='isMy')  |id заявки  b {{data.id}}
								.bid-detail-date-create
									|Добавлена {{dateFormat(data.date_create.date).toLowerCase()}}

								.bid-detail-date-deadline(v-if='data.deadline_deal && dateFormat(data.deadline_deal)')
									|Срок действия до {{dateFormat(data.deadline_deal).toLowerCase()}}

						.col-6.d-block.d-md-none
							.text-light.text-right
								span(v-if='data.count_views' title='Просмотры')
									feather(type='eye')
									span.align-middle.ml-1 {{data.count_views}}

					.d-block.d-md-none
						.bid-detail-image-big
							.bid-detail-image-inner(
								v-if='imgSelected.id'
								v-b-modal="'modal-photos'"
							)
								img(:src='imgSelected.path' alt=' ')

							.bid-detail-image-inner(v-else)
								img(:src='imgSelected.path' alt=' ')

					//- .bid-detail-btn-respond
						b-button(
							v-if="isNotMy && data.type_deal == 'buy'"
							class=''
							variant='danger'
							size='lg'
						) Отклик

			.bid-detail-footer
				Favorite(:bid='data' text='Добавить в избранное')

				//- a(href='javascript:void(0)')
					feather(type='link')
					span Поделиться
				
				.text-light.d-none.d-md-block
					span(v-if='data.count_views' title='Просмотры')
						feather(type='eye')
						span.align-middle.ml-1 {{data.count_views}}

			.bid-detail-description(
				v-if="data.description && data.description != 'undefined'"
			) {{data.description}}

		.col-md-5
			.card.user-company-card
				.card-body
					template(v-if='isContactVisible')
						template(v-if='data.organization')
							h3.bid-detail-company-name(
								v-if="data.organization.name && data.organization.name != 'null'"
							)
								div
									.text-break {{data.organization.name}}
								router-link(
									:to="{name: 'companies.detail', params: {id: data.owner.id}}"
								) Подробнее о&nbsp;компании

							.bid-detail-company-description(
								v-if='data.organization.org_products'
							) {{data.organization.org_products}}

						template(v-if='data.owner')
							.bid-detail-company-details
								dl(v-if='this.$root.profile')
									dt Email:
									dd
										a(:href=`'mailto:'+ data.owner.email`) {{data.owner.email}}
								
								dl(v-if='this.$root.profile')
									dt(v-if='data.owner.phone') Телефон:
									dd(v-if='data.owner.phone') 
										a(:href=`'tel:+7'+ data.owner.phone`) {{phoneFormat(data.owner.phone)}}
								//- dl(v-if='this.$root.profile')
									dt Соц сети:
									dd 
										ul.list-unstyled.d-flex
											li
												a.p-1(href='#' targget='_blank') vk
											li
												a.p-1(href='#' targget='_blank') ok
											li
												a.p-1(href='#' targget='_blank') fb
								//- dl(v-if='this.$root.profile')
									dt Сайт:
									dd 
										a(href='#' targget='_blank') mail.ru
							
						.row.align-items-center.mb-4
							.col-sm-7.col-md-12.col-xl-7
								UserInfo(
									:user='data.owner' 
									:clsLike='clsLike'
								)
							
							.col-sm-5.col-md-12.col-xl-5
								b-button(
									v-if='isNotMy'
									class='bid-detail-msg-write'
									size='lg' 
									variant='outline-primary'
									block
									@click='messageWrite()'
								) Написать

						ul.bid-detail-link-list
							li
								a(href='javascript:void(0)' v-if='isNotMy' @click='goToProductsOwner($event)')
									feather(type='grid')
									span Все продукты продавца
							//- li
								a(href='javascript:void(0)' v-if='isNotMy')
									feather(type='pocket')
									span Подписаться на продавца

					//- Response(
					//- 	v-if='!isContactVisible'
					//- 	:cost='cost'
					//- )
					RequestContacts(
						v-if='!isContactVisible'
						:cost='cost'
					)

	.mb-5
		.bid-detail-map-before
			a(
				href='javascript:void(0)'
				class='bid-detail-show-map'
				v-b-toggle="'collapseMap'"
			)
				feather(type='map-pin')
				b {{data.cities[0].name}}
				feather(type='chevron-down')

		b-collapse(
			@show='showMap'
			id='collapseMap' 
			class='mb-4'
		)
			#map.map

	section.related-bids(v-if='relatedBids.items && relatedBids.items.length')
		h2 Похожие заявки
		ul.row.row-small.list-unstyled
			li.col-xl-3.col-lg-4.col-sm-6.mb-5(v-for='bid in relatedBids.items')
				BidCardShort(:bid='bid')
				
	b-modal(
		modal-class='modal-photos'
		ref='modalPhotos'
		id='modal-photos'
		size='xl'
		:hide-footer='true'
		:hide-header='true'
	)
		.carousel-photos-head
			.carousel-photos-close(@click='$refs.modalPhotos.hide()')
				.d-none.d-md-inline Esc
			.carousel-photos-tite {{data.name}}
		b-carousel(
			ref='carouselPhotos'
			:class="(data.imagesDeals.length > 1) ? 'carousel-photos' : 'carousel-photos carousel-photos--no-arrows'"
			id='carousel-photos'
			controls
			label-prev='назад'
			label-next='вперёд'
			:interval='0'
			@sliding-start='slideChange'
		)
			b-carousel-slide(
				v-for='img in data.imagesDeals'
				:key='img.id'
			)
				img(
					slot='img'
					:src='img.path'
					alt=' '
				)
		ul.carousel-photos-thumbs(
			v-if='data.imagesDeals.length > 1'
			ref='thumbs'
		)
			li(
				v-for='(img, ind) in data.imagesDeals'
				:key='img.id'
				:class="{active: (ind == 0)}"
				@click='$refs.carouselPhotos.index = ind'
			)
				img(:src='img.path' alt=' ')
			

</template>

<script>
import Goback from '../../GeneralComponents/components/Goback'
import UserInfo from '../../GeneralComponents/components/UserInfo'
import Favorite from '../../GeneralComponents/components/Favorite'
import BidCardShort from '../../GeneralComponents/components/BidCardShort'
import RequestContacts from '../../GeneralComponents/components/RequestContacts'
// import Response from '../../GeneralComponents/components/Response'

export default {
	components: {
		Goback,
		UserInfo,
		Favorite,
		BidCardShort,
		RequestContacts,
		// Response,
	},
	data() {
		return {
			data: {},
			imgSelected: null,
			map: null,
			relatedBids: [],
			cost: 0,
			isPro: null
		}
	},
	computed: {
		clsLike () 
		{
			return 'text-success' //if (this.data.owner) 
		},
		isMy ()
		{
			return (this.$root.profile && this.data.owner.id === this.$root.profile.profile.id)
		},
		isNotMy ()
		{
			return (!this.data.owner || this.$root.profile && this.$root.profile.profile.id !== this.data.owner.id)
		},
		isContactVisible ()
		{
			return (this.data.owner || this.data.organization)
		},
	},
	methods: {
		setImgSelected (img)
		{
			if (img && img.path) this.imgSelected = img
			else this.imgSelected = {id: null, path: '/images/no-photo.svg'}
		},
		slideChange (ind)
		{
			this.$refs.thumbs.querySelectorAll('.active').forEach((item) => {
				item.classList.remove('active')
			})
			this.$refs.thumbs.childNodes[ind].classList.add('active')
		},
		getDeal ()
		{
			this.$store.commit('setLoading', true)
			axios.get('/api/v1/deals/' + this.$route.params.id)
			.then((resp) => {
				this.data = resp.data.data
				this.setTitle(this.data.name)
				this.setImgSelected(this.data.imagesDeals[0])
				this.loadRelatedBids()
				if (this.isNotMy && this.$root.profile){
					this.getpaymentInfo()
				}
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				this.$router.replace({ name: 'page404' })
			})
			.then(() => {
				this.$store.commit('setLoading', false)
			})
		},
		messageWrite () 
		{
			axios.post('/api/v1/dialogs/new', {deal_id: this.data.id})
			.then((resp) => {
				if (resp.data.result) {
					this.$router.push({name: 'lk.dialogs.private', params: {id: resp.data.data.id}})
				}
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
		showMap ()
		{
			this.initMap()
		},
		initMap ()
		{
			if (typeof ymaps === 'undefined') return
			ymaps.ready(() => {
				if (this.map) this.map.destroy()
				
				this.map = new ymaps.Map('map', {
					center: ['62.0', '100.0'],
					zoom: 4,
					controls: ['zoomControl'],
				})

				this.map.behaviors.disable('scrollZoom')

				ymaps.geocode(this.data.cities[0].name, {
					results: 1
				})
				.then((res) => {
					let firstGeoObject = res.geoObjects.get(0) || res.geoObjects
					firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption')
					this.map.geoObjects.add(firstGeoObject)
					this.map.setBounds(firstGeoObject.properties.get('boundedBy'), {
						checkZoomRange: true
					})
				})
			})
		},
		loadRelatedBids ()
		{
			if (this.data.categories.length) {
				this.$store.commit('setLoading', true)
				axios.get('/api/v1/filter/deals', {params: {
					'cities[]': this.data.cities[0].id,
					'categories[]': this.data.categories[0].id,
					'type_deal': this.data.type_deal,
				}})
				.then((resp) => {
					this.relatedBids = resp.data.data.items.filter((item) => {
						return item.id != this.data.id
					})
				})
				.catch((error) => {
					this.printErrorOnConsole(error)
				})
				.then(() => {
					this.$store.commit('setLoading', false)
				})
			} else {
				this.printErrorOnConsole('Category is not found', 'warning')
			}
		},
		goToProductsOwner (evt)
		{
			this.$router.push({
				name: 'bids.list', 
				query: {
					user_id: this.data.owner.id
				}
			})
			evt.preventDefault()
			return false
		},
		getpaymentInfo(){
			let url = ' /api/v1/paymentservice/payment_once_deal_buy_get_contacts'
			axios.get(url).then(resp=>{
				if (resp.data.result){
					this.cost = resp.data.data.cost_of_service;
					this.isPro = resp.data.data.is_pro_account;
				}
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
	},
	watch: {
		'$route.query' () 
		{
			this.data = {}
			this.getDeal()
		},
	},
	mounted () {
		this.getDeal()
	},
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';
@import '~bootstrap/scss/carousel';

.bid-detail {
	position: relative;
	
	.card {
		box-shadow: $box-shadow;
		margin-top: 1rem;
	}
	i.feather {
		vertical-align: middle;
		width: 2.5rem;
		height: 2.5rem;

		&--map-pin {
			width: 1.6rem;
			height: 1.6rem;
		}
		&--eye {
			@include media-breakpoint-down(sm) {
				width: 1.7rem;
				height: 1.7rem;
			}
		}
	}
	&-image-big {
		border: $input-border-width solid $border-color;
		border-radius: $border-radius;
		margin-bottom: 1.2rem;
	}
	&-image-inner {
		position: relative;
		overflow: hidden;
		height: 21rem;
		line-height: 21rem;
		font-size: 0;
		text-align: center;

		img {
			@include imgCenter();

			&[src*='no-photo.svg'] {
				max-width: 7rem;
			}
		}
	}
	&-title {
		margin-bottom: 1rem;
		position: relative;

		.goback {
			@include media-breakpoint-down(xxl) {
				position: relative;
				left: 0;
				float: left;
				margin-right: 1.5rem;
			}
		}
		h1 {
			margin: 0;
			font-size: 2.5rem;
			font-weight: 500;
			color: $black;

			@include media-breakpoint-down(xxl) {
			
			}
			@include media-breakpoint-down(sm) {
				font-size: 1.4rem;
			}
		}
		&::after {
			content: '';
			display: block;
			clear: both;
		}
	}
	&-price {
		font-weight: 700;
		white-space: nowrap;
		font-size: 3.4rem;
		margin: 1.5rem 0 2rem;

		@include media-breakpoint-down(sm) {
			margin-top: 0;
			margin-bottom: 1rem;
			line-height: 1;
		}

		b {
			font-weight: 500;
		}
	}
	&-mute-info {
		color: $text-gray;
		font-size: 1.5rem;

		@include media-breakpoint-down(sm) {
			font-size: 1.4rem;
		}

		& > * {
			display: block;
			margin-bottom: 1.5rem;
			font-size: inherit;
			color: $gray;

			@include media-breakpoint-down(sm) {
				margin-bottom: 1rem;
			}
		}
	}
	&-date-create {
		
	}
	&-date-deadline {

	}
	&-id {
		text-align: right;
		color: $border-color;

		b {
			color: $text-gray;
			font-weight: 400;
		}
	}
	&-msg-write {
		display: block;
		width: 100%;
		font-size: 1.8rem;
		height: 5rem;
		line-height: 5rem;
		padding: 0 3rem;
	}
	&-btn-respond {
		margin-top: 3rem;

		@include media-breakpoint-down(md) {
			position: fixed;
			z-index: 4;
			bottom: 3rem;
			left: 0;
			width: 100%;
			padding: 0 calc(#{$grid-gutter-width} / 2);
			text-align: center;
		}
		.btn {
			display: block;
			width: 100%;
			font-size: 1.8rem;
			height: 5rem;
			line-height: 5rem;
			padding: 0 3rem;

			@include media-breakpoint-down(md) {
				width: auto;
				display: inline-block;
			}
			@include media-breakpoint-down(sm) {
				width: 100%;
			}
		}
	}
	.btn-favorite {
		color: $secondary;
	}
	&-footer {
		display: flex;
		justify-content: flex-start;
		color: $text-gray;
		font-size: 1.4rem;
		padding-bottom: .7rem;
		border-bottom: .1rem dotted $gray;
		margin: 2rem 0;

		@include media-breakpoint-down(sm) {
			margin-bottom: 1rem;
		}

		a {
			color: inherit;
			text-decoration: none;
			transition: color .2s ease;

			&:hover,
			&:focus {
				color: $primary;
			}
		}
		& > * {
			white-space: nowrap;
			font-size: inherit;

			&:last-child {
				align-self: flex-end;
				text-align: right;
				flex-basis: 0;
				flex-grow: 1;
			}
			&:not(:first-child) {
				margin-left: 2rem;
			}
			i.feather {
				margin-right: .5rem;

				@include media-breakpoint-down(sm) {
					width: 1.7rem;
					height: 1.7rem;
				}
			}
		}
	}
	&-description {
		font-size: 16px;
		color: $body-color;
		margin-bottom: 2rem;
		padding-bottom: .7rem;
		border-bottom: .1rem dotted $gray;
	}
	&-company-name {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 1.4rem;
		width: 100%;
		margin-bottom: 1.5rem;

		div {
			color: $body-color;
			font-weight: 500;
			font-size: 2rem;
			padding-right: 1rem;
		}
		a {
			font-weight: 400;
			text-align: right;
		}
	}
	&-company-description {
		margin-bottom: 2rem;
		padding-bottom: .7rem;
		border-bottom: .1rem dotted $gray;
		font-size: 14px;
		color: $body-color;
	}
	.user-company-card {
		@include media-breakpoint-down(md) {
			margin-bottom: 1.5rem;
		}
	}
	&-company-details {
		color: $text-gray;
		font-size: 1.4rem;
		margin: 0 -1rem 2rem;
		padding-bottom: .7rem;
		border-bottom: .1rem dotted $gray;
		display: flex;

		dl {
			margin: 0;
			padding: 0;
			max-width: 33.33%;
			margin: 0 1rem;

			@include media-breakpoint-down(md) {
				max-width: 50%;
			}
			@include media-breakpoint-down(sm) {
				max-width: 100%;
			}
		
			dt {
				font-weight: 500;
			}
			dd {
				margin-bottom: 1.5rem;

				a {
					color: inherit;
					text-decoration: underline;
					transition: color .2s ease;

					&:hover,
					&:focus {
						color: $primary;
					}
				}
			}
		}
	}
	.user-info {
		margin-bottom: 1.5rem;

		@include media-breakpoint-up(sm) {
			margin-bottom: 0;
		}
		@include media-breakpoint-up(md) {
			margin-bottom: 1.5rem;
		}
		@include media-breakpoint-up(xl) {
			margin-bottom: 0;
		}
	}
	&-link-list {
		margin: 0 -1rem 0;
		padding: 0;
		color: $text-gray;
		list-style: none;
		display: flex;

		@include media-breakpoint-down(sm) {
			display: block;
		}

		li {
			max-width: 50%;
			margin: 0 1rem 1.5rem;

			@include media-breakpoint-down(sm) {
				max-width: 100%;
				width: 100%;
			}

			a {
				color: inherit;
				text-decoration: none;
				transition: color .2s ease;

				&:hover,
				&:focus {
					color: $primary;
				}
				span {
					font-size: 1.2rem;
				}
				.feather {
					margin-right: .5rem;
				}
			}
		}
	}
	&-map-before {
		position: relative;
		padding-bottom: .5rem;
		color: $text-gray;
		border-bottom: .1rem solid $gray;
		line-height: 1;

		a {
			color: inherit;

			b {
				font-size: 15px;
				font-weight: 500;
				color: $body-color;
				padding: 0 1rem;
			}
		}
	}
	&-show-map {
		text-decoration: none;

		&:hover,
		&:focus {
			text-decoration: none;
		}
	}
	.map#map {
		height: 25rem;
		
		@include media-breakpoint-down(sm) {
			margin-left: calc(#{$grid-gutter-width} / -2);
			margin-right: calc(#{$grid-gutter-width} / -2);
		}
	}
	.modal-photos {
		.modal-body {
			padding: 0;
		}
	}
}
.related-bids {
	h2 {
		color: $secondary;
		font-size: 1.4rem;
		font-weight: 400;
		line-height: 1;
		margin: 0 0 2.5rem;
		padding: 0 0 1.2rem;
		border-bottom: .1rem solid $gray;
	}
}

.modal-photos {
	.modal-dialog {
		margin-top: 8rem;

		@include media-breakpoint-down(sm) {
			margin-top: 1.5rem;
		}
	}
	.modal-content {
		background: none;
		border: none;
		border-radius: 0;
	}
	.modal-backdrop.show {
		opacity: 0.85;
	}
}
.carousel-photos {
	&--no-arrows {
		.carousel-control-prev,
		.carousel-control-next {
			display: none;
		}
	}
	.carousel-item {
		text-align: center;
		height: 54rem;
		max-height: 60vh;

		@include media-breakpoint-down(md) {
			height: 36rem;
		}
		@include media-breakpoint-down(sm) {
			height: 25rem;
		}

		img {
			max-height: 100%;
			max-width: 100%;
			width: auto;
		}
	}
	.carousel-control-prev {
		justify-content: flex-start;
		left: -3rem;

		@include media-breakpoint-up(xxl) {
			left: -5rem;
		}
		@include media-breakpoint-down(sm) {
			display: none;
		}

		&-icon {
			display: block;
			position: relative;
			background: none;
			width: 2.8rem;
			height: 2.8rem;
			transform: rotateZ(45deg);

			&::before {
				content: '';
				display: block;
				position: absolute;
				top: 0;
				left: 0;
				height: 2.8rem;
				width: .2rem;
				background: $white;
			}
			&::after {
				content: '';
				display: block;
				position: absolute;
				bottom: 0;
				left: 0;
				width: 2.8rem;
				height: .2rem;
				background: $white;
			}
		}
	}
	.carousel-control-next {
		justify-content: flex-end;
		right: -3rem;

		@include media-breakpoint-up(xxl) {
			right: -5rem;
		}
		@include media-breakpoint-down(sm) {
			display: none;
		}

		&-icon {
			display: block;
			position: relative;
			background: none;
			width: 2.8rem;
			height: 2.8rem;
			transform: rotateZ(-45deg);

			&::before {
				content: '';
				display: block;
				position: absolute;
				top: 0;
				right: 0;
				height: 2.8rem;
				width: .2rem;
				background: $white;
			}
			&::after {
				content: '';
				display: block;
				position: absolute;
				bottom: 0;
				right: 0;
				width: 2.8rem;
				height: .2rem;
				background: $white;
			}
		}
	}
}
.carousel-photos-head {
	position: relative;
	margin: 0 0 1rem;
	line-height: 1;

	&::after {
		content: '';
		display: block;
		clear: both;
	}
}
.carousel-photos-close {
	position: absolute;
	left: 0;
	top: 0;
	height: 3rem;
	padding-left: 4rem;
	float: left;
	margin-right: 1.5rem;
	margin-left: 1rem;
	font-size: 2.6rem;
	color: $white;
	font-weight: 200;
	line-height: 3rem;
	cursor: pointer;

	@include media-breakpoint-down(sm) {
		float: right;
		margin-left: 1.5rem;
		margin-right: 0;
	}

	&::before,
	&::after {
		content: '';
		position: absolute;
		left: 1.5rem;
		height: 100%;
		width: .1rem;
		background: $white;
	}
	&::before {
		transform: rotate(45deg);
	}
	&::after {
		transform: rotate(-45deg);
	}
}
.carousel-photos-tite {
	color: $white;
	text-align: center;
	font-size: 2rem;
	font-weight: 500;
}
.carousel-photos-thumbs {
	font-size: 0;
	margin: 1rem -.5rem 0;
	text-align: center;

	li {
		position: relative;
		overflow: hidden;
		display: inline-block;
		vertical-align: top;
		margin: 0 .5rem;
		width: 6rem;
		height: 6rem;

		&::after {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			border: .2rem solid $white;
			opacity: 0;
			transition: opacity .2s ease;
		}
		&.active {
			&::after {
				opacity: 1;
			}
		}

		img {
			@include imgAbsCenter();
			backface-visibility: hidden;
		}
	}
}
</style>