<template lang="pug">
ul.lk-nav(
	v-if='$root.profile'
)
	li
		router-link(:to="{name: 'lk.deals'}")
			feather(type='file-text')
			span Заявки
	li
		router-link(:to="{name: 'lk.dialogs'}")
			feather(type='message-circle')
			span
				|Сообщения
				span.badge.badge-pill.badge-danger(
					v-if="$store.state.profile.unreadMsg"
				) {{$store.state.profile.unreadMsg}}
	li
		router-link(:to="{name: 'lk.profile'}")
			feather(type='user')
			span Профиль
	li
		router-link(:to="{name: 'lk.favorites'}")
			feather(type='star')
			span Избранное
	li
		router-link(:to="{name: 'lk.wallet'}")
			feather(type="credit-card")
			span Кошелёк 
			span.float-right.mt-2 {{priceFormat($store.state.profile.profile.ballance)}}&nbsp;&#8381;
	li
		router-link(:to="{name:'lk.tarifs'}")
			feather(type="award")
			span Тарифы	и услуги			
	li(
		v-if='$store.state.profile.profile.is_org_created'
	)
		router-link(:to="{name: 'lk.company'}")
			feather(type='briefcase')
			span Компания
	li
		a(
			@click='logout' 
			href='javascript:void(0)'
		)
			feather(type='log-out')
			span Выйти
	
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    logout() {
      this.$root.logout();
      this.$router.push({
        name: "bids.list",
        query: {
          city: this.cityId,
          type_deal: "sell",
          date_created: "desc"
        }
      });
    }
  },
  mounted() {}
};
</script>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.lk-nav {
  list-style: none;
  margin: 0;
  padding: 0;

  a {
    display: block;
    padding: 1rem 3rem;
    font-size: 1.4rem;
    color: $text-gray;
    white-space: nowrap;
    line-height: 1;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;

    &:hover,
    &:focus {
      background: $light-gray;
    }
    span {
      vertical-align: middle;
      white-space: initial;
    }
    .feather {
      color: $gray;
      margin-right: 2.5rem;
      width: 2.4rem;
      height: 2.4rem;
      vertical-align: middle;

      @include media-breakpoint-down(md) {
        margin-right: 1rem;
      }
    }
    .badge {
      position: absolute;
      top: 50%;
      right: 1rem;
      margin-top: -0.8rem;
    }
  }
  .router-link-active {
    cursor: default;
    background: $light-gray;

    .feather {
      color: $primary;
    }
  }
}
</style>
