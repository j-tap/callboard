<template lang="pug">
.card.mb-5.lk-profile
	.card-body
		.profile(v-if='profile')
			.row
				.col.col-ava
					.profile-img
						img(
							v-if='profile.profile.photo'
							:src='profile.profile.photo' 
							alt=' '
						)
						img(
							v-else
							src='/images/no-photo.svg' 
							alt=' '
						)
					dl.d-none.new-profile-class.profile-info(v-if='isMy')
								dt id
								dd {{profile.profile.unique_id}}	
				.col.col-data(:class='{"myCab" : isMy}')
					router-link(
						v-if='isMy'
						:to="{ name: 'lk.profile.edit', params: {} }" 
						class="profile-settings"
					)
						feather(type='settings')
					.clearfix
					.profile-company(v-if='profile.profile.is_org_created') {{profile.company.organization.name}}
					
					.profile-name {{profile.profile.name}}
				
					.row.up.clearfix.d-none.d-md-block
						.col-md-12.col-data-right.added-class
							router-link(
								v-if='profile && !profile.profile.is_org_created && isMy'
								:to="{ name: 'lk.company.create', params: {} }" 
								class='btn btn-primary profile-create-company'
							) Создать компанию
							router-link(
								v-if='profile && profile.profile.is_org_created'
								:to="{name: 'companies.detail', params: {id: profile.profile.id}}" 
								class='btn btn-primary profile-create-company profile-view-company'
							) Информация о компании
					.row.down.clearfix         
						.col-md-12
							UserInfoScore(clsLike='text-success' class='mb-5')
							dl.new-profile-class.profile-info(v-if='isMy')
								dt Ваш id
								dd {{profile.profile.unique_id}}
							//.profile-subscribe(v-if='!isMy && this.$root.profile')
								feather(type='pocket')
								span Подписаться на продавца  
				.col.col-contacts.d-md-none(v-if="this.$root.profile")
					dl.profile-contacts
								dt email:
								dd 
									a(:href=`'mailto:'+ profile.profile.email`) {{profile.profile.email}}
					dl.profile-contacts
								dt(v-if='profile.profile.phone') Телефон:
								dd(v-if='profile.profile.phone') {{phoneFormat(profile.profile.phone)}}
				.col.col-data.d-md-none(v-else)
					p Чтобы увидеть контакты необходимо войти
				//.col.col-subscribe.d-none(v-if='!isMy && this.$root.profile')
					.profile-subscribe
								feather(type='pocket')
								span Подписаться на продавца	 			         
			.row.d-md-none.company-info
				.col
					router-link(
								v-if='profile && !profile.profile.is_org_created && isMy'
								:to="{ name: 'lk.company.create', params: {} }" 
								class='btn company-link'
							) Создать компанию
					router-link(
								v-if='profile && profile.profile.is_org_created'
								:to="{name: 'companies.detail', params: {id: profile.profile.id}}" 
								class='btn company-link'
							) Информация о компании						
			.profile-data.d-none.d-md-block(v-if='this.$root.profile')
				.row
					.col.col-ava
						span Контакты 
					.col
						.col-md-12
							dl.profile-contacts
								dt email:
								dd 
									a(:href=`'mailto:'+ profile.profile.email`) {{profile.profile.email}}
							dl.profile-contacts
								dt(v-if='profile.profile.phone') Телефон:
								dd(v-if='profile.profile.phone') {{phoneFormat(profile.profile.phone)}}

			p.d-none.d-md-block(v-else) Чтобы увидеть контакты необходимо войти

</template>

<script>
import UserInfoScore from "../../GeneralComponents/components/UserInfoScore";

export default {
  components: {
    UserInfoScore
  },
  props: {
    profile: Object
  },
  data() {
    return {};
  },
  computed: {
    isMy() {
      return (
        this.profile &&
        this.$root.profile &&
        this.profile.profile.id === this.$root.profile.profile.id
      );
    }
  },
  methods: {},
  mounted() {}
};
</script>

<style scoped>
@media (max-width: 552px) {
  .col {
    max-width: 290px !important;
    width: 100% !important;
    display: block !important;
    margin: 0 auto !important;
    padding: 0 1rem;
  }
  .col-ava {
    margin-top: 10px !important;
  }
  .col-data {
    text-align: center;
    position: initial;
    margin-top: 10px !important;
    border-right: none !important;
    margin-bottom: 20px !important;
  }
  .col-subscribe {
    padding-top: 20px;
    border-top: 0.2rem dotted #c1c1c1;
    max-width: 100% !important;
  }
  .col-contacts {
    border-top: 0.2rem dotted #c1c1c1;
    padding-left: 25px !important;
    padding-top: 10px !important;
  }
  .profile-contacts {
    font-size: 18px;
  }
  .down {
    display: none;
  }
  .profile > .row {
    display: block;
  }
  .profile-img {
    margin: 0 auto;
    width: 130px !important;
    height: 130px !important;
    border-radius: 1rem;
  }

  .profile-company,
  .profile-name {
    text-align: center !important;
  }
  .d-none.new-profile-class.profile-info {
    display: block !important;
    float: none;
    text-align: center;
  }
  .profile-settings {
    position: absolute;
    right: 15px;
    top: 5px;
  }
  .profile-subscribe {
    float: none !important;
    text-align: center;
  }
}
@media (max-width: 769px) {
  .profile > .row {
    border-bottom: 0.2rem dotted #c1c1c1;
    padding-bottom: 20px;
  }
  .col.col-contacts.d-md-none {
    display: block !important;
  }
  .row.up {
    display: none !important;
  }
  .row.company-info {
    display: block !important;
    text-align: center;
    border: none !important;
    padding-top: 20px;
  }
  .profile-img {
    margin: 0 auto;
  }
  .profile-company,
  .profile-name {
    text-align: center;
  }
  .row.down {
    position: absolute;
    width: max-content;
    bottom: -35px;
  }
  .profile-settings {
    position: absolute;
    top: 0;
    right: 10px;
  }
  .col-ava {
    margin-bottom: 0;
    max-width: 21rem !important;
  }
  .company-link {
    height: auto;
    font-family: Roboto;
    font-size: 16px;
    font-weight: normal;
    font-style: normal;
    font-stretch: normal;
    line-height: 2;
    letter-spacing: normal;
    color: #0071bc;
    background-color: #fff;
    max-width: 255px;
    width: 100%;
    border: 1px solid #0071bc;
  }
  .col-data {
    margin-right: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    max-width: 30%;
    border-bottom: none;
    border-right: 0.2rem dotted #c1c1c1;
  }
  .col-data.myCab {
    position: inherit;
  }
  .col-data.myCab .row.down {
    display: none !important;
  }
  .profile-data {
    display: none !important;
  }
  .d-none.new-profile-class.profile-info {
    display: block !important;
    float: none;
    text-align: center;
  }
}
</style>

<style scoped>
.myCab .row.down {
  margin-top: 0;
}
.profile-subscribe {
  margin-bottom: 0;
  float: right;
}
.up {
  margin-top: -25px;
}
.down {
  margin-top: 20px;
}
.col-ava {
  max-width: 15.2rem;
}
.profile-img {
  width: 14.2rem;
  height: 14.2rem;
}
.profile-img img {
  max-width: 100%;
  max-height: 100%;
  min-width: 1px;
  min-height: 1px;
}
.col-data {
  margin-right: 10px;
}
.profile-settings {
  margin-top: 5px;
  margin-right: -5px;
}
.profile-company {
  font-family: Roboto;
  font-size: 20px;
  font-weight: 500;
  text-align: left;
  color: #010101;
  margin-top: 0;
  margin-bottom: 5px;
  display: block;
}
.profile-name {
  font-family: Roboto;
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  letter-spacing: normal;
  text-align: left;
  color: #707070;
  margin-bottom: 0;
}
.profile-info {
  overflow: hidden;
  padding: 0;
  margin: 0;
  font-family: Roboto;
  font-size: 14px;
  text-align: left;
  color: #cfcccc;
}
.new-profile-class {
  float: right;
  width: auto;
  margin-top: 10px;
}
.profile-info dt,
.profile-info dd {
  margin: 0;
  margin-right: 5px;
  display: inline;
  float: none;
}
.profile-contact dt {
  font-size: 18px;
}
.profile-contacts dd a {
  color: inherit !important;
}
.profile-create-company {
  margin-bottom: 0;
}
.profile-data .col.col-ava {
  margin-left: -1.5rem;
  height: 14.2rem;
  max-width: 14rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-right: 0.2rem dotted #c1c1c1;
}
.profile-data .col.col-ava span {
  font-family: Roboto;
  font-size: 18px;
  text-align: left;
  color: #c1c1c1;
}
</style>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.col-ava {
  max-width: 22rem;
  margin-bottom: 3rem;
}
.col-data {
  border-bottom: 0.2rem dotted $gray;
  padding-bottom: 1rem;
  margin-bottom: 3rem;
  margin-right: 3rem;
  padding-right: 0;

  &-right {
    text-align: right;
  }
}
.profile {
  &-img {
    position: relative;
    display: block;
    overflow: hidden;
    width: 22rem;
    height: 22rem;
    margin: -1.5rem 0 0 -1.5rem;
    border-radius: $border-radius 0 $border-radius 0;

    img {
      @include imgAbsCenter();
    }
  }
  &-settings {
    float: right;
    color: $primary;
    margin-top: 0.5rem;
  }
  &-company {
    color: $primary;
    font-size: 3rem;
    font-weight: 500;
    line-height: 1;
    margin: 0 0 1rem;
  }
  &-name {
    color: $text-gray;
    font-size: 2.4rem;
    margin: 0 0 1rem;
  }
  &-create-company {
    border-bottom-left-radius: 0;
    margin: 0 0 3rem;
  }
  &-view-company {
    background-color: #b2daf5;
    border-color: #b2daf5;
    color: #010101;
    margin-top: -1rem;
  }
  &-info {
    font-size: 1.8rem;
    width: 100%;
    overflow: hidden;
    padding: 0;
    margin: 0;

    dt,
    dd {
      float: left;
      width: 50%;
      padding: 0;
      margin: 0 0 1rem;
    }
    dt {
      color: $gray;
      font-weight: 400;
    }
    dd {
      color: $text-gray;
    }
  }
  &-subscribe {
    cursor: pointer;
    color: $text-gray;
    text-decoration: none;
    font-size: 1.4rem;
    margin-bottom: 1rem;

    .feather {
      width: 2rem;
      height: 2rem;
      vertical-align: middle;
      margin-right: 0.5rem;
    }
  }
  &-data {
    margin: 0 1.5rem;
  }
  &-contacts {
    display: block;
    color: $text-gray;
    font-size: 2rem;
    padding: 0;
    margin: 0;

    dt,
    dd {
      display: block;
      margin: 0;
      padding: 0;
    }
    dt {
      font-weight: 600;
      padding-right: 1rem;
    }
    dd {
      margin-bottom: 1.5rem;
    }
  }
}
</style>
