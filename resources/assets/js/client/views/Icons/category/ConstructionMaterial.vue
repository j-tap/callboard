<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="width"
     viewBox="0 0 44 28"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M19 24H0V13h19v11zM3 21h13v-5H3v5z" />
    <filter :id="iconName+`a`"
            width="142.1%"
            height="172.7%"
            x="-21.1%"
            y="-18.2%"
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
          d="M29.47 11h-19V0h19v11zm-16-3h13V3h-13v5z" />
    <filter :id="iconName+`c`"
            width="142.1%"
            height="172.7%"
            x="-21.1%"
            y="-18.2%"
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
          d="M40 24H21V13h19v11zm-16-3h13v-5H24v5z" />
    <filter :id="iconName+`e`"
            width="142.1%"
            height="172.7%"
            x="-21.1%"
            y="-18.2%"
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
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-272.5-195.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <g transform="translate(2)">
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
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'construction_material'
    },
    width: {
      type: [Number, String],
      default: 44
    },
    height: {
      type: [Number, String],
      default: 28
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
