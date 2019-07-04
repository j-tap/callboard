<template lang="pug">
.card.profile-card
	.card-body
		.messages
			.messages-header
				router-link(
					class='messages-back'
					:to="{name: 'lk.dialogs'}"
				)
					feather(type='arrow-left')
				.messages-bid
					router-link(
						v-if='dialog'
						:to="{name: 'bids.detail', params: {id: dialog.deal.id}}"
					) {{dialog.deal.name}}

			ul(
				v-if='privateDialog' 
				ref='list'
			)
				li.text-center(
					v-if='dialog ? !!dialog.hasMore : false'
				)
					b-button(
						variant='outline-primary'
						@click='getMore()'
					)
						span(v-if='isLoadingMore') Загрузка...
						span(v-else) Загрузить ещe
				li(
					v-for='(item, ind) in privateDialog'
					v-bind:class="{'m-right': (item.user.id === profile.id), 'm-left': (item.user.id !== profile.id)}"
					v-bind:key='item.id'
				)
					.messages-date-day(
						v-if='item.date_create && dates[item.id]'
					) {{dateTimeformat(dateTimezone(item.date_create))}}
					
					.messages-item(
						:data-id='item.user.id'
					)
						.messages-ava(:title='item.user.name')
							router-link(
								:to="{name: 'users.profile', params: {id: item.user.id}}"
							)
								img(v-if='item.user.photo' :src='item.user.photo' alt=' ')
								img(v-else :src="'https://via.placeholder.com/80x80?text='+ item.user.name.charAt(0)" alt=' ')

						.messages-info
							.spinner-border.text-primary.ml-auto.mr-3(
								v-if='item.id === 0'
								role="status"
							)
								span.sr-only Loading...

							.messages-bubble
								p.text-break {{item.message}}

							.messages-date(
								v-if='item.date_create'
							) {{dateFormat(dateTimezone(item.date_create), 'HH:mm')}}

			p.mb-5(v-else) Сообщений нет

			.message-form
				.message-form-field
					v-textarea(
						ref='textmsg'
						v-model='messageText'
						maxlength='2048'
						placeholder='Сообщение'
						:disabled='statusSending'
						flat
						hide-details
						auto-grow
						rows='1'
						@keydown="keydownMessage"
					)
					//- feather(
					//- 	@click='uploadFile'
					//- 	type='paperclip'
					//- )

				.message-form-send(
					:class="{'active': messageText.length}"
					@click='sendMessage'
				)
					SendIcon
			
</template>

<script>
import Vue from 'vue'
const SendIcon = Vue.component('SendIcon', {
	template: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.264 61.263">
		<g id="navigation" transform="rotate(45 13.61 37.683)">
			<path id="Shape" d="M0 19.573L41.32 0 21.747 41.32 17.4 23.922 0 19.573z" class="cls-1"/>
		</g>
	</svg>`
})

export default {
	components: {
		SendIcon,
	},
	data () {
		return {
			dialog: null,
			messageText: '',
			optionsFullDate: {
				year: 'numeric',
				month: 'short',
				day: 'numeric',
				weekday: 'short',
				hour: 'numeric',
				minute: 'numeric'
			},
			optionsCurrentDate: {
				hour: 'numeric',
				minute: 'numeric'
			},
			statusSending: false,
			nextPage: 2,
			isLoadingMore: false,
			profile: null,
		}
	},
	computed: {
		dates () 
		{
			const arr = this.dialog.items.slice().reverse()
			const datesObj = {}
			let prevDate = null
			for (let ind in arr) {
				const item = arr[ind]
				if (item.date_create) {
					const curDate = item.date_create.date.split(' ')[0]
			
					if (curDate != prevDate) {
						prevDate = curDate
						datesObj[item.id] = true
					} else {
						datesObj[item.id] = false
					}
				}
			}
			return datesObj
		},
		privateDialog ()
		{
			if (this.dialog) {
				const result = this.dialog.items.slice().reverse()
				return result
			} return false
		},
	},
	methods: {
		getDialog ()
		{
			this.$parent.loading = true
			axios
			.get('/api/v1/dialogs/' + this.$route.params.id)
			.then((resp) => {
				this.dialog = resp.data.data

				window.Echo.private('dialog.' + this.$route.params.id)
				.listen('ChatMessage', (msg) => {
					console.log(msg)
					this.printNewMsg(msg)
					this.setScrollAndFocus()
					this.setReadedMsg(msg.message_id)
				})

				this.$root.checkNewMsg()
				this.setScrollAndFocus()
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				this.$router.replace({ name: 'page404' })
			})
			.then(() => {
				this.$parent.loading = false
			})
		},
		keydownMessage (evt)
		{
			if (evt.keyCode === 13 && !evt.shiftKey) {
				evt.preventDefault()
				this.sendMessage()
			}
		},
		sendMessage ()
		{
			if (this.messageText !== '') {
				this.statusSending = true
				this.printFakeMessage()
				axios
				.post('/api/v1/dialogs/' + this.$route.params.id + '/send', {
					'message': this.messageText
				})
				.then((resp) => {
					this.messageText = ''
					this.$nextTick(() => {
						this.setScrollAndFocus()
					})
				})
				.catch((error) => {
					this.printErrorOnConsole(error)
				}).then(() => {
					this.statusSending = false
				})
			}
		},
		scrollToBottom ()
		{
			const list = this.$refs.list
			if (list) {
				// list.scrollTop = list.scrollHeight
				$(list).animate({
					scrollTop: list.scrollHeight
				}, 300)
			}
		},
		dateTimezone (d)
		{
			let date = new Date(d.date);
			date.setHours(date.getHours() + d.timezone_type);
			return date
		},
		getMore ()
		{
			this.isLoadingMore = true
			axios
			.get('/api/v1/dialogs/' + this.$route.params.id + '/?page=' + this.nextPage)
			.then((resp) => {
				this.dialog.hasMore = resp.data.data.hasMore
				this.dialog.items = this.dialog.items.concat(resp.data.data.items)
				this.nextPage++
			}).catch((error) => {
				this.printErrorOnConsole(error)
			}).then(() => {
				this.isLoadingMore = false
			})
		},
		setReadedMsg (id)
		{
			if (id) {
				axios
				.post('/api/v1/dialogs/messages/markreaded', {
					'id': id
				})
				.then((resp) => {})
				.catch((error) => {
					this.printErrorOnConsole(error)
				})
			}
		},
		printFakeMessage ()
		{
			const fakeMsg = {
				id: 0,
				message: this.messageText,
				user: this.profile,
			}
			this.printNewMsg(fakeMsg)
		},
		printNewMsg (msg)
		{
			if (this.dialog.items) {
				this.dialog.items = $.grep(this.dialog.items, (item) => { 
					return item.id !== 0; 
				})
				this.dialog.items.unshift(msg)
			}
		},
		uploadFile ()
		{
			// TODO: upload file api
		},
		setScrollAndFocus ()
		{
			setTimeout(() => {
				this.scrollToBottom()
				if (!this.isMobile) {
					this.$refs.textmsg.focus()
				}
			}, 100)
		},
	},
	mounted () {
		const user = this.$store.state.profile

		this.profile = user.profile
		this.$root.notification = false
		this.getDialog()
	},
	watch: {},//this.scrollToBottom()
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.row .col-content .card,
.card {
	@include media-breakpoint-down(sm) {
		border: none;
		box-shadow: none;
	}
	&-body {
		@include media-breakpoint-down(sm) {
			padding: 0;
		}
	}
}

.messages {

	&-header {
		position: relative;
		padding: .3rem 6rem 0;
		margin-bottom: 3rem;

		@include media-breakpoint-down(sm) {
			padding-left: 1.5rem;
			padding-right: 1.5rem;
		}
	}
	&-back {
		position: absolute;
		left: 0;
		top: 0;
		display: flex;
		width: 3.7rem;
		height: 3rem;
		line-height: 3rem;
		border: solid .2rem rgba($light, .4);
		text-align: center;
		color: $light;
		border-radius: $border-radius;
		border-top-left-radius: 0;
		align-items: center;
		justify-content: center;

		@include media-breakpoint-down(sm) {
			display: none;
		}

		&:hover,
		&:focus {
			color: $light;
		}
		.feather {
			width: 1.8rem;
			height: 1.8rem;
		}
	}
	&-bid {
		font-weight: 400;
		font-size: 1.6rem;
		color: $secondary;
		padding-bottom: .5rem;
		// border-bottom: .1rem solid $light;

		a {
			text-decoration: none;
			color: $primary;
		}
	}
	ul {
		list-style: none;
		margin: 0 0 3rem;
		padding: 0 6rem;
		height: calc(100vh - 30rem);
		overflow-y: auto;

		@include media-breakpoint-down(sm) {
			padding-left: 1.5rem;
			padding-right: 1.5rem;
		}

		li {
			margin: 0 0 1.5rem;
			padding: 0;

			&.m-left {
				.messages-ava {
					margin: 0 1rem 0 0;
				}
				.messages-info {
					text-align: left;
				}
				.messages-bubble {
					background: $light-gray;
					border-top-left-radius: 0;

					&::before {
						display: block;
						left: -1rem;
						border: .5rem solid transparent;
						border-top: .5rem solid $light-gray;
						border-right: .5rem solid $light-gray;
					}
				}
				& + .m-left {
					.messages-ava img {
						display: none;
					}
					.messages-bubble {
						border-top-left-radius: $border-radius-sm;

						&::before {
							display: none;
						}
					}
					.messages-date-day + .messages-item {
						.messages-ava img {
							display: block;
						}
						.messages-bubble {
							border-top-left-radius: 0;

							&::before {
								display: block;
								left: -1rem;
								border: .5rem solid transparent;
								border-top: .5rem solid $light-gray;
								border-right: .5rem solid $light-gray;
							}
						}
					}
				}
			}

			&.m-right {
				.messages-item {
					flex-direction: row-reverse;
				}
				.messages-date {
					text-align: right;
				}
				.messages-ava {
					margin: 0 0 0 1rem;
				}
				.messages-info {
					text-align: right;
				}
				.messages-bubble {
					background: $blue-light;
					border-top-right-radius: 0;

					&::before {
						display: block;
						right: -1rem;
						border: .5rem solid transparent;
						border-top: .5rem solid $blue-light;
						border-left: .5rem solid $blue-light;
					}
				}
				& + .m-right {
					.messages-ava img {
						display: none;
					}
					.messages-bubble {
						border-top-right-radius: $border-radius-sm;

						&::before {
							display: none;
						}
					}
					.messages-date-day + .messages-item {
						.messages-ava img {
							display: block;
						}
						.messages-bubble {
							border-top-right-radius: 0;

							&::before {
								display: block;
								right: -1rem;
								border: .5rem solid transparent;
								border-top: .5rem solid $blue-light;
								border-left: .5rem solid $blue-light;
							}
						}
					}
				}
			}
		}
	}
	&-item {
		display: flex;
	}
	&-date {
		line-height: 1;
		margin-top: .5rem;
		font-size: 1.2rem;
		color: $gray;
	}
	&-date-day {
		text-align: center;
		font-size: 1.2rem;
		color: $gray;
		border-bottom: .1rem dotted $gray;
		margin-bottom: 1.5rem;
		padding-bottom: .5rem;
	}
	&-ava {
		width: 4.5rem;
		height: 4.5rem;
		overflow: hidden;
		position: relative;
		border-radius: $border-radius-sm;

		@include media-breakpoint-down(sm) {
			display: none;
		}

		img {
			@include imgAbsCenter();
		}
	}
	&-info {
		flex: 1;
	}
	&-bubble {
		display: inline-block;
		position: relative;
		border-radius: $border-radius-sm;
		padding: 1.4rem;

		&::before {
			content: '';
			position: absolute;
			top: 0;
			background: none;
		}
		p {
			font-size: 1.4rem;
		}
	}
}
.message-form {
	padding: 1.5rem calc(6rem + #{$card-spacer-x});
	margin: 0 calc(-#{$card-spacer-x} * 1) calc(-#{$card-spacer-y} * 1);
	background: $body-bg-gray;
	position: relative;
	display: flex;
	align-items: flex-end;
	border-radius: 0 0 $border-radius $border-radius;

	@include media-breakpoint-down(sm) {
		padding-left: 1.5rem;
		padding-right: 1.5rem;
		margin: 0 calc(-#{$grid-gutter-width} / 2);
	}

	&-field {
		position: relative;
		z-index: 2;
		align-items: flex-start;
		display: flex;
		flex: 1 1 auto;

		i.feather {
			color: $gray;
			position: absolute;
			right: 1rem;
			top: 50%;
			margin-top: -1.2rem;
			width: 2.4rem;
			height: 2.4rem;
			cursor: pointer;
		}

		.v-input {
			margin: 0;
			padding: 0;
		}
		.v-textarea {
			textarea {
				padding: 1.2rem 2rem 1.2rem 1rem;
				max-height: 11rem;
				overflow-y: auto;
				resize: none;
				margin-right: -1rem;
				width: auto;
				max-width: calc(100% + 1rem);
			}
		}
	}

	&-send {
		margin-left: 1rem;
		width: 5.8rem;
		height: 4rem;
		cursor: pointer;
		transform: translateX(-8rem) scale(.5);
		opacity: 0;
		transition: transform .2s ease-in, opacity .2s ease-in;

		@include media-breakpoint-down(sm) {
			width: 3rem;
			height: 3rem;
		}

		&.active {
			opacity: 1;
			transform: translateX(0) scale(1);
		}

		svg {
			margin-top: -1rem;
			width: 100%;
			height: auto;
			stroke: $gray;
			fill: none;
			stroke-linecap: round;
			stroke-linejoin: round;
			stroke-miterlimit: 10;
			stroke-width: .2rem;
		}
	}
}
</style>