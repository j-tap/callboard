<template lang="pug">
button.btn.btn-link.btn-favorite(
	v-if='bid && $root.profile && (!bid.owner || $root.profile.profile.id !== bid.owner.id)'
	:class="{active: bid.favourited}" 
	:title="bid.favourited ? 'Удалить из избранного' : 'Добавить в избранное'"
	@click='favoriteClick($event)'
)
	feather(type='star')
	span(v-if='text')
		span(v-if='bid.favourited') Удалить из избранного
		span(v-else) Добавить в избранное

</template>

<script>
export default {
	data() {
		return {}
	},
	props: {
		bid: Object,
		text: String,
	},
	computed: {},
	methods: {
		favoriteClick (evt)
		{
			if (this.bid.favourited) this.del()
			else this.add()
			evt.preventDefault()
		},

		add ()
		{
			axios
			.post('/api/v1/user/favourites/store', {deal_id: this.bid.id})
			.then((resp) => {
				this.bid.favourited = true
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
		del ()
		{
			axios
			.post('/api/v1/user/favourites/delete', {deal_id: this.bid.id})
			.then((resp) => {
				this.bid.favourited = false
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
			})
		},
	},
	mounted () {},
}
</script>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.btn-favorite {
	padding: 0;
	line-height: 0;
}
</style>