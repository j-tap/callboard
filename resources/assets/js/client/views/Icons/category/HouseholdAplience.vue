<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 35 42"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M21.19 0H9.93A10 10 0 0 0 0 9.93v17.51a10 10 0 0 0 9.93 9.94h11.26c5.486-.006 9.93-4.454 9.93-9.94V9.93C31.114 4.448 26.672.006 21.19 0zm0 34.38H9.93A6.94 6.94 0 0 1 3 27.44V9.93A6.94 6.94 0 0 1 9.93 3h11.26a6.94 6.94 0 0 1 6.93 6.93v17.51a6.94 6.94 0 0 1-6.93 6.94z" />
    <filter :id="iconName+`a`"
            width="125.7%"
            height="121.4%"
            x="-12.9%"
            y="-5.4%"
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
          d="M15.56 29.65a9.5 9.5 0 1 1 9.5-9.5 9.52 9.52 0 0 1-9.5 9.5zm0-16a6.5 6.5 0 1 0 6.5 6.5 6.51 6.51 0 0 0-6.5-6.5z" />
    <filter :id="iconName+`c`"
            width="131.6%"
            height="131.6%"
            x="-15.8%"
            y="-15.8%"
            filterUnits="objectBoundingBox">
      <feOffset in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
    <circle :id="iconName+`f`"
            cx="8.5"
            cy="8"
            r="2" />
    <filter :id="iconName+`e`"
            width="275%"
            height="275%"
            x="-87.5%"
            y="-62.5%"
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
          d="M-269.5-121.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <path fill="#FFF"
            d="M23.57 14.49c-.13-.11-2.18-2.45-2.18-2.45s-4.83 1.35-3 1.67a2.26 2.26 0 0 1 2 2.33 2.77 2.77 0 0 1-2.85 2.61 5.41 5.41 0 0 0-5.26 5.23c-.39 2.1 2.34 4.37 2.34 4.37h2.71a6 6 0 0 0 1-.14l-.57-1.5c-2.44-.36-2.56-2.08-2.53-2.61a2.4 2.4 0 0 1 2.34-2.37A5.79 5.79 0 0 0 23.26 17a15.36 15.36 0 0 0 .31-2.51z" />
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
    </g>
    <g transform="translate(2)">
      <use fill="#000"
           :filter="`url(#`+iconName+`e`"
           :xlink:href="`#`+iconName+`f`" />
      <use fill="#FFF"
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
      default: 'household_aplience'
    },
    width: {
      type: [Number, String],
      default: 35
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
}</script>

<style lang="css">
</style>
