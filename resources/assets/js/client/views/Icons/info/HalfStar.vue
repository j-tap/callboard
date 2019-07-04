<template>
<div class="ratestar">
  <svg xmlns="http://www.w3.org/2000/svg"
       :width="width"
       :height="height"
       viewBox="0 0 7 13"
       :aria-labelledby="iconName">
    
    <g fill="none"
       fill-rule="evenodd">
      <path fill="#FFBF0F"
            d="M7 10.842L2.812 13l.868-4.961L0 4.527l5.086-.729L7 0v10.842z" />
      <path stroke="#D8D8D8"
            d="M-41.5-14.5h80v43h-80z" />
    </g>
  </svg>
</div>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Half-Star-Rate'
    },
    width: {
      type: [Number, String],
      default: 7
    },
    height: {
      type: [Number, String],
      default: 13
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
