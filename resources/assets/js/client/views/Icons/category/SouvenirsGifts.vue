<template >
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 41 44"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M20.36 11.38v3h7v17.84H3V14.38h7v-3a3.69 3.69 0 1 1 3.68-3.69h3a6.69 6.69 0 1 0-12.27 3.69H0v23.84h30.35V11.38h-9.99z" />
    <filter :id="iconName+`a`"
            width="152.7%"
            height="146.8%"
            x="-26.4%"
            y="-20.5%"
            filterUnits="objectBoundingBox">
      <feOffset dy="1"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="2.5" />
      <feColorMatrix in="shadowBlurOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.19 0" />
    </filter>
    <path :id="iconName+`d`"
          d="M20.36 1a6.7 6.7 0 0 0-6.69 6.69v24.84h3V7.69a3.69 3.69 0 1 1 3.69 3.69v3a6.69 6.69 0 0 0 0-13.38z" />
    <filter :id="iconName+`c`"
            width="152.3%"
            height="122.2%"
            x="-33.6%"
            y="-11.1%"
            filterUnits="objectBoundingBox">
      <feOffset dx="-1"
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
          d="M-367.5-249.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M32.35 24.8v3H6.78v-3z" />
      <g transform="translate(5 3)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <g transform="translate(5 3)">
        <use fill="#000"
             :filter="`url(#`+iconName+`c)`"
             :xlink:href="`#`+iconName+`d`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`d`" />
      </g>
      <path fill="#FFF"
            d="M25.36 4a6.7 6.7 0 0 0-6.69 6.69v3.69h3v-3.69a3.69 3.69 0 1 1 3.69 3.69h5.57a6.61 6.61 0 0 0 1.12-3.69A6.7 6.7 0 0 0 25.36 4zM25.36 14.38h9.99v3h-9.99zM13.5 35.22h14.12v3H13.5z" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'souvenirs_gifts'
    },
    width: {
      type: [Number, String],
      default: 41
    },
    height: {
      type: [Number, String],
      default: 44
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
