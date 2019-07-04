<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 20 18"
     :aria-labelledby="iconName">
  
  <defs>
    <path id="a"
          d="M0 0h19.43v18H0z" />
  </defs>
  <g fill="none"
     fill-rule="evenodd"
     transform="matrix(-1 0 0 1 20 0)">
    <mask id="b"
          fill="#fff">
      <use xlink:href="#a" />
    </mask>
    <path fill="#1A89FF"
          d="M9 16c-3.365 0-6.182-2.388-6.849-5.557.836-.277 2.247-1.086 3.128-3.444.538-1.444 1.908-3.455 3.993-4.369a5.457 5.457 0 0 1 1.452-.406C13.751 2.995 16 5.736 16 9c0 3.859-3.14 7-7 7M14.619.819C13.365.307 12.101.104 10.876.2A8.985 8.985 0 0 0 9 0C4.038 0 0 4.037 0 9s4.038 9 9 9c4.494 0 8.218-3.313 8.884-7.625.743-.396 1.274-1.131 1.466-2.114.478-2.454-1.195-5.998-4.731-7.442"
          mask="url(#b)" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'traffic'
    },
    width: {
      type: [Number, String],
      default: 20
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
