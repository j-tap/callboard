<template lang="pug">
.container.my-bids
	.mb-4
		b-tabs(
			v-model='tabInd'
			content-class='mt-4'
			@input="changeTab"
		)
			b-tab(
				title='Активные'
			)
				BidsList(
					v-if='tabInd == 0'
					type='actived'
					@loadingSet='loadingSet'
				)

			b-tab(
				title='На модерации'
			)
				BidsList(
					v-if='tabInd == 1'
					type='moderate'
					@loadingSet='loadingSet'
				)

			b-tab(
				title='Завершённые'
			)
				BidsList(
					v-if='tabInd == 2'
					type='finished'
					@loadingSet='loadingSet'
				)

			b-tab(
				title='Заблокированные'
			)
				BidsList(
					v-if='tabInd == 3'
					type='blocked'
					@loadingSet='loadingSet'
				)

</template>

<script>
import BidsList from '../components/BidsList'
import { setTimeout } from 'timers';

export default {
	components: {
		BidsList,
	},
	data() {
		return {
			tabInd: 0,
			tabs: [
				'actived',
				'moderated',
				'finished',
				'blocked',
			],
		}
	},
	computed: {},
	methods: {
		loadingSet (val)
		{
			this.$parent.loading = val
		},
		changeTab ()
		{
			this.setHash(this.tabs[this.tabInd])
		},
		setHash (hash)
		{
			this.$router.push({ hash })
		},
		init ()
		{
			const name = this.$router.history.current.hash.replace('#', '')
			const ind = this.tabs.indexOf(name)
			setTimeout(() => {
				if (ind >= 0) {
					this.tabInd = ind
				} 
				else {
					this.tabInd = 0
				}
				this.setHash(this.tabs[this.tabInd])
			}, 100)
		},
	},
	mounted () {
		this.init()
	},
}
</script>

<style lang="scss">
@import '../../../../../sass/base.scss';

.my-bids {

}
</style>
