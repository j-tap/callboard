<template lang="pug">
.card.profile-card.mb-5
	.card-body
		NewCompanyForm(:edit='true' :profile='profile')

</template>

<script>
import NewCompanyForm from '../components/NewCompanyForm'

export default {
	components: {
		NewCompanyForm,
	},
	props: {
		profile: Object
    },
	data() {
		return {

		}
	},
	methods: {},
	mounted () {},
	computed: {},
}
</script>

<style lang="scss" scope>

</style>