<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 46 40"
     :aria-labelledby="iconName">
  
  <defs>
    <filter :id="iconName+`a`"
            width="120.9%"
            height="127.8%"
            x="-10.5%"
            y="-6.9%"
            filterUnits="objectBoundingBox">
      <feOffset dy="3"
                in="SourceAlpha"
                result="shadowOffsetOuter1" />
      <feGaussianBlur in="shadowOffsetOuter1"
                      result="shadowBlurOuter1"
                      stdDeviation="1" />
      <feColorMatrix in="shadowBlurOuter1"
                     result="shadowMatrixOuter1"
                     values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0" />
      <feMerge>
        <feMergeNode in="shadowMatrixOuter1" />
        <feMergeNode in="SourceGraphic" />
      </feMerge>
    </filter>
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-5.5-190.5h536v332h-536z" />
    <g fill="#FFF"
       fill-rule="nonzero"
       :filter="`url(#`+iconName+`a)`"
       transform="translate(2 -1)">
      <path d="M5.78 19.52h-.22A4.77 4.77 0 1 1 6 10a4.72 4.72 0 0 1 3.31 1.54A4.77 4.77 0 0 1 10.54 15a4.76 4.76 0 0 1-4.76 4.56v-.04zm0-6.54a1.75 1.75 0 0 0-1.2.47 1.76 1.76 0 0 0-.1 2.5 1.72 1.72 0 0 0 1.22.57 1.81 1.81 0 0 0 1.3-.46 1.76 1.76 0 0 0 .57-1.23A1.74 1.74 0 0 0 5.85 13l-.07-.02zM37.28 19.52h-.21a4.77 4.77 0 1 1 .41-9.52A4.77 4.77 0 0 1 42 15a4.72 4.72 0 0 1-1.54 3.31 4.77 4.77 0 0 1-3.18 1.21zm0-6.54a1.72 1.72 0 0 0-1.19.47 1.75 1.75 0 0 0-.58 1.22c-.03.492.149.974.49 1.33.316.348.76.554 1.23.57a1.8 1.8 0 0 0 1.27-.46 1.76 1.76 0 0 0 .5-1.28 1.7 1.7 0 0 0-.46-1.27 1.77 1.77 0 0 0-1.19-.56l-.07-.02zM15.29 12.38h-.22c-2.62-.15-4.66-2.75-4.55-5.8a5.92 5.92 0 0 1 1.82-4.16 4.32 4.32 0 0 1 3.17-1.17C18.13 1.39 20.16 4 20.06 7a5.92 5.92 0 0 1-1.82 4.16 4.35 4.35 0 0 1-2.95 1.22zm0-8.14a1.36 1.36 0 0 0-.92.4 2.93 2.93 0 0 0-.85 2.05c0 1.4.73 2.64 1.71 2.69.372.01.733-.13 1-.39a3 3 0 0 0 .85-2c.05-1.41-.73-2.64-1.71-2.7l-.08-.05zM27.32 12.62h-.23c-2.65-.16-4.64-2.81-4.54-6a6.21 6.21 0 0 1 1.9-4.41A4.18 4.18 0 0 1 27.55 1c2.65.15 4.65 2.8 4.54 6a6.25 6.25 0 0 1-1.9 4.42 4.24 4.24 0 0 1-2.87 1.2zm0-8.62a1.29 1.29 0 0 0-.85.37 3.32 3.32 0 0 0-.92 2.3c-.05 1.68.86 2.9 1.71 2.95.341.006.67-.128.91-.37A3.27 3.27 0 0 0 29.09 7c.06-1.68-.86-2.9-1.71-2.95h-.06V4zM32.5 31.43a8.47 8.47 0 0 0-11-12.81 8.46 8.46 0 0 0-11 12.81h.05c6.047 6 15.803 6 21.85 0h.1zm-19.79-2.07a5.473 5.473 0 1 1 7.75-7.73l1.06 1.06.09-.09.19-.19.78-.78a5.473 5.473 0 1 1 7.75 7.73c-4.877 4.838-12.743 4.838-17.62 0z" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'pet_suplies'
    },
    width: {
      type: [Number, String],
      default: 46
    },
    height: {
      type: [Number, String],
      default: 40
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
