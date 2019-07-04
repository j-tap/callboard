<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 15 2"
     :aria-labelledby="iconName">
  
  <rect width="15"
        height="2"
        fill="#1A89FF"
        fill-rule="evenodd"
        rx="1" />
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'scaleMinus'
    },
    width: {
      type: [Number, String],
      default: 15
    },
    height: {
      type: [Number, String],
      default: 2
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
