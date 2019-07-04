<template lang="pug">
aside.aside
	slot

</template>

<script>
export default {
	data() {
		return {
			
		}
	},

	computed: {},

	methods: {},

	mounted() {}
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.aside {
	background: $white;
	border: $border-aside;
	border-radius: $border-radius;
	padding: 2.5rem 0;
}
</style>