<template lang="pug">
form.form-company(
	@submit.prevent='validateBeforeSubmit'
)
	h3.form-company--title.redacted(v-if='edit') Редактирование компании
		span.centralized
			feather(type='settings')
	h3.form-company--title(v-else) Создание компании
	.image-uploading-wrapper
		.form-group.image-uploader(:style="addbackground()")
		b-form-file(
			v-model='form.image_1'
			placeholder='Выберите фотографию'
			data-vv-as='Фото'
			@input="transformFile"
			data-vv-name='image_1'
			v-validate=`'isImage'`
			:inputClass=`(errors.first('image_1')) ? 'is-invalid' : ''`
			:class=`(errors.has('image_1')) ? 'is-invalid' : ''`
		)
		.invalid-feedback {{ errors.first('image_1') }}
	p.image-uploading-wrapper-text Добавьте фото компании
	hr.line
	.mr-wrapper
		.form-group
			p(v-if="edit").desc-info.input-info ИНН
			v-text-field(
				v-model='form.org_inn'
				solo
				:light='true'
				@keypress='onlyNumber'
				placeholder='ИНН'
				data-vv-as='ИНН'
				data-vv-name='org_inn'
				v-validate=`'required|max:12'`
				:error-messages=`err.org_inn ? err.org_inn : errors.collect('org_inn')`
			)
		.form-group(v-if='edit')
			p.desc-info.input-info КПП
			v-text-field(
				v-model='form.org_kpp'
				solo
				:light='true'
				@keypress='onlyNumber'
				placeholder='КПП'
				data-vv-as='КПП'
				data-vv-name='org_kpp'
				v-validate=`'min:7|max:9'`
				:error-messages=`err.org_kpp ? err.org_kpp : errors.collect('org_kpp')`
			)
		.form-group
			p(v-if="edit").desc-info.input-info Название компании
			v-text-field(
				v-model='form.org_name'
				solo
				:light='true'
				placeholder='Название компании'
				data-vv-as='Название компании'
				data-vv-name='org_name'
				v-validate=`'required'`
				:error-messages=`err.org_name ? err.org_name : errors.collect('org_name')`
			)
		.form-group(v-if='edit')
			p.desc-info.input-info Форма организации
			v-select(
				placeholder='Форма организации' 
				solo
				title='Форма организации'
				:items='legalformsArray' 
				v-model='form.org_legal_form_id'
				return-object
				item-value="id"
				item-text="short_name"
				@change='selectedLegalForm'
				:light='true'
				data-vv-as='Форма организации'
				data-vv-name='org_legal_form_id'
				v-validate=`'required'`
				appendIcon="expand_more"
			)
		.form-group
			p(v-if="edit").desc-info.input-info Город
			CitiesSelect(
				@setCityEmit='setCity'
				:cityName='cityName'
				:err='err'
			)  
		.form-group
			p(v-if="edit").desc-info.input-info Телефон
			v-text-field(
				v-model='form.phone'
				solo
				:light='true'
				placeholder='Телефон'
				data-vv-as='Телефон'
				data-vv-name='phone'
				mask='phone'
        v-validate=`'required'`
        prefix="+7"
				:error-messages=`err.phone ? err.phone : ''`
			)
		.form-group(v-if='edit')
			p.desc-info.input-info ФИО Директора
			v-text-field(
				v-model='form.org_director'
				solo
				:light='true'
				placeholder='ФИО Директора'
				data-vv-as='ФИО Директора'
				data-vv-name='org_director'
				:error-messages=`err.org_director ? err.org_director : errors.collect('org_director')`
			)
		.form-group(v-if='edit')
			p.desc-info.input-info Адрес
			v-text-field(
				v-model='form.org_address'
				solo
				:light='true'
				placeholder='Адрес'
				data-vv-as='Адрес'
				data-vv-name='org_address'
				:error-messages=`err.org_address ? err.org_address : errors.collect('org_address')`
			)
		.form-group.category-wrapper
			p(v-if="edit").desc-info.input-info Категории
			CategorySelect(
				@setCategoryEmit='setCategory'
				:category='category'
				:err='err'
			)
	hr.line

	.form-group.marginated
		p.desc-info Описание компании, которое будет появляться в заявках и поиске.
		v-textarea(
			placeholder='Добавьте краткое описание компании'
			solo
			v-model='form.org_products'
			:light='true'
			data-vv-as='Добавьте краткое описание компании'
			data-vv-name='org_products'
			:error-messages=`err.org_products ? err.org_products : errors.collect('org_products')`
		)

	.form-group.marginated-1
		p.desc-info Описание компании, которое будет появляться в карточке вашей компании.
		v-textarea(
			placeholder='Добавьте полное описание компании'
			solo
			v-model='form.org_description'
			:light='true'
			data-vv-as='Добавьте полное описание компании'
			data-vv-name='org_description'
			:rows="10"
			:error-messages=`err.org_description ? err.org_description : errors.collect('org_description')`
		)

	//- .form-group(v-if='edit && profile && profile.company.organization.media.image_1')
	//- 	img.company-edit-img(
	//- 		:src='profile.company.organization.media.image_1' 
	//- 		alt=' '
	//- 	)

	hr.line.line-1
	.v-text-field.d-flex.justify-content-between
		.text-center
			b-button(variant='primary' type='submit' :disabled='loading') 
				span.px-3 
					span(v-if='edit') Сохранить компанию
					span(v-else) Создать компанию
					b-spinner(v-if='loading' label='Загрузка...')

		

</template>

<script>
import { Validator } from "vee-validate";
import CategorySelect from "../../GeneralComponents/components/CategorySelect";
import CitiesSelect from "../../GeneralComponents/components/CitiesSelect";
export default {
  components: {
    CategorySelect,
    CitiesSelect
  },
  props: {
    edit: Boolean,
    profile: Object
  },
  data() {
    return {
      loading: false,
      err: {},
      cityName: null,
      form: {
        org_name: null,
        org_inn: null,
        org_kpp: null,
        org_description: null,
        image_1: null,
        org_director: null,
        org_address: null,
        phone: null,
        categories: null, // TODO: need added in interface, realized selected categories
        org_products: null,
        first_name: "a",
        second_name: "b",
        middle_name: "c",
        org_city_id: 1,
        org_address_legal: "e",
        org_legal_form_id: 1,
        offices:
          '{"address": "address", "phone": "5639429", "geo_lat": null,  "geo_lon" : null}',
        stores: '{"address": "address", "geo_lat": null,  "geo_lon" : null}'
        // org_site: '',
        // org_work_time: '',
        // video: '',
        // logo: '',
        // image_2: '',
        // image_3: '',
      },
      formData: new FormData(),
      category: null,
      base64Img: null,
      legalformsArray: null
    };
  },
  computed: {
    cancelPath() {
      return this.edit ? "lk.company" : "lk.profile";
    }
  },
  methods: {
    addbackground() {
      var res = "background: url('/images/no-photo.svg');";
      var old = "";
      if (this.profile && this.edit) {
        old = this.profile.company.organization.media.image_1;
      }
      if (old && old.length > 0) {
        res = "background: url(" + old + ");";
      } else {
      }
      if (this.base64Img) {
        res = "background: url(" + this.base64Img + ");";
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
    setCity(cityId) {
      if (cityId) this.form.org_city_id = cityId;
    },
    selectedLegalForm(legalForm) {
      this.form.org_legal_form_id = legalForm.id;
    },
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.err = {};

          for (let key in this.form) {
            if (this.form[key]) {
              switch (key) {
                case "offices":
                  this.formData.set("offices[]", this.form[key]);
                  break;
                case "categories":
                  this.formData.set("categories[]", this.form[key]);
                  break;
                case "stores":
                  this.formData.set("stores[]", this.form[key]);
                  break;
                default:
                  this.formData.set(key, this.form[key]);
                  break;
              }
            }
          }

          this.companyCreate();
        }
      });
    },
    getLegalForms() {
      axios.get("/api/v1/legalforms").then(resp => {
        this.legalformsArray = resp.data.data;
        if (this.edit && this.profile) {
          this.form.org_legal_form_id =
            this.setlegaFormId(
              this.profile.company.organization.legal_form_slug
            ) || 1;
        }
      });
    },
    companyCreate() {
      this.loading = true;
      let path = "/api/v1/organization/manage/store";
      if (this.edit) path = "/api/v1/organization/manage/update";

      axios
        .post(path, this.formData, {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(resp => {
          this.loading = false;
          if (resp.data.error) {
            this.err = resp.data.error;
          } else {
            this.$parent.$emit("profileUpdateEmit");
            if (!this.edit && window.isProdMode)
              window.ym(53902132, "reachGoal", "company_complete");
            this.$router.push({ name: this.cancelPath });
          }
        })
        .catch(error => {
          this.printErrorOnConsole(error);
          this.loading = false;
          this.err = error.response.data.errors;
        });
    },
    updateFields() {
      if (this.edit && this.profile) {
        this.cityName = this.profile.company.city.name;
        this.form.org_name = this.profile.company.organization.name;
        this.form.org_inn = this.profile.company.organization.inn;
        this.form.org_kpp = this.profile.company.organization.kpp;
        this.form.org_description = this.profile.company.organization.description;
        this.form.org_director = this.profile.company.organization.director;
        this.form.org_products = this.profile.company.organization.products;
        this.form.org_address = this.profile.company.organization.address;
        this.form.phone = this.profile.company.contact_phone;

        // this.form.image_1 = new File(
        //   this.profile.company.organization.media.image_1,
        //   this.profile.company.organization.media.image_1
        // );
        this.category = this.profile.company.categories[0];
        // for (let item in this.profile.company.categories) {
        // 	arrCat.push(item.id)
        // }
        this.setCategory(this.profile.company.categories[0].id);

        this.form.org_legal_form_id =
          this.setlegaFormId(
            this.profile.company.organization.legal_form_slug
          ) || 1;
      }
    },
    setlegaFormId(short_name) {
      var res = 1;
      if (this.legalformsArray && this.legalformsArray.length > 0) {
        res = this.legalformsArray.find(item => item.short_name == short_name)
          .id;
      }

      return res;
    },
    setCategory(category) {
      const arrCat = [];
      arrCat.push(category);
      this.form.categories = arrCat;
    }
  },
  mounted() {
    this.getLegalForms();
    this.updateFields();

    Validator.extend("isImage", {
      getMessage: field => "Разрешены только изображения",
      validate: value => {
        const extArr = ["png", "jpg", "jpeg", "gif", "bmp"];

        const ext = value.name
          ? value.name.split(".").pop()
          : value.split(".").pop();
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
/* new styles */
@media (max-width: 480px) {
  .redacted {
    font-size: 15px !important;
  }
}
@media (max-width: 768px) {
  .form-company--title {
    margin-bottom: 33px;
    padding-left: 29px;
    margin-left: -29px;

    width: calc(100% + 58px);
  }
}
.form-group >>> .v-input__control {
  min-height: 40px !important;
}
.form-company {
  padding: 8px 14px;
}
.centralized {
  float: right;
  height: 30px;
  margin-top: 5px;
  margin-right: 5px;
}
.image-uploading-wrapper {
  margin: 0 auto;
  margin-top: 0px;
  margin-bottom: 0px;
  margin-left: auto;
  display: block;
  position: relative;
  margin-top: 21px;
  margin-bottom: 5px;
  width: 100%;
  width: calc(100% + 58px);
  margin-left: -29px;
  background-color: #e6e9ec;
  height: 225px;
}
.image-uploading-wrapper-text {
  object-fit: contain;
  font-family: Roboto;
  font-size: 14px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  letter-spacing: normal;
  text-align: center;
  color: #c1c1c1;
  margin-bottom: 35px;
}
.image-uploading-wrapper .custom-file {
  position: absolute;
  left: 0;
  opacity: 0;
  width: 100%;
  padding: 0;
  top: 0;
  height: 100%;
}
.image-uploading-wrapper >>> .custom-file-input {
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  opacity: 0;
}
.desc-info {
  font-family: Roboto;
  font-size: 14px;
  text-align: left;
  color: #010101;
  margin-bottom: 10px;
}
.desc-info.input-info {
  font-size: 13px;
  color: #968080;
  margin-bottom: 0px;
  padding-left: 5px;
}
.form-group.image-uploader {
  margin: 0 auto;
  background-repeat: no-repeat !important;
  background-position: center !important;
  height: 100%;
  width: 100%;
  max-width: 100%;
}
.mr-wrapper {
  margin: 0 auto;
  display: block;
  max-width: 40rem;
  padding-bottom: 10px;
}
.marginated {
  margin-bottom: 17px;
}
.marginated-1 {
  margin-bottom: 20px;
}
.mr-wrapper .form-group {
  margin-bottom: 25px;
}
.line {
  border-bottom: 2px dotted #dadada;
  border-top: none;
  margin: 0;
  margin-bottom: 42px;
  margin-left: 5px;
  margin-right: 5px;
}
.form-company >>> .v-textarea textarea::placeholder {
  color: #c1c1c1;
}
.form-company >>> .form-control::placeholder {
  color: #c1c1c1;
}
.form-company
  >>> .v-input.v-text-field
  .v-input__control
  .v-input__slot
  input::placeholder {
  color: #c1c1c1;
}
.form-company >>> .text-center .btn {
  height: 55px;
  font-family: Roboto;
  font-size: 18px;
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
.form-company--title {
  font-family: Roboto;
  font-size: 20px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 2;
  letter-spacing: normal;
  text-align: left;
  color: #707070;
  border-bottom: 0.2rem dotted #c1c1c1;
  padding-bottom: 10px;
  margin-bottom: 33px;
}
.form-company >>> .v-input--is-focused .v-input__slot {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16) !important;
  border-color: #cfcccc !important;
  background-color: #ffffff;
}
.form-group {
  margin-left: auto;
  margin-right: auto;
  width: 275px;
  margin-bottom: 15px;
  max-width: 275px;
  width: 100%;
}
.form-company >>> .category-wrapper .v-input.mb-3 {
  margin-bottom: 30px !important;
}
.form-group.marginated,
.form-group.marginated-1 {
  width: auto;
  margin-bottom: 25px;
  max-width: 100%;
}
</style>


<style lang="scss" scoped>
@import "../../../../../sass/base.scss";

.company-edit-img {
  max-width: 100%;
}

.form-company {
  /deep/ .v-input--is-focused .v-input__slot {
    border-radius: $border-radius;
  }
}
</style>
