<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 25 39"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M19.53 20.77L10.21 0 .89 20.77a10.21 10.21 0 1 0 18.64 0zm-9.32 11.39a7.21 7.21 0 0 1-7.16-7.21 7.11 7.11 0 0 1 .63-3l6.58-14.67 6.58 14.67a7.11 7.11 0 0 1 .63 3 7.21 7.21 0 0 1-7.26 7.21z" />
    <filter :id="iconName+`a`"
            width="134.3%"
            height="119.9%"
            x="-17.1%"
            y="-7.1%"
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
          d="M-432.5-188.5h536v332h-536z" />
    <g fill-rule="nonzero"
       transform="translate(2 1)">
      <use fill="#000"
           :filter="`url(#`+iconName+`a)`"
           :xlink:href="`#`+iconName+`b`" />
      <use fill="#FFF"
           :xlink:href="`#`+iconName+`b`" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'raw_materials'
    },
    width: {
      type: [Number, String],
      default: 25
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
