<template lang="pug">
section.container
	.row(v-if='$root.profile')
		.col-lg-3.d-none.d-lg-block
			Aside
				LkNavigation

		.col-md-12.col-lg-9
			.new-bid-form.card.mb-5
				.card-body
					NewBidForm

</template>

<script>
import Aside from '../GeneralComponents/components/Aside'
import LkNavigation from '../LK/components/LkNavigation'
import NewBidForm from './views/NewBidForm'

export default {
	name: 'NewBid',
	components: {
		NewBidForm,
		Aside,
    	LkNavigation,
	},
	data() {
		return {
			
		}
	},
	methods: {},
	mounted () {},
};
</script>

<style scoped lang="scss">
@import '../../../../sass/base.scss';

.new-bid-form {
	// margin: 0;
	// border-radius: $border-radius;
	// box-shadow: $box-shadow;
	// background: $white;
	// padding: 2.5rem 3.5rem;

	@include media-breakpoint-up(lg) {
		max-width: 70rem;
	}
	@include media-breakpoint-down(sm) {
		padding: 0;
		border: none;
		box-shadow: none;
	}
	
	.card-body {
		@include media-breakpoint-down(sm) {
			padding: 0;
		}
	}
}
</style>
