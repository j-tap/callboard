<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 14 8"
         :aria-labelledby="iconName">
        
        <g fill="none"
           fill-rule="evenodd">
            <path stroke="#D8D8D8"
                  d="M-65.5-72.5h833v95h-833z"/>
            <path :stroke="iconColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  :stroke-width="strokeWidth"
                  d="M1 1l6 6 6-6"/>
        </g>
    </svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'uncollapse'
    },
    width: {
      type: [Number, String],
      default: 14
    },
    height: {
      type: [Number, String],
      default: 8
    },
    iconColor: {
      type: String,
      default: '#FFF'
    },
    strokeWidth:{
        type: String,
        default: "2"
    },
  }
}
</script>

<style lang="scss" scoped>


</style>
