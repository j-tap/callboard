<template lang="pug">
.my-bids-list
	.my-bids-list__filter
		b-btn(
			:class="{'active': isBuy}"
			@click.stop="toggle('buy')"
			size='sm'
			variant='outline-primary'
		) Покупка
		b-btn(
			:class="{'active': isSell}"
			@click.stop="toggle('sell')"
			size='sm'
			variant='outline-primary'
		) Продажа

	ul.row.row-small.list-unstyled(v-if="list.length")
		li.col-md-6.mb-4(
			v-for='(bid, ind) in list' 
			:key='bid.id'
		)
			BidCardShort(
				:bid='bid'
				:index='ind'
				type='edit'
			)

	p(v-else) Ничего не найдено

	.text-center.mb-5(v-if='dealList ? !!list.hasMore : false')
		b-button(
			variant='outline-primary'
			@click='getMore()'
		) 
			span(v-if='isLoadingMore') Загрузка...
			span(v-else) Загрузить ещe

</template>

<script>
import BidCardShort from '../../GeneralComponents/components/BidCardShort'

export default {
	components: {
		BidCardShort,
	},
	props: {
		type: String,
	},
	data () {
		return{
			dealList: null,
			nextPage: 2,
			isBuy: true,
			isSell: false,
			typeDeal: 'buy',
		}
	},
	computed: {
		requestLink () 
		{
			let link = ''
			switch (this.type) {
				case 'active': break
				case 'moderate':
					link = 'status=moderation'
					break
				case 'finished':
					link = 'status=archive&finish=1'
					break
				case 'blocked':
					link = 'status=banned&finish=1'
					break
			}
			return link 
		},
		list ()
		{
			if (this.dealList) {
				return this.dealList.items.filter(item => item.type_deal === this.typeDeal)
			}
			return []
		}
	},
	methods: {
		load ()
		{
			this.$emit('loadingSet', true)
			axios
			.get('/api/v1/deals/user/list?page=1&'+ this.requestLink)
			.then((resp) => {
				this.dealList = resp.data.data
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			.then(() => {
				this.$emit('loadingSet', false)
			})
		},
		getMore() 
		{
			this.$emit('loadingSet', true)
			axios.get('/api/v1/deals/user/list?page=' + this.nextPage +'&'+ this.requestLink)
			.then((resp) => {
				this.dealList.items = this.dealList.items.concat(resp.data.data.items)
				this.dealList.hasMore = resp.data.data.hasMore
				this.nextPage++;
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
			.then(() => {
				this.$emit('loadingSet', false)
			})
		},
		removeFromList (index)
		{
			this.dealList.count = this.dealList.count--
			this.dealList.items.splice(index, 1)
		},
		toggle (type)
		{
			this.typeDeal = type
			switch (type) {
				case 'buy':
					this.isBuy = true
					this.isSell = false
					break
				case 'sell':
					this.isBuy = false
					this.isSell = true
					break
			}
		},
	},
	mounted () {
		this.load()
	},
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/base.scss';

.my-bids-list {
	&__filter {
		margin-bottom: 1.5rem;

		.btn {
			padding-left: 2.5rem;
			padding-right: 2.5rem;
			border-color: $gray;
			color: $gray;
			background: $white;

			&.active {
				background: $white;
				border-color: $primary;
				color: $primary;
			}

			& + .btn {
				margin-left: 1.5rem;
			}
		}
	}
}
</style>