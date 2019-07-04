<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 20 20"
     :aria-labelledby="iconName">
  
  <path fill="none"
        fill-rule="evenodd"
        stroke="#1A89FF"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M1 9.526L19 1l-8.526 18-1.895-7.579z" />
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'navDirection'
    },
    width: {
      type: [Number, String],
      default: 20
    },
    height: {
      type: [Number, String],
      default: 20
    },
    iconColor: {
      type: String,
      default: '#1A89FF'
    }
  }
}
</script>

<style scoped>

</style>
