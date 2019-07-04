<template lang="pug">
router-link(:to="{name: 'companies.detail', params: {id: company.owner_id}}" class='card company-card-short')
	.card-img-wrap
		.card-img-head
			span(:class=`'tile float-right ' + (company.categories[0].cl_background)` :title='company.categories[0].name')
				component(:is='company.categories[0].cl_icon')

		img(
			v-if='company.organization.media.image_1'
			:src='company.organization.media.image_1' 
			alt=' '
		)
		img(
			v-else
			src='https://via.placeholder.com/320x240?text=Без+фото' 
			alt=' '
		)

	.card-body
		h5.card-title 
			span {{company.organization.name}} 
			span(v-if='company.count_views' title='Просмотры')
				feather(type='eye' class='text-secondary')
				span.align-middle.ml-1 0

		.mb-3
			.company-city
				span.text-small.mr-1 {{company.city.name}}
				feather(type='map-pin')
		
		.company-descr(v-if='company.organization.products')
			p {{company.organization.products}}

</template>

<script>
export default {
	data() {
		return {}
	},
	props: {
		company: Object,
	},
	computed: {},
	methods: {},
	mounted () {},
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

.company-card-short {
	text-decoration: none;
	color: inherit;
	overflow: hidden;
	transition: $transition-card;
	box-shadow: $box-shadow;
	min-height: 29rem;

	@include hover-focus {
		box-shadow: $box-shadow-fx;
		transform: translateY(-.2rem);
		height: auto;

		.company-descr {
			height: 17rem;
		}
	}

	.card-img-wrap {
		overflow: hidden;
		position: relative;
		height: 15rem;

		img {
			@include imgAbsCenter()
		}

		.card-img-foot,
		.card-img-head {
			position: absolute;
			z-index: 2;
			left: 0;
			padding: 1rem;
			width: 100%;
		}
		.card-img-head {
			top: 0;
		}
	}

	& > a {
		color: inherit;
		text-decoration: none;
	}

	.tile {
		margin: 0;
	}
	.card-title {
		color: $body-color;
		font-weight: 500;
		font-size: 1.6rem;


	}
	.feather {
		vertical-align: middle;

		&--eye {
			width: 2rem;
			height: 2rem;
		}
		&--map-pin {
			width: 1.6rem;
			height: 1.6rem;
		}
	}
	.company-city {
		color: $text-gray;
		font-size: 1.3rem;
	}
	.company-descr {
		color: $text-gray;
		font-size: 1.4rem;
		line-height: 1.23;
		overflow: hidden;
		height: 5.3rem;
		transition: height .3s ease;
	}
}
</style>