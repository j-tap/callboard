<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 42 28"
     :aria-labelledby="iconName">
  
  <defs>
    <path :id="iconName+`b`"
          d="M35.44 12.29V9.47a8.47 8.47 0 1 0-16.93 0V15h3V9.47a5.47 5.47 0 1 1 10.93 0V15H34a2.06 2.06 0 1 1 0 4.12H6.06a2.06 2.06 0 1 1 0-4.12h1.51v-3H6.09a5.07 5.07 0 1 0 0 10.13h27.85a5 5 0 0 0 1.5-9.87v.03z" />
    <filter :id="iconName+`a`"
            width="118.1%"
            height="132.6%"
            x="-11.7%"
            y="-16.3%"
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
          d="M-212.5-126.5h536v332h-536z" />
    <g fill-rule="nonzero">
      <path fill="#FFF"
            d="M6.57 24.7h3a3 3 0 0 1-3 3v-3zM37.48 27.7a3 3 0 0 1-3-3h3v3zM9.57 16h-3v-5.53a8.47 8.47 0 0 1 16.94 0v3h-3v-3a5.47 5.47 0 0 0-10.94 0V16z" />
      <g transform="translate(2 1)">
        <use fill="#000"
             :filter="`url(#`+iconName+`a)`"
             :xlink:href="`#`+iconName+`b`" />
        <use fill="#FFF"
             :xlink:href="`#`+iconName+`b`" />
      </g>
      <path fill="#FFF"
            d="M7.77 13h-1.2v3H7.8a2.06 2.06 0 0 1 2.05 2h3a5.06 5.06 0 0 0-5.08-5zM36.26 13h1.21v3h-1.23a2.06 2.06 0 0 0-2.06 2h-3a5.07 5.07 0 0 1 5.08-5z" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'furniture'
    },
    width: {
      type: [Number, String],
      default: 42
    },
    height: {
      type: [Number, String],
      default: 28
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
