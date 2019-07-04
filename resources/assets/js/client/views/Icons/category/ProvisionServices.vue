<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 45 39"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M24.83 11a4.6 4.6 0 1 1-9.18 0h-3a7.59 7.59 0 1 0 15.18 0h-3z" />
    <filter :id="iconName+`a`"
            width="152.7%"
            height="205.4%"
            x="-26.4%"
            y="-26.4%"
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
          d="M7.41 0H32.6v3H7.41z" />
    <filter :id="iconName+`c`"
            width="127.8%"
            height="333.3%"
            x="-13.9%"
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
    <path :id="iconName+`f`"
          d="M31.37 15.86v15.96H8.65V15.9h-3v18.92h28.72V15.86z" />
    <filter :id="iconName+`e`"
            width="124.4%"
            height="136.9%"
            x="-12.2%"
            y="-13.2%"
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
          d="M19 16.94h2v18.7h-2z" />
    <filter :id="iconName+`g`"
            width="450%"
            height="137.4%"
            x="-175%"
            y="-13.4%"
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
          d="M38.76 6.16L32.6 0h-4.23l7.39 7.4a5 5 0 0 1 1.48 3.6 4.84 4.84 0 0 1-4.81 4.83 4.82 4.82 0 0 1-4.6-4.83h-3a7.83 7.83 0 0 0 7.58 7.82A7.83 7.83 0 0 0 40.24 11V9.73a5 5 0 0 0-1.48-3.57z" />
    <filter :id="iconName+`i`"
            width="145.4%"
            height="137.2%"
            x="-22.7%"
            y="-13.3%"
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
    <path :id="iconName+`l`"
          d="M15.65 11h-3A4.827 4.827 0 0 1 3 10.75a5 5 0 0 1 1.48-3.58L11.65 0H7.41L1.48 5.93A5 5 0 0 0 0 9.5v1.25a7.84 7.84 0 0 0 7.83 7.83A7.84 7.84 0 0 0 15.65 11z" />
    <filter :id="iconName+`k`"
            width="144.7%"
            height="137.7%"
            x="-22.4%"
            y="-13.5%"
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
          d="M-61.5-252.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`e`"
             :xlink:href="`#`+iconName+`f`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`f`" />
      </g>
      <g transform="rotate(90 20.5 27.79)">
        <use fill="#000"
             :filter="`url(#`+iconName+`g)`"
             :xlink:href="`#`+iconName+`h`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`h`" />
      </g>
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`i)`"
             :xlink:href="`#`+iconName+`j`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`j`" />
      </g>
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`k)`"
             :xlink:href="`#`+iconName+`l`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`l`" />
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
      default: 'provision_services'
    },
    width: {
      type: [Number, String],
      default: 45
    },
    height: {
      type: [Number, String],
      default: 39
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
