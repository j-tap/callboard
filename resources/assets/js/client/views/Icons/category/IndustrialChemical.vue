<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 38 36"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M20.55 0v12.57a9 9 0 1 0 6 0V0" />
    <filter :id="iconName+`a`"
            width="161.1%"
            height="136.6%"
            x="-30.6%"
            y="-11.6%"
            filterUnits="objectBoundingBox">
      <feMorphology in="SourceAlpha"
                    operator="dilate"
                    radius="1.5"
                    result="shadowSpreadOuter1" />
      <feOffset dy="2"
                in="shadowSpreadOuter1"
                result="shadowOffsetOuter1" />
      <feMorphology in="SourceAlpha"
                    radius="1.5"
                    result="shadowInner" />
      <feOffset dy="2"
                in="shadowInner"
                result="shadowInner" />
      <feComposite in="shadowOffsetOuter1"
                   in2="shadowInner"
                   operator="out"
                   result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <path :id="iconName+`d`"
          d="M3 8.5h3a3 3 0 0 1 3 3H0a3 3 0 0 1 3-3z" />
    <filter :id="iconName+`c`"
            width="188.9%"
            height="366.7%"
            x="-44.4%"
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
    <path :id="iconName+`f`"
          d="M1.57 15.06h6v12a3 3 0 0 1-6 0v-12z" />
    <filter :id="iconName+`e`"
            width="283.3%"
            height="173.3%"
            x="-91.7%"
            y="-23.3%"
            filterUnits="objectBoundingBox">
      <feMorphology in="SourceAlpha"
                    operator="dilate"
                    radius="1.5"
                    result="shadowSpreadOuter1" />
      <feOffset dy="2"
                in="shadowSpreadOuter1"
                result="shadowOffsetOuter1" />
      <feMorphology in="SourceAlpha"
                    radius="1.5"
                    result="shadowInner" />
      <feOffset dy="2"
                in="shadowInner"
                result="shadowInner" />
      <feComposite in="shadowOffsetOuter1"
                   in2="shadowInner"
                   operator="out"
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
          d="M-11.5-255.5h536v332h-536z" />
    <g transform="translate(2)">
      <use fill="#000"
           :filter="`url(#`+iconName+`a)`"
           :xlink:href="`#`+iconName+`b`" />
      <use stroke="#FFF"
           stroke-width="3"
           :xlink:href="`#`+iconName+`b`" />
    </g>
    <g fill-rule="nonzero"
       transform="translate(2)">
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
      <use stroke="#FFF"
           stroke-width="3"
           :xlink:href="`#`+iconName+`f`" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'industrial_chemicals'
    },
    width: {
      type: [Number, String],
      default: 38
    },
    height: {
      type: [Number, String],
      default: 36
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
