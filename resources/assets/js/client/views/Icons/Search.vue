<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 18 18"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-558.5-427.5h816v626h-816z" />
    <path stroke="#D8D8D8"
          d="M-144.5-58.5h297v140h-297z" />
    <g stroke="#1A89FF"
       stroke-linecap="round"
       stroke-linejoin="round"
       stroke-width="2"
       transform="translate(1 1)">
      <circle cx="6.667"
              cy="6.667"
              r="6.667" />
      <path d="M16 16l-4.622-4.622" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'search'
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
