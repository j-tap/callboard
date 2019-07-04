<template lang="pug">
.height-gift
	.container
		.d-flex
			div
				p Воспользуйтесь подарочным&nbsp;тарифом
			div
				router-link(
					:to="{name:'lk.tarifs', params:{}}"
					class='btn btn-light btn-sm'
				) 
					span Перейти
					feather(type='gift')

</template>

<script>
export default {
	data() {
		return {}
	},
	methods: {},
	mounted () {},
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.height-gift {
	height: $height-gift-height;
	background: $purple;
	color: $white;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	z-index: 900;
	text-align: center;
	padding: .6rem;

	@include media-breakpoint-down(sm) {
		padding: 1rem;
		height: $height-gift-height-sm;
	}

	.d-flex {
		display: inline-flex;
		justify-content: center;
		align-items: center;
		flex-wrap: nowrap;

		& > * {
			flex: 0 0 auto !important;

			@include media-breakpoint-down(sm) {
				flex: 1 1 auto!important;
			}
		}
	}
	p {
		line-height: 1.1;
		font-style: italic;
		font-size: 1.4rem;

		@include media-breakpoint-down(sm) {
			text-align: left;
		}
	}
	.btn {
		border: none;
		height: 2.8rem;
		line-height: 2.8rem;
		font-family: Arial;
		background: $white;
		margin-left: 1rem;
		font-style: italic;
		padding: 0 1.2rem;
		
		span {
			color: $secondary;
			vertical-align: middle;
		}
		i.feather {
			margin-left: 1rem;
			vertical-align: middle;
			color: $danger;
			width: 1.8rem;
			height: 1.8rem;
		}
	}
}
</style>