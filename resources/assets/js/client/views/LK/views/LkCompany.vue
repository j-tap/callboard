<template lang="pug">
.card.mb-5
	.card-body
		.company(
			v-if='profile && profile.profile.is_org_created'
		)
			.company-img
				img(
					v-if='profile.company.organization.media.image_1'
					:src='profile.company.organization.media.image_1' 
					alt=' '
				)
				img(
					v-else
					class="no-photo"
					src='/images/no-photo.svg' 
					alt=' '
				)
				.company-img-category
					span(
						:class=`'tile ' + (profile.company.categories[0].cl_background)` 
						:title='profile.company.categories[0].name'
					)
						component(:is='profile.company.categories[0].cl_icon')

			.company-data
				router-link(
					v-if='isMy'
					:to="{ name: 'lk.company.edit', params: {} }" 
					class="company-settings"
				)
					feather(type='settings')

				h1.company-name {{profile.company.organization.name}}
				dl.company-dl.clearfix(v-if='this.$root.profile')
					dt ИНН
					dd {{profile.company.organization.inn}}
					template(v-if="profile.company.organization.kpp")
						dt КПП
						dd {{profile.company.organization.kpp}}
					template(v-else)
						template(v-if="isMy")
							dt КПП
							dd
								router-link(class="edit-link" :to="{name: 'lk.company.edit', params: {} }") укажите при редактировании 	
					dt Телефон
					dd {{profile.company.contact_phone}}
					template(v-if="profile.company.organization.director")
						dt Директор:
						dd {{profile.company.organization.director}}
					template(v-else)
						template(v-if="isMy")
							dt Директор:
							dd
								router-link(class="edit-link" :to="{name: 'lk.company.edit', params: {} }") укажите при редактировании	
					dt Город:
					dd {{profile.company.city.name}}
					template(v-if="profile.company.organization.address")
						dt Адрес:
						dd {{profile.company.organization.address}}
					template(v-else)
						template(v-if="isMy")
							dt Адрес:
							dd
								router-link(class="edit-link" :to="{name: 'lk.company.edit', params: {} }") укажите при редактировании				
				p(v-else) Чтобы увидеть контакты необходимо войти
			.company-data
				hr
				h3.description-title(v-if='profile.company.organization.products') Краткое описание компании
				article(v-if='profile.company.organization.products') {{profile.company.organization.products}}

				h3.description-title(v-if='profile.company.organization.description') О компании
				article(v-if='profile.company.organization.description') {{profile.company.organization.description}}

		p(v-else) Компания не создана

</template>

<script>
export default {
  props: {
    profile: Object
  },
  data() {
    return {};
  },
  computed: {
    isMy() {
      return (
        this.$root.isAuth &&
        this.profile.profile.id === this.$store.state.profile.profile.id
      );
    }
  },
  methods: {},
  mounted() {},
  watch: {
    profile: function(newVal, oldVal) {
      if (this.$root.profile) {
        if (newVal && newVal.profile.id === this.$store.state.profile.profile.id)
          // if current user
          this.$router.push({ name: "lk.company" });
        else if (newVal && newVal.profile.is_org_created === 0)
          // if company is not created
          this.$router.push({ name: "lk.profile" });
      }
    }
  }
};
</script>
<style scoped>
.edit-link {
  font-family: Roboto;
  font-size: 16px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  letter-spacing: normal;
  text-align: left;
  color: #010101;
}
</style>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.company {
  position: relative;

  &-img {
    position: relative;
    display: block;
    overflow: hidden;
    width: auto;
    height: 22rem;
    margin: -1.5rem -1.5rem 2rem -1.5rem;
    border-radius: $border-radius $border-radius 0 0;

    img {
      @include imgAbsCenter();
    }
    img.no-photo {
      width: 100%;
      transform: none;
      height: 90%;
      left: 0;
      top: 5%;
    }
    &-category {
      position: absolute;
      top: 2rem;
      right: 2rem;
    }
  }
  &-data {
    margin: 1.5rem 0 1.5rem;

    &-right {
      text-align: right;
    }
    hr {
      border-top: 0.2rem dotted #c1c1c1;
    }
    h3 {
      font-family: Roboto;
      font-size: 18px;
      font-weight: 500;
      font-style: normal;
      font-stretch: normal;
      line-height: 1.22;
      letter-spacing: normal;
      text-align: left;
      color: #010101;
      margin-bottom: 12px;
      margin-top: 20px;
    }
  }
  &-settings {
    float: right;
    color: $primary;
    margin-top: 0px;
  }
  &-name {
    font-family: Roboto;
    font-size: 20px;
    font-weight: 500;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.2;
    letter-spacing: normal;
    text-align: left;
    color: #010101;
    margin: 0 0 1.5rem;
  }
  &-dl {
    font-size: 1.6rem;

    dt,
    dd {
      float: left;
      margin-bottom: 0.5rem;
      font-family: Roboto;
      font-size: 16px;
      font-weight: normal;
      font-style: normal;
      font-stretch: normal;
      letter-spacing: normal;
      text-align: left;
      color: #010101;
    }
    dt {
      font-weight: 400;
      clear: both;
    }
    dd {
      margin-left: 0.5rem;
    }
  }
  // article {
  // 	border-top: .2rem dotted $gray;
  // 	padding-top: 1.5rem;
  // }
}
</style>