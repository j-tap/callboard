<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 36 36"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M18.979 12.98h3v15h-3z" />
    <filter :id="iconName+`a`"
            width="666.7%"
            height="213.3%"
            x="-350%"
            y="-56.7%"
            filterUnits="objectBoundingBox">
      <feMorphology in="SourceAlpha"
                    operator="dilate"
                    radius=".5"
                    result="shadowSpreadOuter1" />
      <feOffset dx="-2"
                in="shadowSpreadOuter1"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="2" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-173.5-188.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M33.08 3.49c3.904 3.905 3.904 10.235 0 14.14l-7.73 7.73-7.72 7.72c-3.907 3.905-10.24 3.902-14.145-.005-3.905-3.907-3.902-10.24.005-14.145l7.72-7.72 2.12 2.12L5.61 21a7 7 0 0 0 9.9 9.9l7.72-7.72 7.72-7.72a7 7 0 0 0-9.9-9.9l-5.24 5.25-2.12-2.12 5.24-5.25a10 10 0 0 1 14.15.05z" />
      <g transform="scale(1 -1) rotate(45 63.164 -2.8)">
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
      default: 'medical_suplies'
    },
    width: {
      type: [Number, String],
      default: 36
    },
    height: {
      type: [Number, String],
      default: 36
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
