<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 24 16"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-212.5-26.5h312v140h-312z" />
    <path fill="#F4D03C"
          d="M0 0h24v16H0z" />
    <path fill="#FCDB54"
          d="M10.028 8.037h4.002L24 16H0z" />
    <path fill="#FFE680"
          d="M12 10L24 0H0z" />
    <path d="M-13-17h50v50h-50z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Mail'
    },
    width: {
      type: [Number, String],
      default: 24
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
