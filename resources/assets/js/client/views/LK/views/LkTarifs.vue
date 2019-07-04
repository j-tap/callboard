<template lang="pug">
.card.profile-card.mb-5
	.card-body
		h3.cabinet-title Тарифы и услуги
			//- span.centralized
				router-link(:to="{name: 'lk.wallet.history'}") История платежей

		Tarifs(
			v-if='profile'
		)

</template>
<script>
import Tarifs from '../../GeneralComponents/tarifs'

export default {
	components: {
		Tarifs,
	},
	props: {
		profile: Object
	},
	data() {
		return {
			loading: false,
		}
	},
	watch: {
		loading (val) {
			this.$parent.loading = val
		}
	},
	methods: {},
	filters: {},
	computed: {},
	mounted () {},
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/base.scss';

</style>
