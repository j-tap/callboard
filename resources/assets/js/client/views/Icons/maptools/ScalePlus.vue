<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 15 16"
     :aria-labelledby="iconName">
  
  <g fill="#1A89FF"
     fill-rule="evenodd">
    <rect width="15"
          height="2"
          y="7"
          rx="1" />
    <rect width="15"
          height="2"
          y="7"
          rx="1"
          transform="rotate(-90 7.5 8)" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'scalePlus'
    },
    width: {
      type: [Number, String],
      default: 15
    },
    height: {
      type: [Number, String],
      default: 16
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
