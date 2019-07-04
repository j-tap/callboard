<template lang="pug">
.share-social
	yandex-share(:services="['vkontakte','odnoklassniki','facebook']")

</template>

<script>
import YandexShare from '@cookieseater/vue-yandex-share'

export default {
	components: {
		YandexShare,
	},
	data () {
        return {}
	},
	methods: {},
	mounted () {}
};
</script>

<style scoped lang="scss">
@import '../../../../../sass/base';

.share-social {
	
}
</style>
