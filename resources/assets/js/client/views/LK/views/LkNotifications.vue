<template lang="pug">
.noty(v-if='notificationList')
	ul.noty-list(:class='cls')
		li(v-for='notification in notificationList.items')
			p {{notification.message}}
			time {{dateFormat(notification.date)}}

	p(v-if='notificationList.count == 0') Нет уведомлений

	//- .flex-row.f-noshrink.f-align-center.f-content-center(v-if="notificationList ? !!notificationList.hasMore:false")
		button.btn__solid-blue-round.btn-xs.btn__bottom(type="button" @click="getMoreNotifications") Загрузить ещe

</template>

<script>
import moment from 'moment'

export default {
	props: {
		cls: String,
	},
	data() {
		return {
			notificationList: null,
			err: null,
			nextPage: 2
		}
	},
	methods: {
		getNotifications () 
		{
			this.$parent.loading = true;
			axios.get('/api/v1/organization/notifications').then((resp) => {
				this.notificationList = resp.data.data
				this.$parent.loading = false
			}).catch((error) => {
				this.$parent.loading = false
			});
		},

		getMoreNotifications () 
		{
			this.$parent.loading = true;
			axios.get('/api/v1/organization/notifications?page=' + this.nextPage).then((resp) => {
				this.notificationList.items = this.notificationList.items.concat(resp.data.data.items);
				this.notificationList.hasMore = resp.data.data.hasMore;
				this.$parent.loading = false;
			}).catch((error) => {
				this.$parent.loading = false;
			});
		},

		dateFormat (item) 
		{
			return moment(item.date).set('minute', moment(item.date).get('minute') + item.timezone_type*60).locale('ru').calendar();
		},
	},
	created () {
		this.getNotifications();
	}
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.noty {

	&-list {
		margin: 0;
		padding: 0;
		list-style: none;

		li {
			margin: 0 0 1.5rem;
			padding: 0;

			p {
				margin-bottom: .5rem;
			}
			time {
				display: block;
				text-align: right;
				color: $secondary;
				font-size: 1.2rem;
			}
		}
	}
}
</style>
