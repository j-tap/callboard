<template lang="pug">
.users-profile
	LkProfile(:profile='profile')

</template>

<script>
import LkProfile from "../../LK/views/LkProfile";

export default {
  components: {
    LkProfile
  },
  props: {},
  data() {
    return {
      profile: null
    };
  },
  methods: {
    getProfile() {
      if (
        this.$root.isAuth &&
        this.$route.params.id === this.$store.state.profile.profile.id
      ) {
		// redirect to myLK if this my profile
		this.$router.replace({ name: "lk.profile" })
	  }
	  else {
		axios
		.get("/api/v1/user/profile/" + this.$route.params.id)
		.then(resp => {
			this.profile = resp.data.data
			this.setTitle(this.$store.state.profile.profile.name)
		})
		.catch(error => {
			this.printErrorOnConsole(error)
			this.$router.replace({ name: 'page404' })
		})
	  }
    }
  },
  mounted() {
    this.getProfile()
  }
};
</script>
<style scoped>
.container.users >>> .companies-detail {
  max-width: 700px;
  margin: 0 auto;
}
@media (max-width: 768px) {
  .container.users .users-profile >>> .card {
    border: none !important;
  }
}
</style>

<style lang="scss" scope>
.users-profile {
}
</style>
