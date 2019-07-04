<template lang="pug">
div
	.flex-row.icon__letter.f-content-center.mb-3
		.flex-row__col
			lettersvg
	p.text-center На {{$route.params.email}} отправлено письмо для активации аккаунта
	p.text-center.mb-5 Откройте письмо и перейдите по ссылке
	//- router-link(:to="{name: 'home'}" class="flex-box f-content-center f-align-center") На главную

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
