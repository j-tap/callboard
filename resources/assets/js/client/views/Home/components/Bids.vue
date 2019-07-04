<template lang="pug">
.content.content-home
	.container
		ul.row.row-small.list-unstyled
			//- - for (var i = 0; i < 8; ++i)
			li.col-xl-3.col-lg-3.col-md-4.col-sm-6.mb-5(v-for='bid in bids')
				//- pre {{bid}}
				BidCardShort(:bid='bid')

		p(v-if='!bids.length') Заявки ещё не добавлены

</template>

<script>
import BidCardShort from '../../GeneralComponents/components/BidCardShort'

export default {
	components: {
		BidCardShort,
	},
	data() {
		return {
			bids: [],
		}
	},
	methods: {
		loadDeal ()
		{
			this.$store.commit('setLoading', true)
			axios
			.get('/api/v1/deals/list?type_deal=sell').then((resp) => {
				this.bids = resp.data.data.items.reverse()
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			s.then(() => {
				this.$store.commit('setLoading', false)
			})
		},

		dateFormat (string)
		{
			return string.split("-").reverse().join().replace(/,/g, ".");
		},
	},
	created () 
	{
		this.loadDeal();
	},
}
</script>

<style lang="scss">

</style>