<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 7 14"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path :stroke="iconColor"
          d="M-220.5-56.5h1167v626h-1167z" />
    <path :stroke="iconColor"
          d="M-199.5-11.5h721v200h-721z" />
    <path :fill="iconColor"
          d="M4.655 14V7h2.07L7 4.586H4.655l.003-1.208c0-.63.064-.966 1.033-.966h1.294V0h-2.07C2.425 0 1.55 1.17 1.55 3.138v1.449H0v2.412h1.55V14h3.105z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'facebook'
    },
    width: {
      type: [Number, String],
      default: 7
    },
    height: {
      type: [Number, String],
      default: 14
    },
    iconColor: {
      type: String,
      default: '#FFF'
    }
  },
}
</script>

<style scoped>

</style>
