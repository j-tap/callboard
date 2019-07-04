<template>
<div class="ratestar">
  <svg xmlns="http://www.w3.org/2000/svg"
       :width="width"
       :height="height"
       viewBox="0 0 15 14"
       :aria-labelledby="iconName">
    
    <g fill="none"
       fill-rule="evenodd">
      <path fill="#FFBF0F"
            d="M7.5 0l2.317 4.608L15 5.35l-3.75 3.585.885 5.064L7.5 11.608 2.865 14l.885-5.064L0 5.35l5.182-.743z" />
      <path stroke="#D8D8D8"
            d="M-13.5-14.5h80v43h-80z" />
    </g>
  </svg>
</div>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Star-Rate'
    },
    width: {
      type: [Number, String],
      default: 15
    },
    height: {
      type: [Number, String],
      default: 14
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
