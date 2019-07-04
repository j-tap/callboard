<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 36 24"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-778.5-199.5h1241v269h-1241z" />
    <path fill="#F4D03C"
          d="M0 0h36v24H0z" />
    <path fill="#FCDB54"
          d="M15.042 12.055h6.003L36 24H0z" />
    <path fill="#FFE680"
          d="M18 15L36 0H0z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Letter'
    },
    width: {
      type: [Number, String],
      default: 36
    },
    height: {
      type: [Number, String],
      default: 24
    },
    iconColor: {
      type: String,
      default: 'currentColor'
    }
  }
}
</script>

<style lang="css">
</style>
