<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 45 33"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M21.97 7.89L.01 4.1v3.06l21.96 3.78v.01l18.95-3.79V4.1z" />
    <filter :id="iconName+`a`"
            width="114.7%"
            height="187.6%"
            x="-7.3%"
            y="-43.8%"
            filterUnits="objectBoundingBox">
      <feOffset in="SourceAlpha"
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
          d="M-470.5-190.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M24.82 31.31l.52-3.16 17.58-3.52v3.06zM22.47 31.81L2.01 27.98 2 24.68l20.47 4.07z" />
      <path fill="#FFF"
            d="M42.92 26.42l-1.51.31V5.63l1.51.91z" />
      <path fill="#FFF"
            d="M22.46 1L2 5.09l7.63 1.53 12.83-2.56 20.46 4.1L43 5.1z" />
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <path fill="#FFF"
            d="M25.47 31.19l-3 .62V8.63l1.5.26 1.5-.3zM3.5 5.4L2 5.14v20.72c.61.64 1.42 1.52 1.92 2.07L5 27.7V6.5L3.5 5.4zM41.41 5.4L40 6.5l-.09 19.36c.6.64 1.42 1.52 1.92 2.07l1.08-.23V5.1l-1.5.3z" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'packaging'
    },
    width: {
      type: [Number, String],
      default: 45
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
