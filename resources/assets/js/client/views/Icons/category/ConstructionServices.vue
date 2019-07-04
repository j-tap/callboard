<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 46 36"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M40.14 8.86l-5.68-5.68a7.29 7.29 0 0 0-10.32 0l-1.06 1.06 6.55 6.54 2.12-2.12-4.24-4.23a4.3 4.3 0 0 1 4.83.87L38 11a1.4 1.4 0 0 1 0 2 1.39 1.39 0 0 1-2 0l-2.28-2.28-2.12 2.12 2.28 2.28a4.41 4.41 0 0 0 6.21 0 4.41 4.41 0 0 0 0-6.2l.05-.06z" />
    <filter :id="iconName+`a`"
            width="143.8%"
            height="152.1%"
            x="-21.9%"
            y="-13%"
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
          d="M5.329 21.282a5.27 5.27 0 0 1-3.76-1.56 5.35 5.35 0 0 1 0-7.57l10.45-10.42a5.34 5.34 0 1 1 7.55 7.54l-10.43 10.43a5.36 5.36 0 0 1-3.78 1.58h-.03zm8.81-17.43l-10.42 10.42a2.35 2.35 0 0 0 0 3.33 2.3 2.3 0 0 0 1.64.68 2.35 2.35 0 0 0 1.66-.7l10.43-10.43a2.34 2.34 0 1 0-3.31-3.3z" />
    <filter :id="iconName+`c`"
            width="132.9%"
            height="132.9%"
            x="-16.4%"
            y="-11.7%"
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
          d="M27.711 9.693h3v15.25h-3z" />
    <filter :id="iconName+`e`"
            width="333.3%"
            height="145.9%"
            x="-116.7%"
            y="-16.4%"
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
          d="M-373.5-188.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M30.28 34.84a4.52 4.52 0 0 1-3.2-1.33L16.4 22.84l1-1.06a22.91 22.91 0 0 0 3.76-6.18c1.72-4.4 1.12-8.1-1.79-11l2.13-2.12c6.67 6.67 2.7 15.57-.95 20.22l8.69 8.69a1.53 1.53 0 0 0 2.17 0 1.55 1.55 0 0 0 0-2.17l-6.6-6.59 2.12-2.12 6.6 6.59a4.54 4.54 0 0 1-3.21 7.74h-.04zM14.37 35.65a4.52 4.52 0 0 1-3.2-1.33 4.53 4.53 0 0 1 0-6.41l3.74-3.74L17 26.29 13.29 30a1.53 1.53 0 1 0 2.16 2.17l3.74-3.74 2.13 2.12-3.75 3.74a4.52 4.52 0 0 1-3.2 1.36z" />
      <path fill="#FFF"
            d="M31.531 7.646l2.121 2.122-5.664 5.664-2.12-2.122z" />
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
      <g transform="rotate(45 29.004 20.232)">
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
      default: 'construction_services'
    },
    width: {
      type: [Number, String],
      default: 46
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
