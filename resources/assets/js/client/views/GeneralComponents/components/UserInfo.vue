<template lang="pug">
.user-info(v-if='user' :class='cls')
	router-link(class='user-info-ava' :to="{name: 'users.profile', params: {id: user.id}}")
		img(v-if='user.photo' :src='user.photo' alt=' ')
		img(v-else :src="'https://via.placeholder.com/80x80?text='+ user.name.charAt(0)" alt=' ')

	.user-info-data
		h5(v-if='company')
			router-link(:to="{name: 'companies.detail', params: {id: user.id}}") {{company.name}}
		h6
			router-link(:to="{name: 'users.profile', params: {id: user.id}}") {{user.name}}
			
		// UserInfoScore(clsLike)

</template>

<script>
import UserInfoScore from './UserInfoScore'

export default {
	components: {
		UserInfoScore
	},
	props: {
		user: Object,
		company: Object,
		clsLike: String,
		cls: String,
    },
	data() {
		return {

		}
	},
	methods: {},
	mounted () {},
	watch: {},
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base.scss';

.user-info {
	display: flex;
	align-items: center;

	&-ava {
		flex: 0 0 6.6rem;
		width: 6.6rem;
		height: 6.6rem;
		overflow: hidden;
		position: relative;
		margin-right: 1rem;
		border-radius: $border-radius-sm;

		img {
			@include imgAbsCenter();
		}
	}
	&-data {
		color: $text-gray;

		h5 {
			font-size: 1.8rem;
			font-weight: 400;
			margin: 0 0 .5rem;
		}
		h6 {
			font-size: 1.6rem;
			font-weight: 400;
			margin: 0 0 .5rem;
		}
		a:hover,
		a:focus,
		a {
			color: inherit;
			text-decoration: none;
		}
	}
}
</style>