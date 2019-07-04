<template lang="pug">
.budget(
	v-if='from || to'
)
	template(
		v-if="type == 'buy'"
	)
		template(v-if="from && to")
			span {{priceFormat(from)}}
			span &nbsp;&ndash;&nbsp;
			span {{priceFormat(to)}}
			span.budget-rubl &nbsp;&#8381;

		template(v-else)
			template(v-if="to")
				span До&nbsp;
				span {{priceFormat(to)}}
				span.budget-rubl &nbsp;&#8381;

	template(v-else)
		span {{priceFormat(to)}}
		span.budget-rubl &nbsp;&#8381;
			
</template>

<script>
export default {
	components: {},
	data() {
		return {}
	},
	props: {
		type: String,
		from: Number,
		to: Number,
	},
	computed: {},
	methods: {},
	mounted () {}
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

.budget {
	white-space: nowrap;

	&-rubl {

	}
}
</style>