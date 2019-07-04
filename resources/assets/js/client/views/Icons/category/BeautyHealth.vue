<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 43 45"
     :aria-labelledby="iconName">
  <defs>
    <path :id="iconName+`b`"
          d="M17.37 30.63a3 3 0 0 1 3 3v9.74a3 3 0 0 1-3 3V30.63z" />
    <filter :id="iconName+`a`"
            width="333.3%"
            height="144.5%"
            x="-150%"
            y="-15.9%"
            filterUnits="objectBoundingBox">
      <feOffset dx="-1"
                dy="1"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <path :id="iconName+`d`"
          d="M19.47 34C8.73 33.989.022 25.29 0 14.55h3c0 9.113 7.387 16.5 16.5 16.5S36 23.663 36 14.55h3C38.972 25.312 30.232 34.017 19.47 34z" />
    <filter :id="iconName+`c`"
            width="120.5%"
            height="141.1%"
            x="-10.3%"
            y="-10.3%"
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
          d="M19.47 29C11.466 28.983 4.989 22.484 5 14.48 5.011 6.476 11.506-.005 19.51 0 27.514.006 34 6.496 34 14.5c-.011 8.015-6.515 14.506-14.53 14.5zm0-26C13.123 3.017 7.989 8.173 8 14.52c.011 6.347 5.163 11.485 11.51 11.48C25.857 25.994 31 20.847 31 14.5A11.51 11.51 0 0 0 19.47 3z" />
    <filter :id="iconName+`e`"
            width="127.6%"
            height="127.6%"
            x="-13.8%"
            y="-6.9%"
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
          d="M-115.5-185.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M19.36 35.31h3v4.34h-3z" />
      <g transform="rotate(-90 20.87 38.5)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="translate(2 2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <g transform="translate(2 2)">
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
      default: 'beauty_health'
    },
    width: {
      type: [Number, String],
      default: 43
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
