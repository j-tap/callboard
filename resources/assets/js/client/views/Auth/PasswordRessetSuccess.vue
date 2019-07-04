<template lang="pug">
div.text-center
	h4 Ваш пароль успешно сброшен.
	p.mb-5 Теперь вы можете войти с новым паролем из письма.
	b-btn(v-b-modal="'modalSignin'" variant='primary') Войти

</template>

<script>
export default {
	data() {
		return {}
	},
}
</script>

<style lang="scss">

</style>
