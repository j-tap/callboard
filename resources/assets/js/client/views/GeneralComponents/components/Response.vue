<template lang="pug">
div
	.bid-response
		.bid-response-inner
			img(:src='icon' alt=' ')
			.bid-response-text
				p Что бы начать сотрудничество и посмотреть контакты покупателя, заполните форму отклика
			b-button(
				size='lg' 
				variant='danger'
				block
				@click='showResponseForm'
			) Отклик

	b-modal#modalResponse(
		modal-class='modal-response'
		ref='modalResponse'
	)
		.modal-response-head
			img(:src='icon' alt=' ')
			p Что бы начать сотрудничество и посмотреть контакты покупателя, заполните форму отклика

		.modal-response-body
			b-form(
				@submit.prevent='validateBeforeSubmit'
			)
				.modal-response-container
					.form-group
						b-form-input(
							v-model='form.title'
							placeholder='Заголовок сообщения'
							size='lg'
							data-vv-as='заголовок'
							data-vv-name='title'
							v-validate="'required'"
							:error-messages="err.title ? err.title : errors.collect('title')"
						)
					.form-group
						b-form-textarea(
							v-model="form.text"
							placeholder='Тема сообщения'
							rows='7'
							max-rows='12'
							size='lg'
							data-vv-as='тема'
							data-vv-name='text'
							v-validate="'required'"
							:error-messages="err.text ? err.text : errors.collect('text')"
						)
					.form-group
						b-form-input(
							v-model='form.budget'
							placeholder='Бюджет'
							size='lg'
							data-vv-as='бюджет'
							data-vv-name='budget'
							v-validate="'required'"
							:error-messages="err.budget ? err.budget : errors.collect('budget')"
						)
					.form-group
						.input-file-link.mb-3
							input#modalResponseFormFile(
								@change='onFileChange($event)'
								type='file'
								data-vv-as='тема'
								data-vv-name='file'
								v-validate="'size:5000'"
								:error-messages="err.file ? err.file : errors.collect('file')"
							)
							label(
								for='modalResponseFormFile'
							)
								feather(type='file')
								span Прикрепить файл

				.modal-response-wallet
					p Получить контакты пользователя заявки о продаже 290 ₽
					hr
					table
						tr
							th Компания
							th &nbsp;
							th На счету в кошельке
						tr
							td ОАО "Мясо"
							td &nbsp;
							td 1 5000 руб.

				.text-center
					.modal-response-price Стоимость услуги: 290

					b-button(
						variant='outline-primary'
						type='submit'
						size='lg'
						:disabled='loading'
					)
						span.px-5
							span Оплатить
							b-spinner(v-if='loading' label='Загрузка...')
						

		div(slot='modal-footer')

</template>

<script>
export default {
	data() {
		return {
			form: {
				title: null,
				text: null,
				budget: null,
				file: null,
			},
			formData: new FormData(),
			err: {},
			loading: false,
			icon: 'data:image/png;base64,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'
		}
	},
	props: {
		cost: Number,
	},
	computed: {},
	methods: {
		showResponseForm ()
		{
			this.$refs['modalResponse'].show()
		},
		onFileChange (evt)
		{
			const files = evt.target.files || evt.dataTransfer.files
			if (!files.length) return
			this.form.file = files[0]
		},
		validateBeforeSubmit ()
		{
			this.$validator.validateAll()
			.then(result => {
				if (result) {
					this.err = {};
					for (let key in this.form) {
						this.formData.set(key, this.form[key]);
					}
					this.sendForm()
				}
			})
		},
		sendForm ()
		{
			console.log('sendForm formData', this.formData)
			// this.loading = true
			// axios
			// .post(path, this.formData, {
			// 	headers: { 'Content-Type': 'multipart/form-data' }
			// })
			// .then(resp => {
			// 	console.log(resp.data)
			// 	this.$store.commit('setSnackbar', {
			// 		color: 'success',
			// 		text: 'Отклик успешно отправлен',
			// 		toggle: true
			// 	})
			// })
			// .catch(error => {
			// 	this.printErrorOnConsole(error)
			// })
			// .then(() => {
			// 	this.loading = false
			// })
		},
	},
	watch: {},
	mounted () {},
}
</script>

<style lang="scss" scope>
@import '../../../../../sass/base.scss';

.bid-response {
	padding: 5rem 0;

	&-inner {
		max-width: 30rem;
		margin: 0 auto;
		text-align: center;
	}
	img {
		margin-bottom: 2rem;
	}
	.bid-response-text {
		margin-bottom: 3rem;
		font-size: 1.4rem;

		p {
			margin-bottom: 1rem;
		}
	}
	.btn {
		font-size: 1.6rem;
		height: 5.7rem;
		max-width: 18rem;
		margin: 0 auto;
	}
}
.modal-response {
	.modal-dialog {
		max-width: 62rem;
	}
	&-container {
		max-width: 40rem;
		margin-left: auto;
		margin-right: auto;
	}
	&-head {
		text-align: center;
		margin-bottom: 2.5rem;
		
		img {
			margin-bottom: 1.5rem;
		}
		p {
			max-width: 34rem;
			margin: 0 auto 1rem;
		}
	}
	&-body {
		.form-control {
			font-size: 1.4rem;
			padding-top: 1rem;
			padding-bottom: 1rem;
		}
		input.form-control {
			height: 4rem;
		}
		textarea.form-control {

		}
	}
	&-wallet {
		p {
			color: $secondary;
			font-size: 1.4rem;
			margin-bottom: .5rem;
		}
		hr {
			background: none;
			height: 0;
			border: none;
			padding: 0;
			margin: 0;
			border-bottom: .1rem dashed $light;
		}
		table {
			width: calc(100% + #{$modal-inner-padding} * 2);
			margin: 0  (-$modal-inner-padding) 4rem;

			tr {

			}
			th {
				padding: 1.5rem $modal-inner-padding;
				font-size: 1.4rem;
				font-weight: 400;
				color: $light;

				&:last-child {
					text-align: right;
				}
			}
			td {
				padding: 3rem $modal-inner-padding;
				background: $body-bg-gray;
				font-size: 2rem;
				color: $secondary;

				&:last-child {
					text-align: right;
				}
			}
		}
	}
	&-price {
		font-size: 1.6rem;
		margin-bottom: 3rem;
	}
	.modal-footer {
		display: none;
	}
}
</style>