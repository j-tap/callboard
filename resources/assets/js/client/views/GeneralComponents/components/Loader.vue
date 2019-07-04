<template lang="pug">
.loader
	v-progress-circular(
		:size="86"
		color="#1a89fe"
		indeterminate
	)
</div>
</template>

<script>
    export default {
        name: "Loader"
    }
</script>

<style lang="scss" scope>
@import '../../../../../sass/base';

.loader {
    position: absolute;
    z-index: 99;
    left: 0;
	right: 0;
	 top: (-$header-main-space);
	bottom: (-$header-main-space);
    background-color:rgba(255,255,255,.7);
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>