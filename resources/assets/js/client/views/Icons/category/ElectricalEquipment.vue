<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 31 42"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M13.51 31.93C6.053 31.93.006 25.887 0 18.43V14h3v4.39c0 5.799 4.701 10.5 10.5 10.5S24 24.189 24 18.39V16h3v2.39c.011 7.463-6.027 13.523-13.49 13.54z" />
    <filter :id="iconName+`a`"
            width="129.6%"
            height="144.6%"
            x="-14.8%"
            y="-11.2%"
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
          d="M3 11h21a3 3 0 0 1 3 3H0a3 3 0 0 1 3-3z" />
    <filter :id="iconName+`c`"
            width="125.9%"
            height="333.3%"
            x="-13%"
            y="-83.3%"
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
          d="M-329.5-185.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M19.53 42a5.21 5.21 0 0 1-5.32-5.09v-7h3v7A2.22 2.22 0 0 0 19.53 39v3zM9.99 0v9h-3V3a3 3 0 0 1 3-3zM24.01 3.03v6h-3v-9a3 3 0 0 1 3 3z" />
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
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'electircal_equipment'
    },
    width: {
      type: [Number, String],
      default: 31
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
