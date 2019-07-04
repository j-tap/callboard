<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 14 14"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <g :stroke="iconColor"
       stroke-linecap="round"
       stroke-linejoin="round"
       :stroke-width="strokeWidth">
      <path d="M13 1L1 13M1 1l12 12" />
    </g>
    <path stroke="#D8D8D8"
          d="M-784.5-61.5h833v95h-833z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'close'
    },
    width: {
      type: [Number, String],
      default: 14
    },
    height: {
      type: [Number, String],
      default: 14
    },
    iconColor: {
      type: String,
      default: '#FF564B'
    },
    strokeWidth:{
        type:[Number, String],
        default:2,
    }
  },
}
</script>

<style scoped>

</style>
