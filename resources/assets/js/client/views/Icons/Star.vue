<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 19 18"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-82.5-50.5h287v487h-287z" />
    <path fill="#FFE680"
          stroke="#FCDB54"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9.412 1l2.6 5.266 5.812.85-4.206 4.096.993 5.788-5.199-2.734L4.213 17l.993-5.788L1 7.116l5.813-.85z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'favourites'
    },
    width: {
      type: [Number, String],
      default: 19
    },
    height: {
      type: [Number, String],
      default: 18
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
