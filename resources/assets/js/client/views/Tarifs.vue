<template lang="pug">
section.container.content-tarifs
	.col-md-12.col-lg-9.col-content.position-relative
		.card.profile-card.mb-5
			.card-body
				h3.cabinet-title Тарифы и услуги
				Tarifs

			Loader(v-show='this.loading')
		
</template>
<script>
import Tarifs from './GeneralComponents/tarifs'

export default {
	components: {
		Tarifs,
	},
	data() {
		return {
			loading: false, 
		}
	},
	// если пользователь авторизован - сразу перенаправляем его на страницу тарифов в ЛК
	beforeRouteEnter(to, from, next) {
		next(vm => {
			if (vm.$root.profile != null) {
				next({ name: 'lk.tarifs' })
			}
		});
	},
	methods: {},
};
</script>
<style lang="scss" scoped>
@import "../../../sass/base.scss";

.content-tarifs {
  display: flex;
  justify-content: center;
}
</style>
