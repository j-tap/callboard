<template lang="pug">
div.text-center
	h4 Ваша почта успешно подтверждена.
	p.mb-5 Теперь вы можете войти.
	b-btn(v-b-modal="'modalSignin'" variant='primary') Войти

</template>

<script>
export default {
	data() {
		return {}
	},
	mounted () {
		if (window.isProdMode) window.ym(53902132, 'reachGoal', 'registration_button_ok')
	},
}
</script>

<style lang="scss">

</style>
