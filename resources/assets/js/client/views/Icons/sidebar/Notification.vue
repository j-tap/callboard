<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 20 20"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path d="M-25-16h70v50h-70z" />
    <path :stroke="iconColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M18 13.752H1a2.55 2.55 0 0 0 2.55-2.55v-4.25a5.95 5.95 0 1 1 11.9 0v4.25a2.55 2.55 0 0 0 2.55 2.55zm-7.03 3.4a1.7 1.7 0 0 1-2.94 0h2.94z" />
    <path :stroke="iconColor"
          d="M-190.5-30.5h833v95h-833z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'notifications'
    },
    width: {
      type: [Number, String],
      default: 18
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
a:hover path {
  stroke: white
}
</style>
