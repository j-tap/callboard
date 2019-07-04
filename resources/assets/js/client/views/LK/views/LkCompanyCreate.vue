<template lang="pug">
.card.profile-card.mb-5
	.card-body
		NewCompanyForm(:edit='false')

</template>

<script>
import NewCompanyForm from "../components/NewCompanyForm";

export default {
  components: {
    NewCompanyForm
  },
  data() {
    return {};
  },
  methods: {},
  mounted() {
    if (this.$root.profile.profile.is_org_created)
      this.$router.push({ name: "lk.company.edit" });
  },
  computed: {}
};
</script>

<style lang="scss" scope>
</style>