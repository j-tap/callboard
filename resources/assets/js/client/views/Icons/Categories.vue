<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 14 14"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-46.5-52.5h287v487h-287z" />
    <g fill="#1A89FF"
       stroke="#086FDD"
       stroke-linecap="round"
       stroke-linejoin="round"
       transform="translate(1 1)">
      <rect width="4.667"
            height="4.667"
            rx="2.333" />
      <rect width="4.667"
            height="4.667"
            x="7.333"
            rx="2.333" />
      <rect width="4.667"
            height="4.667"
            x="7.333"
            y="7.333"
            rx="2.333" />
      <rect width="4.667"
            height="4.667"
            y="7.333"
            rx="2.333" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'categories'
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
      default: '#1A89FF'
    }
  }
}
</script>

<style scoped>

</style>
