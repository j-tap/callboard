<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 21 20"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path d="M-24-15h70v50h-70z" />
    <g :stroke="iconColor"
       stroke-linecap="round"
       stroke-linejoin="round"
       stroke-width="2"
       transform="translate(2 1)">
      <circle cx="8.571"
              cy="8.571"
              r="8.571" />
      <circle cx="8.571"
              cy="8.571"
              r="3.429" />
      <path d="M2.511 2.511l3.635 3.635M10.997 10.997l3.634 3.634M10.997 6.146l3.634-3.635M2.511 14.631l3.635-3.634" />
    </g>
    <path :stroke="iconColor"
          d="M-435.5-29.5h833v95h-833z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'support'
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
li:hover g {
  stroke: white;
}
</style>
