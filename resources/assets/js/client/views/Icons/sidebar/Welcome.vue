<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 20 20"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path d="M-25-15h70v50h-70z" />
    <g :stroke="iconColor"
       stroke-linecap="round"
       stroke-linejoin="round"
       stroke-width="2">
      <path d="M17.2 12.394V17.2a1.8 1.8 0 0 1-1.8 1.8H2.8A1.8 1.8 0 0 1 1 17.2V4.6a1.8 1.8 0 0 1 1.8-1.8h4.806" />
      <path d="M15.4 1L19 4.6l-9 9H6.4V10z" />
    </g>
    <path :stroke="iconColor"
          d="M-26.5-29.5h833v95h-833z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'welcome'
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
  },
}
</script>

<style scoped>
li:hover g {
  stroke: white;
}
</style>
