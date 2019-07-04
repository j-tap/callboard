<template lang="pug">
.goback(v-if='isBack' :class='cls')
	a(@click='$router.go(-1)' href='javascript:void(0)')
		feather(type='arrow-left')
		

</template>

<script>
export default {
  data() {
    return {};
  },
  props: {
    cls: String
  },
  computed: {
    isBack() {
      return window.history.length > 2;
    }
  }
};
</script>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.goback {
  position: absolute;
  left: -7rem;
  top: 0;
  opacity: .5;

  &.bids-list {
    top: 4rem;
  }
  &.register-form {
    left: 15rem;
  }
  &.companies-detail {
    left: 15rem;
  }
  &.users-profile {
    left: 15rem;
  }
  a {
    display: flex;
    width: 4.2rem;
    height: 3.5rem;
    line-height: 4rem;
    border: solid .2rem $primary;
    text-align: center;
    color: $primary;
    border-radius: $border-radius;
    align-items: center;
    justify-content: center;

    :hover,
    :focus {
      color: $primary;
    }
    .feather {
      width: 2.5rem;
      height: 2.5rem;
    }
  }
}
</style>