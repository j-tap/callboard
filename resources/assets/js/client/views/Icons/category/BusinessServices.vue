<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 45 37"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M18.24 19.1h3v6h-3z" />
    <filter :id="iconName+`a`"
            width="366.7%"
            height="233.3%"
            x="-133.3%"
            y="-33.3%"
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
          d="M24.23 6.49h3.14a8.5 8.5 0 0 0-16.75 2h3a5.49 5.49 0 0 1 10.61-2z" />
    <filter :id="iconName+`c`"
            width="141.8%"
            height="182.8%"
            x="-20.9%"
            y="-29.6%"
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
          d="M19.74 20.68a48.12 48.12 0 0 1-17.66-3.33l1.1-2.79a45.14 45.14 0 0 0 16.56 3.12 45.31 45.31 0 0 0 15.16-2.59l1 2.83a48.36 48.36 0 0 1-16.16 2.76z" />
    <filter :id="iconName+`e`"
            width="123.7%"
            height="230.7%"
            x="-11.8%"
            y="-32.7%"
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
    <path :id="iconName+`h`"
          d="M13.62 8.49h22.96l1.79 24H0l1.79-24h11.83zm0 3H4.58L3.23 29.5h31.9l-1.34-18.01H13.62z" />
    <filter :id="iconName+`g`"
            width="123.5%"
            height="137.5%"
            x="-11.7%"
            y="-18.8%"
            filterUnits="objectBoundingBox">
      <feOffset in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1.5" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-118.5-253.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <g transform="translate(3 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <path fill="#FFF"
            d="M27.62 9.49v.01h3v-.01z" />
      <g transform="translate(3 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <g transform="translate(3 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`e`"
             :xlink:href="`#`+iconName+`f`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`f`" />
      </g>
      <g transform="translate(3 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`g)`"
             :xlink:href="`#`+iconName+`h`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`h`" />
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
      default: 'business_services'
    },
    width: {
      type: [Number, String],
      default: 45
    },
    height: {
      type: [Number, String],
      default: 37
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
