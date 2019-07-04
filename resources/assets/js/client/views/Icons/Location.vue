<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 10 12"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-15.5-53.5h287v487h-287z" />
    <g>
      <path :fill="iconColor"
            d="M9.818 4.91C9.818 8.726 4.91 12 4.91 12S0 8.727 0 4.91a4.91 4.91 0 0 1 9.818 0zM4.91 6.544a1.636 1.636 0 1 0 0-3.272 1.636 1.636 0 0 0 0 3.272z" />
      <circle cx="4.909"
              cy="4.909"
              r="1.636"
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
      default: 'location'
    },
    width: {
      type: [Number, String],
      default: 10
    },
    height: {
      type: [Number, String],
      default: 12
    },
    iconColor: {
      type: String,
      default: '#FF564B'
    }
  }
}
</script>

<style scoped>

</style>
