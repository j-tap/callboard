<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 17 20"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-29.5-24.5h312v140h-312z" />
    <path d="M-16-15h50v50h-50z" />
    <g>
      <path :fill="iconColor"
            d="M16.364 8.182C16.364 14.545 8.182 20 8.182 20S0 14.545 0 8.182a8.182 8.182 0 0 1 16.364 0zm-8.182 2.727a2.727 2.727 0 1 0 0-5.454 2.727 2.727 0 0 0 0 5.454z" />
      <circle cx="8.182"
              cy="8.182"
              r="1.995"
              fill="#F7F8FC" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Location'
    },
    width: {
      type: [Number, String],
      default: 17
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
