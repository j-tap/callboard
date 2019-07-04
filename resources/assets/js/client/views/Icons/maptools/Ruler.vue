<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 26 26"
     :aria-labelledby="iconName">
  
  <defs>
    <path id="a"
          d="M0 .958h26.042V27H0z" />
  </defs>
  <g fill="none"
     fill-rule="evenodd">
    <g fill="#1A89FF">
      <path d="M8.071 23.586L23.627 8.029 17.97 2.372 2.414 17.929l5.657 5.657zM25.75 8.736L8.78 25.706a.999.999 0 0 1-1.415 0l-7.07-7.07a.999.999 0 0 1 0-1.414L17.263.25a.999.999 0 0 1 1.413 0l7.072 7.07a1 1 0 0 1 0 1.415z" />
      <path d="M11.415 22.686a1 1 0 0 1-1.415 0l-3.746-3.745a1 1 0 1 1 1.414-1.415l3.747 3.747a1 1 0 0 1 0 1.413M17.072 17.03a1 1 0 0 1-1.414 0l-3.747-3.747a1 1 0 1 1 1.414-1.414l3.747 3.746a1 1 0 0 1 0 1.415M22.729 11.373a.999.999 0 0 1-1.415 0l-3.747-3.747a1 1 0 1 1 1.415-1.414l3.747 3.747a.999.999 0 0 1 0 1.414M14.22 19.835c-.39.39-1.006.408-1.375.039l-1.492-1.492c-.37-.37-.352-.985.038-1.375.391-.391 1.007-.408 1.376-.04l1.492 1.493c.37.369.352.984-.039 1.375M19.877 14.179c-.391.39-1.006.408-1.375.038l-1.492-1.491c-.37-.37-.352-.985.039-1.376.39-.391 1.006-.408 1.375-.04l1.492 1.493c.369.37.352.985-.04 1.376" />
    </g>
  </g>
</svg>
</template>

<script>
export default {
  props: {
    iconName: {
      type: String,
      default: 'straightedge'
    },
    width: {
      type: [Number, String],
      default: 26
    },
    height: {
      type: [Number, String],
      default: 26
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
