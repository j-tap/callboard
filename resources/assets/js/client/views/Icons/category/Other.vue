<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 53 42"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M25.39 31.58a8.5 8.5 0 1 1 8.5-8.5 8.51 8.51 0 0 1-8.5 8.5zm0-13a4.5 4.5 0 1 0 4.5 4.5 4.51 4.51 0 0 0-4.5-4.5z" />
    <filter :id="iconName+`a`"
            width="141.2%"
            height="141.2%"
            x="-20.6%"
            y="-14.7%"
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
          d="M4.176 8.688h4v11.19h-4z" />
    <filter :id="iconName+`c`"
            width="275%"
            height="162.6%"
            x="-87.5%"
            y="-22.3%"
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
          d="M42.684 8.701h4v11.19h-4z" />
    <filter :id="iconName+`e`"
            width="275%"
            height="162.6%"
            x="-87.5%"
            y="-22.3%"
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
          d="M23.39 0h4v12.78h-4z" />
    <filter :id="iconName+`g`"
            width="275%"
            height="154.8%"
            x="-87.5%"
            y="-19.6%"
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
    <path :id="iconName+`j`"
          d="M25.43 37.79c-10.85 0-19.38-9.65-19.74-10.07l-1.1-1.27 1.06-1.3c.36-.44 8.89-10.73 19.78-10.73 11.27 0 20.94 12.58 21.35 13.09l-3.19 2.42c-.09-.11-8.88-11.51-18.16-11.51-6.88 0-13 5.39-15.48 8 2.53 2.41 8.6 7.42 15.48 7.42 5.16 0 9.86-2.82 12.9-5.19l2.46 3.16c-3.53 2.7-9.06 5.98-15.36 5.98z" />
    <filter :id="iconName+`i`"
            width="116.6%"
            height="130%"
            x="-8.3%"
            y="-10.7%"
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
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-245.5-250.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <g transform="translate(0 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="rotate(-41.04 7.512 14.783)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <g transform="rotate(-138.96 44.87 14.796)">
        <use fill="#000"
             :filter="`url(#`+iconName+`e`"
             :xlink:href="`#`+iconName+`f`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`f`" />
      </g>
      <g transform="translate(0 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`g)`"
             :xlink:href="`#`+iconName+`h`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`h`" />
      </g>
      <g transform="translate(0 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`i)`"
             :xlink:href="`#`+iconName+`j`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`j`" />
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
      default: 'other'
    },
    width: {
      type: [Number, String],
      default: 53
    },
    height: {
      type: [Number, String],
      default: 42
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
