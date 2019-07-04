<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 38 25"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M10.5 21C4.701 21 0 16.299 0 10.5S4.701 0 10.5 0 21 4.701 21 10.5c-.006 5.797-4.703 10.494-10.5 10.5zm0-18a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15z" />
    <filter :id="iconName+`a`"
            width="138.1%"
            height="138.1%"
            x="-9.5%"
            y="-9.5%"
            filterUnits="objectBoundingBox">
      <feOffset dx="2"
                dy="2"
                in="SourceAlpha"
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
          d="M-428.5-129.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M35.58 15.4l2.12-2.13a9.46 9.46 0 0 0-6.7-2.78H18v3h13a6.68 6.68 0 0 1 1.95.3L27.7 19a9.45 9.45 0 0 0-4.24-1h-13v3h13a6.44 6.44 0 0 1 4.59 1.9l2.12-2.12 5.4-5.41.01.03z" />
      <path fill="#FFF"
            d="M10.5 15.78a5.28 5.28 0 1 1 5.28-5.28 5.29 5.29 0 0 1-5.28 5.28zm0-7.56a2.28 2.28 0 1 0 0 4.56 2.28 2.28 0 0 0 0-4.56z" />
      <g>
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <path fill="#FFF"
            d="M10.48 18.02h13.6v3h-13.6z" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'textile'
    },
    width: {
      type: [Number, String],
      default: 38
    },
    height: {
      type: [Number, String],
      default: 25
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
