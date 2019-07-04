<template lang="pug">
.container
	ul.breadcrumb
		li.breadcrumb-item
			router-link(:to="{name: 'home'}") Главная
		li.breadcrumb-item(v-for='(item, ind) in breadcrumbs' :class=`{'active': item.name === $route.name}`)
			span(v-if='item.name === $route.name') {{item.title}}
			router-link(v-else :to="{name: item.name}") {{item.title}}

</template>

<script>
export default {
	data() {
		return {
			breadcrumbs: null,
		}
	},
	computed: {},
	methods: {
		set ()
		{
			this.breadcrumbs = []
			this.$route.matched.map(item => {
				let path = item.path.length > 0 ? item.path : '/'
				let route = item
				Object.keys(this.$route.params).forEach(param => {
					path = path.replace(':' + param, this.$route.params[param])
				}, this)
				route.path = path
				if (route.meta.title && route.meta.breadcrumb !== false) {
					if (route.redirect) route.name = route.redirect
					this.breadcrumbs.push({name: route.name, title: route.meta.title})
				}
			})
		},
	},
	watch: {
		'$route' ()
		{
			this.set()
		},
	},
	mounted () {
		this.set()
	},
}
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

.breadcrumb {
	margin: 0 0 1rem;
	padding: 0;
	background: transparent;

	&-item {
		font-size: 1.2rem;
		color: $color-title;

		a {
			color: $primary;
		}
	}
}
</style>