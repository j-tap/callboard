<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 10 16"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path :stroke="iconColor"
          d="M-362.5-55.5h1167v626h-1167z" />
    <path :stroke="iconColor"
          d="M-341.5-10.5h721v200h-721z" />
    <path :fill="iconColor"
          d="M4.989 2.42c1.017 0 1.844.766 1.844 1.71 0 .941-.827 1.708-1.844 1.708-1.017 0-1.845-.767-1.845-1.709 0-.943.828-1.71 1.845-1.71zm0 5.837C2.532 8.257.533 6.405.533 4.129.533 1.852 2.532 0 4.99 0c2.457 0 4.455 1.852 4.455 4.13 0 2.275-1.998 4.127-4.455 4.127zm1.814 3.37l2.49 2.308c.51.472.51 1.238 0 1.71a1.378 1.378 0 0 1-1.845 0L5 13.378l-2.447 2.269c-.255.236-.59.354-.924.354-.334 0-.667-.118-.923-.354a1.148 1.148 0 0 1 0-1.71l2.49-2.31a8.737 8.737 0 0 1-2.586-.992C0 10.278-.183 9.531.2 8.966c.384-.566 1.19-.737 1.8-.38 1.824 1.063 4.174 1.063 6 0 .61-.357 1.415-.186 1.8.38.383.565.2 1.312-.41 1.668a8.724 8.724 0 0 1-2.587.993z" />
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'ok.ru'
    },
    width: {
      type: [Number, String],
      default: 10
    },
    height: {
      type: [Number, String],
      default: 16
    },
    iconColor: {
      type: String,
      default: '#fff'
    }
  },
}
</script>

<style scoped>

</style>
