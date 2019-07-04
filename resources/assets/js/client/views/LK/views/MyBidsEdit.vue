<template lang="pug">
.card.mb-5
	.card-body
		.bid-edit
			NewBidForm(:edit='true' :update='data')
	
</template>

<script>
import NewBidForm from '../../NewDeal/views/NewBidForm'

export default {
	data() {
		return {
			data: {},
		}
	},
	components: {
		NewBidForm,
	},
	methods: {
		getDeal ()
		{
			this.$store.commit('setLoading', true)
			axios.get('/api/v1/deals/' + this.$route.params.id).then((resp) => {
				const bid = resp.data.data
				this.data = {
					id: bid.id,
					name: bid.name,
					description: false,
					city: bid.cities[0].name,
					city_id: bid.cities[0].id,
					images: false,
					date_to: this.dateFormat(bid.deadline_deal),
					price: this.priceFormat(bid.budget_to),
					category: bid.categories[0].name,
					category_id: bid.categories[0].id,
					category_bg: bid.categories[0].cl_background || 'grey',
					category_icon: bid.categories[0].cl_icon,
					type_deal: bid.type_deal,
					owner: {
						user: bid.owner,
						company: bid.organization
					},
				}
				if (bid.description !== 'null') this.data.description = bid.description
				if (bid.imagesDeals.length) this.data.images = bid.imagesDeals

				document.title = bid.name
			}).catch((error) => {
				this.printErrorOnConsole(error)
			}).then(() => {
				this.$store.commit('setLoading', false)
			})
		},
	},
	mounted () {
		this.getDeal()
	}
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

.bid-edit {

}
</style>