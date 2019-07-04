<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 27 19"
     :aria-labelledby="iconName">
  
  <defs>
    <radialGradient :id="iconName+`a`"
                    cy="0%"
                    r="100%"
                    fx="50%"
                    fy="0%">
      <stop offset="0%"
            stop-color="#38BEFF" />
      <stop offset="100%"
            stop-color="#1A89FE" />
    </radialGradient>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-87.5-86.5h312v140h-312z" />
    <g>
      <circle cx="13.5"
              cy="9.5"
              r="9.5"
              :fill="`url(#`+iconName+`a)`" />
      <path fill="#047BFF"
            fill-rule="nonzero"
            d="M5.12 5a9.435 9.435 0 0 0-.889 2.387C2.777 7.947 2 8.573 2 9.005c0 .483 1.016 1.252 2.966 1.876 2.223.711 5.271 1.124 8.534 1.124 3.263 0 6.31-.413 8.534-1.124C23.984 10.257 25 9.488 25 9.005c0-.428-.774-1.056-2.231-1.618a9.434 9.434 0 0 0-.873-2.357c.079.004.158.016.237.039C25.15 5.937 27 7.238 27 9.005c0 3.069-6.034 5-13.5 5S0 12.074 0 9.005c0-1.802 1.926-3.122 5.053-3.989L5.12 5z" />
    </g>
    <path d="M-12-15h50v50h-50z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Web'
    },
    width: {
      type: [Number, String],
      default: 27
    },
    height: {
      type: [Number, String],
      default: 19
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
