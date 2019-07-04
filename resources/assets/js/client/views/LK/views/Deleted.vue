<template lang="pug">
div
	ul.row.row-small.list-unstyled(v-if='dealList && dealList.count')
		li.col-xl-4.col-lg-6.col-md-6.mb-5(v-for='(bid, ind) in dealList.items' :key='bid.id')
			BidCardShort(:bid='bid' :index='ind' type='deleted')

	p(v-else) Нет закрытых заявок

	.text-center(v-if='dealList ? !!dealList.hasMore : false')
		b-button(
			variant='outline-primary'
			@click='getMore'
		) Загрузить ещe

</template>

<script>
import BidCardShort from '../../GeneralComponents/components/BidCardShort'

export default {
	components: {
		BidCardShort,
	},
	data() {
		return {
			dealList: null,
			nextPage: 2,
		}
	},
	methods: {
		load ()
		{
			this.$parent.loading = true
			axios.get('/api/v1/deals/user/list/?status=archive&finish=1').then((resp) => {
				this.dealList = resp.data.data
				this.$parent.loading = false
			}).catch((error) => {
				this.$parent.loading = false
			})
		},
		getMore () 
		{
			this.$parent.loading = true
			axios.get('/api/v1/deals/user/list??finish=1&user_id='+ this.$root.profile.profile.id +'&page=' + this.nextPage).then((resp) => {
				this.dealList.items = this.dealList.items.concat(resp.data.data.items)
				this.dealList.hasMore = resp.data.data.hasMore
				this.$parent.loading = false
				this.nextPage++;
			}).catch((error) => {
				this.$parent.loading = false
			})
		},
	},
	mounted () {
		this.load()
	},
}
</script>

<style lang="scss">

</style>
