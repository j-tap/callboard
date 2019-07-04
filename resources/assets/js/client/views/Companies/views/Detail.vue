<template lang="pug">
.companies-detail
	LkCompany(:profile='profile')

</template>

<script>
import LkCompany from '../../LK/views/LkCompany'

export default {
	components: {
		LkCompany,
	},
	props: {},
	data() {
		return {
			profile: null,
		}
	},
	methods: {
		getCompany ()
		{
			if (this.$root.profile && this.$route.params.id === this.$root.profile.profile.id) // redirect to myLK if this my profile
				this.$router.replace({name: 'lk.company'})

			axios
			.get('/api/v1/user/profile/' + this.$route.params.id)
			.then((resp) => {
				this.profile = resp.data.data

				document.title = this.profile.company.organization.name
			})
			.catch((error) => {
				this.printErrorOnConsole(error)
				this.$router.replace({ name: 'page404' })
			})
		},
	},
	mounted () {
		// if (this.$route.params.id === this.$root.profile.profile.id) // redirect to myLK if this my profile
			// this.$router.push({name: 'lk.company'})
		this.getCompany()
	},
}
</script>

<style lang="scss" scope>
.companies-detail {

}
</style>
