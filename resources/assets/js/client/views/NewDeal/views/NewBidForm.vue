<template lang="pug">
form(
	@submit.prevent='validateBeforeSubmit'
)
	.form-group
		b-form-radio-group(
			v-if='!edit'
			class='btn-toggle-type'
			title='Вы хотите продать или купить?'
			buttons
			button-variant='outline-primary'
			size='md'
			:options='types'
			v-model='form.type_deal'
			@change='changeBidType'
		)
	template(
		v-if="(isAvailableSell && form.type_deal == types.sell.value) || form.type_deal == types.buy.value || edit"
	)
		p.warning-info(v-if="(form.type_deal == types.sell.value && (!isProAccount && !edit) )") Услуга платная. С вашего кошелька будет списано {{cost}} руб.
		.narrow-wrap
			.form-group
				v-text-field(
					v-model='form.name'
					placeholder='Название товара'
					solo
					title='Напишите, краткое название'
					:light='true'
					data-vv-as='Название'
					data-vv-name='name'
					v-validate=`'required|min:2|max:100'`
					:error-messages=`err.name ? err.name : errors.collect('name')`
				)
			
			.form-group
				CategorySelect(
					@setCategoryEmit='setCategory'
					:category='category'
					:err='err'
				)
		
		hr.hr-dotted

		.form-group
			v-textarea(
				placeholder='Описание товара'
				solo
				title='Напишите краткое описание товара, его особенности'
				v-model='form.description'
				:light='true'
				data-vv-as='Описание'
				data-vv-name='description'
				v-validate=`'min:16'`
				:error-messages="err.description ? err.description : errors.collect('description')"
			)

		.form-group(v-if='form.type_deal == types.sell.value')
			FilePhoto(
				class='mb-4'
				:imagesUploaded='imagesUploaded'
				:count='5'
				:err='err'
				@setImagesEmit='setImages'
			)
			.text-muted 
				small Добавьте 5 фотографий

		hr.hr-dotted

		.narrow-wrap.narrow-wrap--mini
			.form-group
				CitiesSelect(
					@setCityEmit='setCity'
					:cityName='cityName'
					:err='err'
				)

			.form-group(
				v-show="form.type_deal === types.buy.value"
			)
				.row
					.col-sm-6
						input#budgetFrom.form-control(
							type='text' 
							placeholder='Цена от'
							title='Укажите нижний предел стоимости'
							v-model='form.budget_from' 
							@keydown='onlyNumber'
							@input="formatPrice('budget_from')"
							data-vv-as='Цена от'
							data-vv-name='budget_from'
							v-validate="'rulePriceFrom'"
							:class='{ "is-invalid": errors.has("budget_from") }'
						)
						.invalid-feedback {{ errors.first('budget_from') }}

					.col-sm-6
						.d-flex.justify-content-center.align-items-top.position-relative
							div
								input#budgetTo.form-control(
									type='text' 
									placeholder='Цена до'
									title='Укажите верхний предел стоимости'
									v-model='form.budget_to' 
									@keydown='onlyNumber'
									@input="formatPrice('budget_to'), $validator.validate('budget_from')"
								)
							.form-price-sign.m-abs &#8381;

			.form-group(
				v-if="form.type_deal === types.sell.value"
			)
				.d-flex.justify-content-center.align-items-top.position-relative
					.w-100
						input#budget.form-control(
							type='text' 
							placeholder='Цена'
							title='Укажите цену, за которую вы хотите продать товар'
							v-model='form.budget_to' 
							@keydown='onlyNumber'
							@input="formatPrice('budget_to')"
							data-vv-as='Цена'
							data-vv-name='budget_to'
							v-validate="'required'"
							:class='{ "is-invalid": errors.has("budget_to") }'
						)
						.invalid-feedback {{ errors.first('budget_to') }}
					.flex-shrink-1
						.form-price-sign &#8381;

			.form-group(
				v-show="form.type_deal === types.buy.value"
			)
				b-form-checkbox(
					v-model='form.is_need_kp'
					:class="{ 'is-invalid': err.is_need_kp }"
					switch
					value='1'
					unchecked-value='0'
				) Необходимо коммерческое предложение

				//- .col-md-6(v-if='form.type_deal == types.buy.value')
					Datepicker(
						title='При необходимости, выберите дату, после которой сделка будет закрыта'
						placeholder='Срок действия'
						format='dd MMM yyyy' 
						:value='form.deadline_deal' 
						:disabledDates='disabledDatesDatepicker' 
						:language='ru' 
						@selected='dateSelectedEvt'
						@input='form.deadline_deal = dateInputEvt($event)'
					)

		//- .form-group.row(v-if='!edit && form.type_deal == types.sell.value')
			label.col-md-4.col-form-label-sm(for='subtype_deal') Тип объявления:
			.col-md-8
				b-form-radio-group(
					id='subtype_deal'
					title='Товар новый или бывший в употреблении?'
					buttons
					button-variant='outline-primary'
					size='sm'
					:options='subtypes'
					v-model='form.subtype_deal'
					@change='changeBidSubtype'
				)
		hr.hr-dotted

		.form-submit-wrap
			b-button(
				variant='outline-primary'
				type='submit'
				:disabled='loading'
			) 
				span.px-3 
					span(v-if='edit') Сохранить
					span(v-else) Разместить заявку
					b-spinner(v-if='loading' label='Загрузка...')

			router-link(
				v-if='edit'
				class='btn btn-outline-secondary'
				:to="{name:'lk.deals'}"
			)
				span.px-3 Отмена

	template(
		v-if='!isAvailableSell && form.type_deal == types.sell.value && availableMsg && !edit'
	)
		p {{availableMsg}}
		router-link(
			:to="{name: 'lk.wallet', params:{cost: (this.cost).toString()} }"
		) Пополните ваш баланс

</template>

<script>
// import Datepicker from "vuejs-datepicker";
// import { en, ru } from "vuejs-datepicker/src/locale";
import moment from "moment";
import { Validator } from "vee-validate";
import CitiesSelect from "../../GeneralComponents/components/CitiesSelect";
import CategorySelect from "../../GeneralComponents/components/CategorySelect";
import FilePhoto from "../../GeneralComponents/components/FilePhoto";

export default {
	components: {
		// Datepicker,
		CitiesSelect,
		CategorySelect,
		FilePhoto
	},
	props: {
		edit: Boolean,
		update: Object
	},
	data() {
		return {
			loading: false,
			err: {},
			types: {
				sell: { text: "Заявка на продажу", value: "sell" },
				buy: { text: "Заявка на покупку", value: "buy" }
			},
			cost: null,
			isProAccount: null,
			// subtypes: {
			// 	new: {text: 'Новое', value: 'new'},
			// 	used: {text: 'Б/у', value: 'used'}
			// },
			cityName: null,
			category: null,
			// disabledDatesDatepicker: {
			// 	to: new Date( Date.now() )
			// },
			// en,
			// ru,
			formData: new FormData(),
			form: {
				type_deal: "sell",
				subtype_deal: "new",
				name: null,
				category: null,
				description: null,
				images: [],
				region: null,
				city: null,
				budget_from: null,
				budget_to: null,
				deadline_deal: null,
				is_need_kp: 0,
			},
			isAvailableSell: false,
			availableMsg: null,
			imagesUploaded: []
		};
	},
	computed: {},
	methods: {
		dateSelectedEvt(date) {},
		dateInputEvt(evt) {
			return moment(evt).format("YYYY-MM-DD");
		},

		formatPrice (fieldName)
		{
			const price = parseInt(this.form[fieldName])
			if (price >= 0) {
				if (price == 0) {
					this.form[fieldName] = ''
				} else {
					this.form[fieldName] = this.priceFormat(
						this.form[fieldName].replace(/\s/g, '')
					)
				}
			}
		},

		changeBidType(val) {
			// if (this.$root.profile.profile.is_org_created == 0 && val == this.types.sell.value) {
			// 	this.form.type_deal = this.types.buy.value
			// 	this.$snackbar.color = 'error'
			// 	this.$snackbar.text = 'Чтобы разместить заявку на продажу - вам необходимо зарегистрировать компанию в личном кабинете'
			// 	this.$snackbar.toggle = true
			// 	this.$router.push({name: 'lk.company.create'})
			// }
			if (this.form.type_deal === this.types.buy.value) {
				this.form.images = []
			}
		},
		changeBidSubtype(val) {},

		validateBeforeSubmit() {
			this.$validator.validateAll().then(result => {
				if (result) {
					this.err = {};
					this.loading = true;

					for (let key in this.form) {
						switch (key) {
							case "city":
								this.formData.set("cities[]", this.form[key]);
								// this.formData.set('cities[]', this.form[key])
								//this.form[key].forEach((item, i, arr) => { })
								break;
							case "category":
								this.formData.set("categories[]", this.form[key]);
								break;
							case "budget_from":
							case "budget_to":
								if (this.form[key]) {
									const price = this.form[key].replace(/\s/g, "");
									this.formData.set(key, price);
								}
								break;
							case "images":
								for (let i in this.form[key]) {
									this.formData.append("images[]", this.form[key][i]);
								}
								break;
							default:
								this.formData.set(key, this.form[key]);
								break;
						}
					}
					
					this.createBid();
				}
			});
		},
		createBid() {
			let path = "/api/v1/deals/store";
			if (this.edit) path = "/api/v1/deals/update/" + this.id;

			axios
				.post(path, this.formData, {
					headers: { "Content-Type": "multipart/form-data" }
				})
				.then(resp => {
					if (resp.error) {
						this.err = resp.error;
					} else if (resp.data.error) {
						this.$store.commit("setSnackbar", {
							color: "error",
							text: resp.data.error,
							toggle: true
						});
					} else {
						if (resp.data.result) {
							const profile = this.$store.state.profile.profile;
							if (!this.isProAccount) profile.ballance = profile.ballance - this.cost;
							this.$store.commit("setProfile", { profile: profile });
							this.$router.push({ name: "lk.deals", hash: "moderated" });
						}
						if (window.isProdMode)
							window.ym(53902132, "reachGoal", "create_request");
					}
				})
				.catch(error => {
					this.printErrorOnConsole(error);
					if (error.response.data.errors) this.err = error.response.data.errors;
				})
				.then(() => {
					this.loading = false;
				});
		},

		setCategory(categoryId) {
			this.form.category = categoryId;
		},
		setCity(cityId) {
			if (cityId) this.form.city = cityId;
		},
		setImages(images) {
			this.form.images = images;
		},

		updateFields() {
			if (this.edit) {
				this.category = {}
				for (let key in this.update) {
					switch (key) {
						case 'id':
							this.id = this.update[key]
							break
						case 'images':
							this.imagesUploaded = this.update[key]
							break
						case 'category_id':
							this.setCategory(this.update[key])
							this.category.id = this.update[key]
							break
						case 'category':
							this.category.name = this.update[key]
							break
						case 'city_id':
							this.setCity(this.update[key])
							break
						case 'city':
							this.cityName = this.update[key]
							break
						default:
							this.form[key] = this.update[key]
							break
					}
				}
			}
		},

		checkAvailableSell() {
			axios
			.get("/api/v1/paymentservice/payment_once_deal_sell")
			.then(resp => {
				if (resp.data.error) {
					this.isAvailableSell = resp.data.error.is_possible;
					this.availableMsg = resp.data.error.message;
				} else {
					this.isAvailableSell = resp.data.data.is_possible;
					this.availableMsg = resp.data.data.message;
					this.cost = resp.data.data.cost_of_service;
					this.isProAccount = resp.data.data.is_pro_account;
				}
			})
		}
	},
	mounted() {
		this.checkAvailableSell();
		
		Validator.extend('rulePriceFrom', {
			getMessage: field => 'Минимальная цена должна быть меньше максимальной.',
			validate: value => {
				if (
					(
						this.form.budget_to 
						&& parseInt(value.replace(' ','')) < parseInt(this.form.budget_to.replace(' ',''))
					) 
					|| !value 
				) return true
				else return false
			}
		})
	},
	watch: {
		update(newVal, oldVal) {
			this.updateFields();
		}
	}
};
</script>

<style scoped lang="scss">
@import "../../../../../sass/base.scss";

.warning-info {
	font-weight: 500;
	color: $text-gray;
	margin-bottom: 2rem;
}
.narrow-wrap {
	max-width: 44rem;
	margin: 0 auto;

	&--mini {
		max-width: 26.8rem;
	}
}
.btn-group-toggle.btn-toggle-type {
	width: 100%;
	border-bottom: 0.1rem solid $primary;

	@include media-breakpoint-down(sm) {
		margin-left: calc(-#{$grid-gutter-width} / 2);
		margin-right: calc(-#{$grid-gutter-width} / 2);
		width: calc(100% + #{$grid-gutter-width});
	}

	/deep/ label.btn {
		border: none;
		padding: 0 1rem;
		background: none;
		font-size: 16px;
		font-weight: 400;
		color: $secondary;
		box-shadow: none;
		white-space: nowrap;

		&:first-child {
			text-align: right;
		}
		&:last-child {
			text-align: left;
		}
		&.active {
			font-weight: 500;
			color: $primary;
		}
		&:focus {
			font-weight: 500;
		}
	}
}

.form-edit-images {
	display: flex;

	li {
		position: relative;
		list-style: none;
		margin-right: 1rem;

		img {
			max-width: 12rem;
			max-height: 8rem;
		}
		.btn {
			line-height: 1;

			&-delete {
				position: absolute;
				top: 0.5rem;
				right: 0.5rem;
			}
			.feather {
				width: 1.6rem;
				height: 1.6rem;
			}
		}
	}
}
.form-submit-wrap {
	text-align: center;

	& > * {
		display: inline-block;
		margin: 0 1rem 1rem;
	}
	.btn {
		height: 4rem;
		line-height: 4rem;
		padding: 0 3rem;

		@include media-breakpoint-down(sm) {
			padding-left: 1.5rem;
			padding-right: 1.5rem;
		}
	}
}
.hr-dotted {
	border: none;
	border-bottom: .1rem dotted $gray;
	margin: 1.7rem 0;
	padding: 0;
}
.form-price-sign {
	color: $gray;
	font-size: 3rem;
	line-height: 1;
	font-weight: 300;
	padding: 0 1rem;

	&.m-abs {
		padding: 0;
		position: absolute;
		right: -2.4rem;
		top: .2rem;
	}
}
</style>
