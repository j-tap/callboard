<template lang="pug">
.scores(v-if='false')
	a.scores-like(href='javascript:void(0)' :class='clsLike')
		span 21
		feather(type='thumbs-up')

	a.scores-reviews(href='javascript:void(0)')
		span 21
		feather(type='message-square')

</template>

<script>
export default {
	props: ['clsLike'],
	data() {
		return {}
	},
	methods: {},
	mounted () {},
	watch: {},
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

.scores {
	display: flex;
	
	a {
		text-decoration: none;
	}
	&-like,
	&-reviews {
		font-size: 1.3rem;
		white-space: nowrap;
		line-height: 1;

		& > * {
			vertical-align: middle;
		}
	}
	&-like {
		color: $success;
	}
	&-reviews {
		color: $text-gray;
		margin-left: 1rem;
	}
	.feather {
		width: 2rem;
		height: 2rem;
		vertical-align: middle;
		margin-left: .5rem;
	}
}
</style>