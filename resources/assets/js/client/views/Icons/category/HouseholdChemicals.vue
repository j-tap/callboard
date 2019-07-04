<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 31 48"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M-.98 26.62h19.26v3H2.02a3 3 0 0 1-3-3z" />
    <filter :id="iconName+`a`"
            width="141.5%"
            height="366.7%"
            x="-20.8%"
            y="-66.7%"
            filterUnits="objectBoundingBox">
      <feOffset dy="2"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <path :id="iconName+`d`"
          d="M8.65 13.37a8.47 8.47 0 0 0-8.47 8.46V34.9a8.47 8.47 0 1 0 16.93 0V21.83a8.46 8.46 0 0 0-8.46-8.46zm5.46 15v6.53a5.47 5.47 0 1 1-10.93 0V21.83a5.47 5.47 0 0 1 10.93 0v6.54z" />
    <filter :id="iconName+`c`"
            width="147.2%"
            height="126.4%"
            x="-23.6%"
            y="-6.6%"
            filterUnits="objectBoundingBox">
      <feOffset dy="2"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <path :id="iconName+`f`"
          d="M7.14 4.21h9.46c0 .812-.205 1.59-.569 2.164-.364.574-.859.896-1.374.896H7.14V4.21z" />
    <filter :id="iconName+`e`"
            width="174%"
            height="328.8%"
            x="-37%"
            y="-81.7%"
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
    <path :id="iconName+`h`"
          d="M26.35 11.52h-3a4.26 4.26 0 0 0-4.26-4.26v-3a7.27 7.27 0 0 1 7.26 7.26z" />
    <filter :id="iconName+`g`"
            width="196.4%"
            height="196.4%"
            x="-48.2%"
            y="-62%"
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
          d="M-481.5-118.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M21.09 7.26v-3A4.26 4.26 0 0 0 25.35 0h3a7.27 7.27 0 0 1-7.26 7.26zM9.14 11.8V7.26h3v4.54z" />
      <g transform="rotate(-90 9.65 27.12)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`e`"
             :xlink:href="`#`+iconName+`f`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`f`" />
      </g>
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`g)`"
             :xlink:href="`#`+iconName+`h`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`h`" />
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
      default: 'household_chemicals'
    },
    width: {
      type: [Number, String],
      default: 31
    },
    height: {
      type: [Number, String],
      default: 48
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
