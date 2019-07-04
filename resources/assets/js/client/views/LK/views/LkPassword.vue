<template lang="pug">
.card.mb-5
	.card-body
		form.form-change-password(
			@submit.prevent='changePassword'
		)
			h3.form-change-password--title Изменение пароля
				span.centralized
					feather(type='settings')
			.mr-wrapper
				.form-group
					v-text-field(
						v-model="user.password_old"
						:error="err ? !!err['user.password'] : false"
						:light='true'
						solo
						label="Старый пароль"
						:type="show_password ? 'text' : 'password'"
						:append-icon="show_password ? 'visibility_off' : 'visibility'"
						@click:append="show_password = !show_password"
					)
				.form-group
					v-text-field(
						v-model="user.password"
						:error="err ? !!err['user.password'] : false"
						:light='true'
						solo
						label="Новый пароль"
						:type="show_password1 ? 'text' : 'password'"
						:append-icon="show_password1 ? 'visibility_off' : 'visibility'"
						@click:append="show_password1 = !show_password1"
					)
				.form-group
					v-text-field(
						v-model="user.password_confirmation"
						:error="err ? !!err['user.password'] : false"
						:light='true'
						solo
						label="Подтвердите новый пароль"
						:type="show_password2 ? 'text' : 'password'"
						:append-icon="show_password2 ? 'visibility_off' : 'visibility'"
						@click:append="show_password2 = !show_password2"
					)
			.v-text-field.d-flex.justify-content-between
				.text-center
					b-button(variant='primary' type='submit') 
						span.px-3 Сохранить

</template>

<script>
export default {
  name: "LkPassword",
  data() {
    return {
      show_password: false,
      show_password1: false,
      show_password2: false,
      user: {
        password_old: "",
        password: "",
        password_confirmation: ""
      },
      err: null
    };
  },
  methods: {
    changePassword() {
      this.err = [];
      axios
        .post("/api/v1/user/password/change", this.user)
        .then(resp => {
          this.$router.push({ name: "lk.profile.edit" });
        })
        .catch(err => {
          this.err = err.response.data.errors;
        });
    }
  }
};
</script>
<style scoped>
.form-change-password--title {
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
.mr-wrapper {
  margin: 0 auto;
  display: block;
  max-width: 40rem;
  padding-bottom: 10px;
}
.centralized {
  float: right;
  height: 30px;
  margin-top: 5px;
}
.form-change-password >>> .v-input__control {
  min-height: 40px !important;
}
.form-change-password >>> .v-input--is-focused .v-input__slot {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16) !important;
  border-color: #cfcccc !important;
  background-color: #ffffff;
}
.form-change-password >>> .v-input__append-inner {
  margin-right: 5px;
}
.form-change-password >>> .text-center .btn {
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
  max-width: 275px;
  margin-bottom: 15px;
}
.form-change-password >>> .form-group input {
  font-size: 14px;
  font-family: "Roboto";
}
.form-change-password >>> .form-group label {
  font-size: 14px;
  font-family: "Roboto";
}
.v-text-field.d-flex.justify-content-between {
  margin-top: 20px;
  padding-top: 0;
  margin-bottom: 20px;
}
.line {
  border-bottom: 2px dotted #dadada;
  border-top: none;
  margin-top: 49px;
  margin-bottom: 78px;
  margin-left: 5px;
  margin-right: 5px;
}
</style>
<style lang="scss" scoped>
@import "../../../../../sass/base.scss";
.form-change-password {
  /deep/ .v-input--is-focused .v-input__slot {
    border-radius: $border-radius;
  }
}
</style>
