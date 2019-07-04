<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 18 18"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path d="M-26-16h70v50h-70z" />
    <path :stroke="iconColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M16 8.083a6.983 6.983 0 0 1-.75 3.167 7.083 7.083 0 0 1-6.333 3.917 6.983 6.983 0 0 1-3.167-.75L1 16l1.583-4.75a6.983 6.983 0 0 1-.75-3.167A7.083 7.083 0 0 1 5.75 1.75 6.983 6.983 0 0 1 8.917 1h.416A7.067 7.067 0 0 1 16 7.667v.416z" />
    <path :stroke="iconColor"
          d="M-273.5-30.5h833v95h-833z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'message'
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
  stroke: white;
}
</style>
