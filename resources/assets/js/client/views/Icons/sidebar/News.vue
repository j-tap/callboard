<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 18 18"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path d="M-26-16h70v50h-70z" />
    <g :stroke="iconColor"
       stroke-linecap="round"
       stroke-linejoin="round"
       stroke-width="2"
       transform="translate(1 1)">
      <rect width="15.429"
            height="15.429"
            rx="2" />
      <path d="M0 5.143h15.429M5.143 15.429V5.143" />
    </g>
    <path :stroke="iconColor"
          d="M-355.5-30.5h833v95h-833z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'about'
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
