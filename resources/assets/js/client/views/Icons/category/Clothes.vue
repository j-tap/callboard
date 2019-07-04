<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 40 33"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M21.32 1.5l1.05 1-2.12 2.18-1.07-1.07a2.06 2.06 0 0 0-2.92 0 2.06 2.06 0 0 0 0 2.91L35 25.26a3 3 0 0 1 0 4.25L14.14 8.65a5.07 5.07 0 0 1 0-7.17 5.07 5.07 0 0 1 7.18.02z" />
    <filter :id="iconName+`a`"
            width="134.4%"
            height="127.1%"
            x="-17.2%"
            y="-6.8%"
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
          d="M.88 25.27L14.11 12l2.07 2.07L.88 29.51a3 3 0 0 1 0-4.24z" />
    <filter :id="iconName+`c`"
            width="149.5%"
            height="145.7%"
            x="-24.7%"
            y="-11.4%"
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
          d="M-115.5-125.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FCFCFF"
            d="M37.01 29.51L37 26.5H2.88v3.01z" />
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FCFCFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="translate(2)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FCFCFF"
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
      default: 'clothes'
    },
    width: {
      type: [Number, String],
      default: 40
    },
    height: {
      type: [Number, String],
      default: 33
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
