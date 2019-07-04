<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 23 23"
     :aria-labelledby="iconName">
  
  <defs>
    <radialGradient :id="iconName+`a`"
                    cx="40.182%"
                    cy="7.578%"
                    r="114.572%"
                    fx="40.182%"
                    fy="7.578%">
      <stop offset="0%"
            stop-color="#FAFAFF" />
      <stop offset="100%"
            stop-color="#D1D1D7" />
    </radialGradient>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-27.5-85.5h312v140h-312z" />
    <g stroke-width="2"
       transform="translate(1 1)">
      <circle cx="10.5"
              cy="10.5"
              r="10.5"
              :fill="`url(#`+iconName+`a)`"
              stroke="#CECED7" />
      <path stroke="#96A7B1"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M13.06 15.218L10 12V6.014" />
    </g>
    <path d="M-14-14h50v50h-50z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'Clock'
    },
    width: {
      type: [Number, String],
      default: 23
    },
    height: {
      type: [Number, String],
      default: 23
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
