<template lang="pug">
div.row
	.card
		.card-body
			v-form(class='form-register' @submit.prevent='registerSubmit' autocomplete='off')
				h3.form-register--title Создание профиля tamtem
				.form-group
					v-text-field(
						v-model="form.name"
						:error-messages="err.name ? err.name : errors.collect('name')"
						:light='true'
						solo
						label="Имя"
						placeholder='Имя'
						maxlength="32"
						tabindex="1"
						data-vv-as='Имя'
						data-vv-name='name'
						v-validate=`'required'`
						required
					)
				.form-group
					v-text-field( 
						v-model="form.email"
						:error-messages="err.email ? err.email : errors.collect('email')"
						:light='true'
						solo
						label="Email"
						placeholder='Email'
						tabindex="2"
						data-vv-as='Email'
						data-vv-name='email'
						v-validate=`'required|email'`
						required
						autocomplete='off'
					)
				.form-group
					v-text-field( 
						v-model="form.phone"
						:error-messages="err.phone ? err.phone : errors.collect('phone')"
						:light='true'
						solo
						label="Телефон"
						placeholder='Телефон'
						tabindex="3"
						data-vv-as='Телефон'
						data-vv-name='phone'
						mask='(###) ###-##-##'
						required
						v-validate=`'required'`
						autocomplete='off'
						prefix="+7"
					)  
				.form-group
					v-text-field(
						v-model="form.password"
						:error-messages="err.password ? err.password : errors.collect('password')"
						:light='true'
						solo
						label="Пароль"
						placeholder='Пароль'
						:type="show_password ? 'text' : 'password'"
						:append-icon="show_password ? 'visibility_off' : 'visibility'"
						@click:append="show_password = !show_password"
						tabindex="4"
						data-vv-as='Пароль'
						data-vv-name='password'
						v-validate=`'required|min:6'`
						required
						autocomplete='off'
					)
				.form-group
					v-text-field(
						v-model="form.password_confirmation"
						:error-messages="err.password_confirmation ? err.password_confirmation : errors.collect('password_confirmation')"
						:light='true'
						solo
						placeholder='Пароль еще раз'
						label="Пароль еще раз"
						:type="show_password1 ? 'text' : 'password'"
						:append-icon="show_password1 ? 'visibility_off' : 'visibility'"
						@click:append="show_password1 = !show_password1"
						tabindex="5"
						data-vv-as='Подтверждение пароля'
						data-vv-name='password_confirmation'
						v-validate='{required: true, confirmed: form.password}'
						required
					)
				hr.line
				.flex-row.f-content-center.consent
					.flex-row__col.f-content-right
						b-form-checkbox(
							v-model="form.license_agreement"
							switch
							:error-messages="err.license_agreement ? err.license_agreement : errors.collect('license_agreement')"
							data-vv-as='Согласие'
							data-vv-name='license_agreement'
							v-validate="'required'"
							required
						)

					p.text-center Я принимаю условия 
						a(:href="filesurl+'agreement.doc'") Пользовательского соглашения 
						| и даю свое согласие на обработку персональных данных на условиях и целях, определенных 
						a(:href="filesurl+'politic.doc'") политикой конфиденциальности
				.field-check-pse
					b-form-checkbox(
						v-model="form.message_possible"
						data-vv-name='message_possible'
						tabindex='-1' 
						autocomplete='off'
						switch
					)

				.flex-row.f-content-center
					.flex-row__col.f-content-center
						b-button(
							size='lg'
							variant='outline-primary'
							type='submit'
							:disabled='loading'
						) 
							span.px-3 
								|Зарегистрироваться 
								b-spinner(v-if='loading' label='Загрузка...')
</template>

<script>
export default {
  data() {
    return {
      filesurl: "/files/",
      loading: false,
      snackbar: {
        toggle: false,
        timeout: 3000,
        color: "",
        text: ""
      },

      show_password: false,
      show_password1: false,
      to_confirm: false,
      valid: false,
      err: {},

      form: {
        license_agreement: false,
        name: "",
        email: "",
        phone: "",
        password: "",
        password_confirmation: "",
        message_possible: false
      }
    };
  },
  methods: {
    registerSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.formSend();
          return;
        }
      });
    },

    formSend() {
      this.err = {};
      this.loading = true;

      axios
        .post("/api/v1/register/user", this.form)
        .then(resp => {
          this.loading = false;
          this.$store.commit("setSnackbar", {
            color: "success",
            text: "Учетная запись зарегистрирована",
            toggle: true
          });
          this.$router.push({
            name: "register.confirm",
            params: { email: this.form.email }
          });
        })
        .catch(error => {
          this.printErrorOnConsole(error);
          this.err = error.response.data.errors;
          this.loading = false;
          this.$store.commit("setSnackbar", {
            color: "error",
            text: "Ошибка",
            toggle: true
          });
        });
    }
  }
};
</script>
<style scoped>
p.text-center {
  max-width: 420px;
  line-height: normal !important;
  font-size: 14px !important;
}
@media (max-width: 768px) {
  .card {
    width: 100%;
    border: none;
  }
}
.form-register--title {
  font-family: Roboto;
  font-size: 20px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 2;
  letter-spacing: normal;
  text-align: left;
  color: #707070;
  border-bottom: 2px dotted #0a0a0a99;
  margin-bottom: 33px;
}
.form-register >>> .v-input__control {
  min-height: 40px !important;
}
.form-register >>> .v-input--is-focused .v-input__slot {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16) !important;
  border-color: #cfcccc !important;
  background-color: #ffffff;
}
.form-register >>> .v-input__append-inner {
  margin-right: 5px;
}
.form-register >>> .f-content-center .btn {
  height: 55px;
  font-family: Roboto;
  font-size: 20px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 2;
  letter-spacing: normal;
  color: #0071bc;
  background-color: #fff;
  max-width: 255px;
  width: 100%;
}
.form-group {
  margin-left: auto;
  margin-right: auto;
  width: 275px;
  margin-bottom: 15px;
}
.form-register >>> .form-group input {
  font-size: 14px;
  font-family: "Roboto";
}
.form-register >>> .form-group label {
  font-size: 14px;
  font-family: "Roboto";
}
.v-text-field.d-flex.justify-content-between {
  margin-top: 0;
  padding-top: 0;
  margin-bottom: 40px;
}
.card {
  max-width: 700px;
  width: 100%;
  margin: 0 auto;
}
.form-register >>> .v-input--switch.v-input--is-dirty .v-input--switch__thumb {
  transform: translate(35px);
}
.form-register
  >>> .v-input--switch.v-input--is-dirty
  .v-input--selection-controls__ripple,
.form-register >>> .v-input--switch.v-input--is-dirty .v-input--switch__thumb {
  transform: translate(36px);
}
.form-register >>> .v-input--switch__thumb {
  width: 20px;
  height: 20px;
  top: calc(50% - 14px);
}
.form-register >>> .v-input--switch__track {
  border-radius: 16px;
  height: 13px;
  width: 50px;
  top: calc(50% - 10px);
}
.form-register >>> .v-input--switch .v-input--switch__thumb.theme--light {
  color: #b2daf5 !important;
}
.form-register >>> .theme--light.v-input--switch__track {
  color: #e6e9ec;
}
.form-register >>> .v-input--selection-controls__ripple {
  border-radius: 50%;
  cursor: pointer;
  height: 24px;
  position: absolute;
  transition: inherit;
  width: 24px;
  left: -10px;
  top: calc(50% - 24px);
  margin: 7px;
}
.line {
  border-bottom: 2px dotted #dadada;
  border-top: none;
  margin-bottom: 25px;
  margin-left: 5px;
  margin-right: 5px;
  margin-top: 41px;
}
.form-register >>> .text-center {
  font-family: Roboto;
  font-size: 14px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 32px;
  letter-spacing: normal;
  text-align: left;
  color: #010101;
}
.flex-row.f-content-center {
  margin-top: 17px;
  margin-bottom: 50px;
}
.flex-row.f-content-center.consent {
  margin-bottom: 0;
}
.form-register
  >>> .flex-row__col.f-content-right
  .v-input--is-focused
  .v-input__slot {
  box-shadow: none !important;
}
</style>

<style lang="scss" scoped>
@import "../../../../sass/base.scss";
.form-register {
  margin: 0 auto;
}
.form-name {
  font-size: 1.8rem;
  margin-top: 0.5rem;
  color: $primary;
}
.form-register {
  /deep/ .v-input--is-focused .v-input__slot {
    border-radius: $border-radius;
  }
}
</style>
