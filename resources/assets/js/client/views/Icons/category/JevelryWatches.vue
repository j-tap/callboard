<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 57 45"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M50.21 17.56L37.39 0H12.81L0 17.56l1.08.9 24 20 23.71-19.72 1.42-1.18zM14.34 3h21.53l9.35 12.81H5L14.34 3zM6.19 18.81H44L25.1 34.55 6.19 18.81z" />
    <filter :id="iconName+`a`"
            width="121.4%"
            height="126.8%"
            x="-10.7%"
            y="-10.4%"
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
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-174.5-249.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M16.93 2h17.82v3H16.93z" />
      <path fill="#FFF"
            d="M41.14 3.5h-3l-.01 11.2-8.82-12.08h-2.42L18.07 14.7V3.5h-3l-.01 15.81h1.5l1.22.88L28.1 6.04l10.32 14.15 1.21-.88h1.5z" />
      <path fill="#FFF"
            d="M15.275 20.079l2.571-1.546 11.535 19.19-2.571 1.546z" />
      <path fill="#FFF"
            d="M26.812 37.726L38.34 18.532l2.572 1.545L29.384 39.27z" />
      <g transform="translate(3 2)">
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
      default: 'javelry_watches'
    },
    width: {
      type: [Number, String],
      default: 57
    },
    height: {
      type: [Number, String],
      default: 45
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
