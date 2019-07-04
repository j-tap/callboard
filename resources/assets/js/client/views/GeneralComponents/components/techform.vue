<template lang="pug">
.overlay
	.window
		.window-header
			.close-wrapper.clearfix
				button.close(
					@click="$emit('close')"
				) X
			.type
				v-select(
						solo
						appendIcon='expand_more'
						:items='optionlist' 
						v-model='formType'
						:light='true'
            @change='changeFormType'
					)
		.window-body
			form.form(action="javascript:void(0);" @submit.prevent="registerSubmit()")
				.form-group
					v-text-field(
						v-model='form.theme'
						:error-messages="err.theme ? err.theme : errors.collect('theme')"
						solo
						:light='true'
						placeholder='Тема обращения'
						v-validate=`'required'`
						name="theme"
						data-vv-as='Тема обращения'
						data-vv-name='theme'
					)
				.form-group
					v-textarea(
						:error-messages="err.message ? err.message : errors.collect('message')"
						solo
						name="message"
						placeholder="Текст сообщения"
						v-validate=`'required'`
						v-model="form.text"
						:no-resize="true"
						data-vv-as='Текст сообщения'
						data-vv-name='message'
					)
				.unauthorized-users-data(v-if="!isAuth")
					.form-group
						.row
							.col
								v-text-field(
									v-model='form.email'
									:error-messages="err.email ? err.email : errors.collect('email')"
									solo
									:light='true'
									placeholder='Email'
									name="email"
									data-vv-as='Email'
									data-vv-name='email'
									v-validate=`'required|email'`
								)
								v-text-field.phone(
									:error-messages="err.phone ? err.phone : errors.collect('phone')"
									v-model='form.phone'
									solo
									:light='true'
									placeholder='Телефон'
									prefix="+7"
									v-validate=`'required|min:10|max:10'`
									name="phone"
									data-vv-as='Телефон'
									data-vv-name='phone'
									mask='phone'
								)
					.form-group
						label.checkbox 
							input(
								type="checkbox"
								v-model="form.terms"
								v-validate=`'required'`
								name="terms"
								data-vv-as='Условия'
								data-vv-name='terms'
								:error-messages="err.terms ? err.terms : errors.collect('terms')")
							span(:class="{'has-error':errors.has('terms')}")
								p Я принимаю условия 
									a(href="/files/agreement.doc") пользовательского соглашения 
									| и даю свое согласие на обработку персональных данных на условиях и целях, определенных 
									a(href="/files/politic.doc") политикой конфиденциальности.
						span(
							class="error--text small--text"
							v-if="errors.has('terms')") {{errors.first('terms')}}		
				.form-group
					b-button(size='lg' variant='techform' type='submit' :disabled='loading')
						span.px-3
							|Отправить
							b-spinner(v-if='loading' label='Загрузка...')
</template>
<script>
export default {
  name: "supportform",
  data() {
    return {
      loading: false,
      err: {},
      optionlist: [
        { value: 0, text: "Техническая поддержка" },
        { value: 1, text: "Пожелания" }
      ],
      form: {
        theme: null,
        text: null,
        email: null,
        phone: null,
        terms: null
      },
      // техподдержка - 0, пожелания - 1
      formType: 0,
      url: "/api/v1/send/support",
      content:
        "<p style='font-family: Roboto;font-size: 16px;font-weight:600;'>Спасибо за обращение. <br>Мы решим Вашу проблему <br>в кратчайшие сроки.</p>"
    };
  },
  computed: {
    isAuth() {
      if (this.$root.profile) {
        return true;
      } else {
        return false;
      }
    }
  },
  methods: {
    changeFormType() {
      if (this.formType == 0) {
        // сообщение о проблеме
        this.content =
          "<p style='font-family: Roboto;font-size: 16px;font-weight:600;'>Спасибо за обращение. <br>Мы решим Вашу проблему <br>в кратчайшие сроки.</p>";
        // url для отправки формы саппорта
        this.url = "/api/v1/send/support";
      } else {
        // сообщение о хотелках
        this.content =
          "<p style='font-family: Roboto;font-size: 16px;font-weight:600;'>Спасибо за обращение. <br>Мы постараемся как можно скорее реализовать Ваши пожелания</p>";
        // url для отправки формы хотелок
        this.url = "/api/v1/send/support";
      }
    },
    formSend() {
      this.loading = true;
      this.err = {};
      this.loading = true;
      this.form.form_type = this.formType;

      let data = Object.assign({}, this.form);

      console.log(this.isAuth);

      // выцепляем id пользователя
      if (this.isAuth) {
        data.text =
          "Идентификатор пользователя: " +
          this.$root.profile.profile.unique_id +
          ". Сообщение пользователя: " +
          data.text;
      }
      axios
        .post(this.url, { data: data })
        .then(resp => {
          this.loading = false;
          this.$store.commit("setModalMsg", {
            toggle: true,
            content: this.content
          });
          this.$emit("close");
        })
        .catch(error => {
          this.printErrorOnConsole(error);
          this.err = error.response.data.errors;
          this.loading = false;
          this.$store.commit("setSnackbar", {
            color: "error",
            text: "Произошла ошибка, попробуйте позднее",
            toggle: true
          });
        });
    },
    registerSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.formSend();
          return;
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../../../sass/base.scss";

.overlay {
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background-color: rgba(207, 204, 204, 0.5);
  z-index: 1000;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  padding: 1rem;
  overflow: hidden scroll;
  @include media-breakpoint-down(xs) {
    justify-content: center;
  }
  .window {
    width: 100%;
    max-width: 300px;
    backdrop-filter: blur(50px);
    box-shadow: $box-shadow;
    background-color: #ffffff;
    border-radius: $border-radius;
    overflow: hidden;
    &-header {
      background-color: $primary;
      padding-left: 1rem;
      padding-bottom: 1.5rem;
      .type {
        max-width: 250px;
        /deep/ .v-select__selection {
          font-family: Roboto;
          font-size: 1.4rem;
          color: #010101;
        }
      }
    }
    &-body {
      background-color: #fff;
      .form {
        padding: 1rem;
        /deep/ .v-input {
          .v-input__slot {
            border-color: $light;
            font-family: Roboto;
            font-size: 1.4rem;
            color: $gray;
          }
          &--is-focused {
            .v-input__slot {
              box-shadow: $box-shadow;
              border-color: $primary;
              color: 010101;
            }
          }
        }
        /deep/ textarea {
          min-height: 160px;
        }
        .col {
          display: flex;
          justify-content: space-between;
          /deep/ .v-input {
            max-width: 49%;
          }
        }
      }
    }
  }
}
label.checkbox {
  span {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    p {
      max-width: 70%;
      font-family: Roboto;
      font-size: 11px;
      line-height: 1.18;
      letter-spacing: normal;
      text-align: left;
    }
    &:before {
      background: transparent;
      content: "";
      width: 22px;
      height: 22px;
      border: 1px solid $light;
      border-radius: $border-radius;
    }
    &.has-error:before {
      border-color: $danger;
    }
  }
  input {
    display: none;
    &:checked + span::before {
      border-color: $primary;
      content: "\2713";
      font-size: 32px;
      font-weight: 600;
      line-height: 12px;
      color: $primary;
    }
  }
}
.small--text {
  font-size: 11px;
}
.phone {
  /deep/ .v-text-field__prefix {
    padding-left: 3px;
  }
  /deep/ input {
    padding: 0.375rem 0.25rem;
  }
}
button.close {
  width: 1.4rem;
  height: 1.4rem;
  margin: 0.5rem;
  &:after,
  &:before {
    background: $light-gray;
  }
}
.btn-techform {
  margin: 0 auto;
  display: block;
  color: $primary;
  border-color: $primary;
  background-color: #fff;
  cursor: pointer;
  span {
    font-family: Roboto;
    font-size: 18px;
    font-weight: normal;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.22;
    letter-spacing: normal;
  }
}
</style>