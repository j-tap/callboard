<template lang="pug">
section.container.content-lk
	.row(v-if='$root.profile')
		.col-lg-3.d-none.d-lg-block
			Aside
				LkNavigation

		.col-md-12.col-lg-9.col-content.position-relative
			router-view(
				@profileUpdateEmit='loadProfile' 
				:profile='profile'
			)

			Loader(v-show='this.loading')

	div.position-relative(v-else)
		router-view(
			@profileUpdateEmit='loadProfile'
			:profile='profile'
		)

		Loader(v-show='this.loading')

</template>

<script>
import Aside from "../GeneralComponents/components/Aside";
import LkNavigation from "./components/LkNavigation";

export default {
  components: {
    Aside,
    LkNavigation
  },
  data() {
    return {
      proAccount: true,
      loading: false,
      supplier: true,
      profile: null,
      isAccessOpen: false,
      snackbar: {
        toggle: false,
        timeout: 3000,
        color: "",
        text: ""
      },
      err: null,
      errMedia: {}
    };
  },
  mounted() {
    this.loadProfile();
  },
  methods: {
    async loadProfile() {
      this.profile = this.$store.state.profile;
      // this.profile = await Api.loadProfile()
      this.$root.profile = this.profile;
    },
    getBillPay(data) {
      axios
        .post("/api/v1/paymentservice/get/score", {
          params: {
            unique_id: this.profile.profile.unique_id,
            summ: parseInt(data.price, 10)
          }
        })
        .then(resp => {
          if (resp.data.result && resp.data.result === true) {
            this.paylink = resp.data.link;
            // this.scoreNumber = resp.data.scoreNumber
            this.$store.commit("setSnackbar", {
              color: "success",
              text: "Счёт сформирован",
              toggle: true
            });
            window.open(this.paylink, "_blank").focus();
            if (window.isProdMode)
              window.ym(53902132, "reachGoal", "create_schet"); // Выставить счет
          } else {
            this.printErrorOnConsole(
              "Произошла ошибка, попробуйте позднее",
              "warning"
            );
            this.$store.commit("setSnackbar", {
              color: "success",
              text: "Произошла ошибка, попробуйте позднее",
              toggle: true
            });
          }
        })
        .catch(error => {
          this.printErrorOnConsole(error);
        });
    }
  },
  computed: {},
  beforeRouteEnter(to, from, next) {
    next(vm => {
      //if (vm.$root.profile.company.organization.status == 'approve' || !vm.$root.profile) {
      next();
      //} else {
      //next({name: 'map.categories'});
      // }
    });
  }
};
</script>
<style scoped>
/*  накидываем тень на контейнеры центральной части */
.col-content >>> .card {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
}

@media (max-width: 768px) {
  .col-md-12.col-lg-9 >>> .card.mb-5 {
    box-shadow: none;
    border: none;
    border-top-color: currentcolor;
    border-top-style: none;
    border-top-width: medium;
    border-top: 0.2rem dotted #dadada;
    border-radius: 0;
    padding-top: 10px;
  }
  .col-md-12.col-lg-9 {
    padding-left: 0px;
    padding-right: 0px;
  }
}
</style>

<style lang="scss" scoped>
@import "../../../../sass/base.scss";
.col-content {
  /deep/ .card {
    border-radius: $border-radius;
  }
}
</style>
