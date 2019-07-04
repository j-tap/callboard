<template>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     :width="width"
     :height="height"
     viewBox="0 0 20 23"
     :aria-labelledby="iconName">
  
  <defs>
    <path id="a"
          d="M0 .754h2.634v2.634H0z" />
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <path fill="#1A89FF"
          d="M12.04 15.971a1 1 0 0 0-.124 1.408l.513.613H5.518c-1.633 0-3.118-1.103-3.444-2.703a3.426 3.426 0 0 1 3.347-4.138h1.074v.008h7.526c2.83 0 5.36-2.064 5.636-4.88A5.427 5.427 0 0 0 14.262.317h-8.23a1 1 0 1 0 0 2h8.133c1.632 0 3.118 1.103 3.444 2.703a3.427 3.427 0 0 1-3.347 4.14h-.14V9.15h-8.46c-2.83 0-5.361 2.063-5.635 4.88a5.426 5.426 0 0 0 5.394 5.961h7.008l-.513.613a1 1 0 0 0 1.533 1.283l1.888-2.254a.999.999 0 0 0 0-1.283l-1.888-2.255a1 1 0 0 0-1.408-.125" />
    <g transform="translate(1 -.754)">
      <mask id="b"
            fill="#fff">
        <use xlink:href="#a" />
      </mask>
      <path fill="#1A89FF"
            d="M1.317 3.388a1.317 1.317 0 1 0 0-2.634 1.317 1.317 0 0 0 0 2.634"
            mask="url(#b)" />
    </g>
    <path fill="#1A89FF"
          d="M18.683 17.675a1.317 1.317 0 1 0 0 2.634 1.317 1.317 0 0 0 0-2.634" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'mapPath'
    },
    width: {
      type: [Number, String],
      default: 20
    },
    height: {
      type: [Number, String],
      default: 23
    },
    iconColor: {
      type: String,
      default: '#1A89FF'
    }
  }
}
</script>

<style scoped>

</style>
