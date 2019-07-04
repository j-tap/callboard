<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 41 34"
     :aria-labelledby="iconName">
  
  <defs>
    <path id="2"
          d="M34.46 1.39a4.75 4.75 0 0 0-6.71 0l-4.26 4.26-2.12 2.12-9.62 9.62a3 3 0 0 0 4.24 0l7.5-7.5L26 12.36 15.06 23.27a6.5 6.5 0 1 1-1.63-10.42l2.2-2.2A9.5 9.5 0 1 0 17 25.51l.13-.13 10.95-10.89 2.13-2.13 4.25-4.25a4.74 4.74 0 0 0 0-6.72zM32.34 6l-3.09 3.08-1.17 1.16-2.47-2.47 4.25-4.25A1.754 1.754 0 1 1 32.34 6z" />
    <filter id="1"
            width="131.5%"
            height="139.1%"
            x="-15.8%"
            y="-12.4%"
            filterUnits="objectBoundingBox">
      <feMorphology in="SourceAlpha"
                    operator="dilate"
                    radius=".5"
                    result="shadowSpreadOuter1" />
      <feOffset dy="2"
                in="shadowSpreadOuter1"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-62.5-125.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M11.14 21.29a9.45 9.45 0 0 1-6.71-2.77l2.12-2.13a6.49 6.49 0 0 0 9.19 0l2.12 2.13a9.46 9.46 0 0 1-6.72 2.77z" />
      <g transform="translate(2 1)">
        <use fill="#000"
             filter="url(#1)"
             xlink:href="#2" />
        <use fill="#FFF"
             xlink:href="#2" />
      </g>
      <path fill="#FFF"
            d="M15.74 16.39a6.48 6.48 0 0 1-5.81 1.79L8.82 21a9.64 9.64 0 0 0 2.32.29 9.46 9.46 0 0 0 6.72-2.77l-2.12-2.13z" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'tabacco'
    },
    width: {
      type: [Number, String],
      default: 41
    },
    height: {
      type: [Number, String],
      default: 34
    },
    iconColor: {
      type: String,
      default: '#1A89FF'
    }
  }
}
</script>

<style lang="scss" >
</style>
