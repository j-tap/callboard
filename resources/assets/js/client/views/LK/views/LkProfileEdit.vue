<template lang="pug">
.card.mb-5
	.card-body
		form.form-edit-profile(
			@submit.prevent='validateBeforeSubmit'
			v-if='profile'
		)
			h3.form-edit-profile--title Редактирование профиля tamtem
				span.centralized
					feather(type='settings')
					
			.mr-wrapper
				.form-group
					v-text-field(
					v-model='form.name'
					solo
					:light='true'
					placeholder='Имя'
					data-vv-as='Имя'
					data-vv-name='name'
					v-validate=`'required'`
					:error-messages=`err.name ? err.name : errors.collect('name')`
				)

				.form-group
					v-text-field(
					v-model='form.phone'
					solo
					:light='true'
					placeholder='(000) 000-00-00'
					data-vv-as='Телефон'
					data-vv-name='phone'
					mask='(###) ###-##-##'
					prefix="+7"
					:error-messages=`err.phone ? err.phone : ''`
				)
				.change-pass.mb-4
					router-link(:to="{ name: 'lk.profile.password', params: {} }" class='btn btn-link') Изменить пароль
			hr.line
			.mr-wrapper
				.image-uploading-wrapper
					.form-group.image-uploader(:style="addbackground()")
						b-form-file(
						title='Загрузите свой аватар'
						v-model='form.photo'
						placeholder='Выберите фотографию'
						data-vv-as='Фото'
						data-vv-name='photo'
						v-validate=`'isImage'`
				@input="transformFile"
						:inputClass=`(errors.first('photo')) ? 'is-invalid' : ''`
						:class=`(errors.has('photo')) ? 'is-invalid' : ''`
						)
						.invalid-feedback {{ errors.first('photo') }}
					p Добавьте вашу фотографию	
			hr(class="line line-1")

			.v-text-field.d-flex.justify-content-between.save-wrapper
					.text-center
						b-button(variant='primary' type='submit' :disabled='loading') 
							span.px-3 
								span Сохранить
								b-spinner(v-if='loading' label='Загрузка...')

</template>

<script>
import { Validator } from "vee-validate";

export default {
  // props: ["err"],
  data() {
    return {
      loading: false,
      err: {},
      form: {
        name: null,
        phone: null,
        photo: null
      },
      base64Img: null,
      formData: new FormData()
    };
  },
  props: {
    profile: Object
  },
  methods: {
    addbackground() {
      var res =
        "background:#e6e9ec url('/images/no-photo.svg') repeat scroll 0 0 border-box";
      var old = "";
      old = this.profile.profile.photo;
      if (old && old.length > 0) {
        res = "background: url(" + old + "); background-size:100%;";
      } else {
      }
      if (this.base64Img) {
        res =
          "background: rgba(0,0,0,0) url(" +
          this.base64Img +
          ") repeat scroll 0% 0% / 100% auto;";
      }
      return res;
    },
    transformFile(file) {
      var app = this;

      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function() {
        app.base64Img = reader.result;
      };
      reader.onerror = function(error) {
        this.printErrorOnConsole(error);
      };
    },
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.err = {};

          for (let key in this.form) {
            if (this.form[key]) this.formData.set(key, this.form[key]);
          }

          this.profileUpdate();
        }
      });
    },
    profileUpdate() {
      this.loading = true;
      axios
        .post("/api/v1/user/update", this.formData, {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(resp => {
          this.loading = false;
          if (resp.data.error) {
            this.err = resp.data.error;
          } else {
            this.$store.commit("setProfile", { profile: resp.data.data });
            this.$emit("profileUpdateEmit");
            this.$router.push({ name: "lk.profile" });
          }
        })
        .catch(error => {
          this.printErrorOnConsole(error);
          this.loading = false;
          this.err = error.response.data.errors;
        });
    },
    deleteImg() {
      axios
        .post("/api/v1/user/deletephoto", { path: this.profile.profile.photo })
        .then(resp => {
          if (resp.data.result) {
          }
        })
        .catch(error => {
          this.printErrorOnConsole(error);
          this.err = error.response.data.errors;
        });
    },
    updateFields() {
      if (this.profile) {
        this.form.name = this.profile.profile.name;
        this.form.phone = this.profile.profile.phone;
      }
    }
  },
  mounted() {
    if (this.profile) {
      this.updateFields();
    }

    Validator.extend("isImage", {
      getMessage: field => "Разрешены только изображения",
      validate: value => {
        const extArr = ["png", "jpg", "jpeg", "gif", "bmp"];
        const ext = value.name.split(".").pop();
        if (extArr.indexOf(ext) === -1) return false;
        else return true;
      }
    });
  },
  watch: {
    profile: function(newVal, oldVal) {
      this.updateFields();
    }
  }
};
</script>
<style scoped>
@media (max-width: 350px) {
  h3 span.centralized {
    display: none;
  }
}
.form-group
  >>> .v-input.v-text-field
  .v-input__control
  .v-input__slot
  input::placeholder {
  color: #c1c1c1 !important;
}
.form-edit-profile--title {
  font-family: Roboto;
  font-size: 16px;
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
.form-edit-profile >>> .v-input__control {
  min-height: 40px !important;
}
.form-edit-profile >>> .v-input--is-focused .v-input__slot {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16) !important;
  border-color: #cfcccc !important;
  background-color: #ffffff;
}
.change-pass {
  font-family: Roboto;
  font-size: 16px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 2.81;
  letter-spacing: normal;
  text-align: center;
  color: #0071bc;
}
.line {
  border-bottom: 2px dotted #dadada;
  border-top: none;
  margin: 0;
  margin-bottom: 22px;
  margin-left: 5px;
  margin-right: 5px;
}
.image-uploading-wrapper {
  margin: 0 auto;
  display: block;
  max-width: 360px;
  position: relative;
  margin-top: 32px;
  margin-bottom: 37px;
}
.image-uploading-wrapper p {
  object-fit: contain;
  font-family: Roboto;
  font-size: 14px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  letter-spacing: normal;
  text-align: center;
  color: #c1c1c1;
  margin-top: 14px;
}
.image-uploading-wrapper .custom-file {
  position: absolute;
  opacity: 0;
  height: 100%;
  padding: 0;
}
.image-uploading-wrapper >>> .custom-file-input {
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  opacity: 0;
  overflow: hidden;
}

.form-group.image-uploader {
  width: 142px;
  height: 142px;
  border-radius: 10px;
  border: solid 1px #e6e9ec;
  margin: 0 auto;
  background-color: #e6e9ec;
  background-repeat: no-repeat !important;
  background-position: center !important;
  position: relative;
}
.form-edit-profile >>> .text-center .btn {
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
.save-wrapper {
  padding-top: 0;
  margin-top: 55px;
  margin-bottom: 55px;
}
.form-group {
  margin-left: auto;
  margin-right: auto;
  max-width: 275px;
  margin-bottom: 15px;
}
</style>


<style lang="scss" scoped>
@import "../../../../../sass/base.scss";
.user-avatar {
  max-width: 20rem;
}
.form-edit-profile {
  /deep/ .v-input--is-focused .v-input__slot {
    border-radius: $border-radius;
  }
}
.form-group.image-uploader {
  border-radius: $border-radius;
}
</style>