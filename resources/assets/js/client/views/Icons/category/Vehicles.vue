<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 43 25"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M8.29 21.9a4.66 4.66 0 1 1-.02-9.32 4.66 4.66 0 0 1 .02 9.32zm0-6.31a1.66 1.66 0 1 0-.02 3.32 1.66 1.66 0 0 0 .02-3.32z" />
    <filter :id="iconName+`a`"
            width="175.1%"
            height="175.1%"
            x="-37.6%"
            y="-26.8%"
            filterUnits="objectBoundingBox">
      <feOffset dy="1"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <path :id="iconName+`d`"
          d="M33.14 21.9a4.66 4.66 0 1 1-.02-9.32 4.66 4.66 0 0 1 .02 9.32zm0-6.31a1.66 1.66 0 1 0-.02 3.32 1.66 1.66 0 0 0 .02-3.32z" />
    <filter :id="iconName+`c`"
            width="175.1%"
            height="175.1%"
            x="-37.6%"
            y="-26.8%"
            filterUnits="objectBoundingBox">
      <feOffset dy="1"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <path :id="iconName+`f`"
          d="M25.41 10.15h6.2a6.83 6.83 0 0 1 6.33 4.29h3.15a9.83 9.83 0 0 0-9.48-7.29h-9.2a3 3 0 0 0 3 3z" />
    <filter :id="iconName+`e`"
            width="137.5%"
            height="196%"
            x="-18.7%"
            y="-61.7%"
            filterUnits="objectBoundingBox">
      <feOffset dy="-1"
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
          d="M-320.5-129.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M21 0h-9.56a9.81 9.81 0 0 0-9.12 7.29L.18 14.44h3.16l2.14-7.15A6.82 6.82 0 0 1 11.8 3h8.84A6.81 6.81 0 0 1 27 7.29h3.16A9.81 9.81 0 0 0 21 0zM11.06 15.75h18.93v3H11.06zM36.29 15.75h4.8a3 3 0 0 1-3 3h-1.8v-3zM4.8 18.74H3a3 3 0 0 1-3-3h4.8v3z" />
      <g>
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g>
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <g>
        <use fill="#000"
             :filter="`url(#`+iconName+`e`"
             :xlink:href="`#`+iconName+`f`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`f`" />
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
      default: 'vehicles'
    },
    width: {
      type: [Number, String],
      default: 43
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
