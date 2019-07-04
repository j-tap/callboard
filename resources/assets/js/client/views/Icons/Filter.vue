<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 24 20"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-778.5-20.5h833v95h-833z" />
    <g :stroke="iconColor"
       stroke-linecap="round"
       stroke-linejoin="round"
       stroke-width="2">
      <path d="M4 19v-7M4 8V1M12 19v-9M12 6V1M20 19v-5M20 10V1M1 12h6M9 6h6M17 14h6" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'filter'
    },
    width: {
      type: [Number, String],
      default: 24
    },
    height: {
      type: [Number, String],
      default: 20
    },
    iconColor: {
      type: String,
      default: '#027AFF'
    }
  },
}
</script>

<style lang="scss" scoped>
</style>
