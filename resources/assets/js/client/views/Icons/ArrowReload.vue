<template>
<svg xmlns="http://www.w3.org/2000/svg"
     :width="width"
     :height="height"
     viewBox="0 0 56 56"
     :aria-labelledby="iconName">
  
  <g fill="none"
     fill-rule="evenodd">
    <path stroke="#D8D8D8"
          d="M-630.5-183.5h1241v269h-1241z" />
    <g stroke="#FFF"
       stroke-width="2"
       transform="translate(1 1)">
      <circle cx="27"
              cy="27"
              r="27" />
      <g stroke-linecap="round"
         stroke-linejoin="round"
         class="arrow__repeat">
        <path d="M37 19v6h-6" />
        <path d="M34.49 30a9 9 0 1 1-2.12-9.36L37 25" />
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
      default: 'Reload-Arrow'
    },
    width: {
      type: [Number, String],
      default: 56
    },
    height: {
      type: [Number, String],
      default: 56
    },
    iconColor: {
      type: String,
      default: 'currentColor'
    }
  }
}
</script>

<style lang="scss" scoped>
svg {
    border-radius: 50%;
    transition: 0.3s;
    cursor: pointer;
    &:hover {
        transition: 0.1s;

        background-color: white;

        .arrow__repeat {
            transition: 0.1s;

            /*stroke: $Main-blue;*/
            stroke:#36b9ff;
        }
    }

}
</style>
