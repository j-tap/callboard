<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 39 39"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M16.49 33a16.49 16.49 0 1 1 11.67-4.82A16.41 16.41 0 0 1 16.49 33zm0-30A13.5 13.5 0 1 0 26 7a13.42 13.42 0 0 0-9.51-4z" />
    <filter :id="iconName+`a`"
            width="130.3%"
            height="130.3%"
            x="-15.2%"
            y="-18.2%"
            filterUnits="objectBoundingBox">
      <feMorphology in="SourceAlpha"
                    operator="dilate"
                    radius=".5"
                    result="shadowSpreadOuter1" />
      <feOffset dy="-1"
                in="shadowSpreadOuter1"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.09 0" />
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-64.5-186.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M10.76 32.09L8.3 30.38A69.58 69.58 0 0 1 30 10.23l1.53 2.58a66.92 66.92 0 0 0-20.77 19.28z" />
      <path fill="#FFF"
            d="M24.06 35.06l-3-.31c.38-3.65-1.4-7.72-4.65-10.61a13 13 0 0 0-10.7-3.48l-.51-2.95a16 16 0 0 1 13.23 4.19c3.95 3.52 6.11 8.57 5.63 13.16zM33.42 24.49a16.41 16.41 0 0 1-11.89-5.7 16 16 0 0 1-4.18-13.23l3 .53a13 13 0 0 0 3.42 10.71c2.9 3.24 7 5 10.62 4.64l.31 3c-.43.03-.85.05-1.28.05z" />
      <g transform="translate(3 4)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'tourism_sport'
    },
    width: {
      type: [Number, String],
      default: 39
    },
    height: {
      type: [Number, String],
      default: 39
    },
    iconColor: {
      type: String,
      default: '#1A89FF'
    }
  }
}
</script>

<style lang="css">
</style>
