<template lang="pug">
.card.profile-card
	.card-body
		.dialogs
			template(v-if='dialogList && dialogList.count > 0')
				router-view
				DialogItem(
					v-for='(dialog, index) in dialogList.items' 
					:dialog='dialog'
					:key='index'
				)
			p(v-else) Диалогов нет

</template>

<script>
import DialogItem from '../components/DialogItem.vue'

export default {
	components: {
		DialogItem,
	},
	data () {
		return {
			dialogList: null,
		}
	},
	methods: {
		getDialogs ()
		{
			this.$parent.loading = true
			axios
			.get('/api/v1/dialogs/')
			.then((resp) => {
				this.dialogList = resp.data.data
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			.then(() => {
				this.$parent.loading = false
			})
		},

	},
	created () {
		this.getDialogs()
	}
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/base.scss';

.row .col-content .card,
.card {
	@include media-breakpoint-down(sm) {
		border: none;
		box-shadow: none;
	}
	&-body {
		@include media-breakpoint-down(sm) {
			
		}
	}
}
.dialogs {

}
</style>
