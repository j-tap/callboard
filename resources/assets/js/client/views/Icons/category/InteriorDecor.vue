<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 32 30"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M-2.985 14.795h22.51v3H.015a3 3 0 0 1-3-3z" />
    <filter :id="iconName+`a`"
            width="131.1%"
            height="333.3%"
            x="-15.5%"
            y="-150%"
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
    <path :id="iconName+`d`"
          d="M15.305 14.775h19.47v3h-22.47a3 3 0 0 1 3-3z" />
    <filter :id="iconName+`c`"
            width="135.6%"
            height="366.7%"
            x="-17.8%"
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
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-379.5-126.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M14.41 25.94V7.87h3v18.07z" />
      <path fill="#FFF"
            d="M27.34 0H4.48A5 5 0 0 0 0 5a5 5 0 0 0 4.89 5 5 5 0 0 0 4.89-5h-3a2 2 0 0 1-1.89 2A2 2 0 0 1 3 5a2 2 0 0 1 1.89-2h22a2 2 0 0 1 1.89 2 1.89 1.89 0 1 1-3.77 0h-3a4.89 4.89 0 1 0 9.77 0 5 5 0 0 0-4.44-5z" />
      <g transform="rotate(-90 8.27 16.295)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="rotate(-90 23.54 16.275)">
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
      default: 'interior_decor'
    },
    width: {
      type: [Number, String],
      default: 32
    },
    height: {
      type: [Number, String],
      default: 30
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
