<template lang="pug">
router-link(
	v-if='dialog'
	:class="{'dialog-item-unread': dialog.count_unreaded_messages > 0, 'dialog-item': true}"
	:to="{name:'lk.dialogs.private', params: {id: dialog.id}}"
)
	.dialog-item-ava
		img(v-if='dialog.user.photo' :src='dialog.user.photo' alt=' ')
		img(v-else src='https://via.placeholder.com/80x80?text=Нет+фото' alt=' ')

	.dialog-item-info
		.dialog-item-date {{dateTimeformat(dateTimezone(dialog.last_message_date))}}
		.dialog-item-title {{dialog.user.name}} - {{dialog.deal.name}}
		.dialog-item-msg
			p.text-break {{dialog.last_message}}

	// button.button.flex-box.f-align-center.f-content-center(@click="deleteDialog") Удалить диалог
	// router-link(
	// 	:to="{name:'lk.dialogs.complaint', params: {id: dialog.organization.id, data: dialog}}" 
	// 	class="button flex-box f-align-center f-content-center"
	// ) Пожаловаться

</template>

<script>
export default {
	props: ['dialog'],
	data () {
		return{

		}
	},
	methods:{
		dateTimezone (d)
		{
			if (d) {
				let date = new Date(d.date);
				date.setHours(date.getHours() + d.timezone_type);
				return date
			}
			return null
		},
		deleteDialog ()
		{
			axios.delete('/api/v1/dialogs/'+ this.dialog.id)
			.then((resp) => {
				this.$store.commit('setSnackbar', {color: 'success', text: 'Диалог успешно удален', toggle: true})
				this.$router.push({name:'lk.dialogs'})
			})
			.catch((error) => {
				this.$store.commit('setSnackbar', {color: 'error', text: 'Ошибка', toggle: true})
			})
		},
	},
	mounted () {}
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/base.scss';

.dialog-item {
	color: inherit;
	text-decoration: none;
	display: flex;
	align-items: center;

	&:first-child {
		.dialog-item-info {
			border-top: .2rem dotted $gray;
		}
	}
	
	&-unread {
		.dialog-item-info {
			background: $light-gray;
		}
		.dialog-item-msg {
			color: $body-color;
		}
	}

	&-ava {
		width: 6rem;
		height: 6rem;
		overflow: hidden;
		position: relative;
		border-radius: $border-radius-sm;

		@include media-breakpoint-down(sm) {
			width: 4.8rem;
			height: 4.8rem;
		}

		img {
			@include imgAbsCenter();
		}
	}
	&-info {
		font-size: 1.8rem;
		font-weight: 400;
		padding: 1rem 1rem 1rem .5rem;
		margin-left: 1rem;
		flex: 1;
		line-height: 1;
		border-bottom: .2rem dotted $gray;
	}
	&-date {
		float: right;
		margin-left: 1rem;
		color: $gray;
		font-size: 1.4rem;

		@include media-breakpoint-down(sm) {
			font-size: 1.1rem;
		}
	}
	&-title {
		color: $secondary;
		font-weight: 500;
		font-size: 1.8rem;
		display: block;
		margin-bottom: 1rem;
		height: 4rem;
		line-height: 1.2;
		overflow: hidden;

		@include media-breakpoint-down(sm) {
			font-size: 1.4rem;
		}
	}
	&-msg {
		color: $secondary;
		font-size: 1.4rem;
	}
}
</style>