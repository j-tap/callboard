<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 28 42"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M9.22 7.72v3a4.51 4.51 0 0 1 4.5 4.5v23h3v-23a7.52 7.52 0 0 0-7.5-7.5z" />
    <filter :id="iconName+`a`"
            width="233.3%"
            height="132.8%"
            x="-66.7%"
            y="-13.1%"
            filterUnits="objectBoundingBox">
      <feMorphology in="SourceAlpha"
                    operator="dilate"
                    radius=".5"
                    result="shadowSpreadOuter1" />
      <feOffset dy="1"
                in="shadowSpreadOuter1"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.06 0" />
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-228.5-187.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M28 14.5V14c0-7.732-6.268-14-14-14S0 6.268 0 14v9.32a6.41 6.41 0 0 0 6.26 6.52h1.93a4.5 4.5 0 0 1 4.5 4.5h3a7.51 7.51 0 0 0-7.5-7.5H6.26A3.4 3.4 0 0 1 3 23.32V14C3 7.925 7.925 3 14 3s11 4.925 11 11v9.32a3.4 3.4 0 0 1-3.25 3.52h-4.06v3h4.08A6.4 6.4 0 0 0 28 23.32V14.5z" />
      <path fill="#FFF"
            d="M15.72 24.77h-3a7.5 7.5 0 0 1 7.5-7.5v3a4.5 4.5 0 0 0-4.5 4.5z" />
      <g transform="translate(-1)">
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
      default: 'garden'
    },
    width: {
      type: [Number, String],
      default: 28
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
