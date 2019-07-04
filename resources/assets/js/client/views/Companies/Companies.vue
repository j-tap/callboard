<template lang="pug">
section.container.users
	router-view

</template>

<script>
export default {
  components: {},
  data() {
    return {};
  },
  computed: {},
  methods: {},
  created() {},
  mounted() {}
};
</script>
<style scoped>
.container.users >>> .companies-detail {
  max-width: 700px;
  margin: 0 auto;
}
</style>
<style scoped>
/*  накидываем тень на контейнеры центральной части */
.container.users >>> .card.mb-5 {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
}

@media (max-width: 768px) {
  .container.users >>> .companies-detail {
    max-width: 768px;
  }
  .container.users >>> .company-img {
    border-radius: 0;
  }
  .container.users >>> .card.mb-5 {
    box-shadow: none;
    border: none;
    border-radius: 0;
  }
  .container.users {
    padding-left: 0px;
    padding-right: 0px;
  }
}
</style>
<style lang="scss" scoped>
@import "../../../../sass/base.scss";

.container.users {
  /deep/ .card.mb-5 {
    border-radius: $border-radius;
  }
}
</style>