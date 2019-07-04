<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 18 18"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-153.5-25.5h312v140h-312z" />
    <path fill="#47D162"
          d="M17.9 13.428v2.7a1.8 1.8 0 0 1-1.963 1.8c-2.77-.3-5.43-1.247-7.767-2.763a17.55 17.55 0 0 1-5.4-5.4A17.811 17.811 0 0 1 .007 1.962 1.8 1.8 0 0 1 1.798 0h2.7a1.8 1.8 0 0 1 1.8 1.548c.114.864.326 1.713.63 2.53a1.8 1.8 0 0 1-.405 1.898L5.38 7.12a14.4 14.4 0 0 0 5.4 5.4l1.143-1.143a1.8 1.8 0 0 1 1.9-.405c.816.305 1.664.516 2.528.63a1.8 1.8 0 0 1 1.548 1.827z" />
    <path d="M-16-16h50v50h-50z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Phone'
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

</style>
