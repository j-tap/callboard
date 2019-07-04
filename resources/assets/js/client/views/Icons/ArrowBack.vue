<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 18 14"
         :aria-labelledby="iconName">
        
        <g fill="none"
           fill-rule="evenodd">
            <path stroke="#D8D8D8"
                  d="M-832.5-204.5h1241v269h-1241z"/>
            <g stroke="#FFF"
               stroke-linecap="round"
               stroke-linejoin="round"
               stroke-width="2">
                <path d="M17 7H1M7 1L1 7l6 6"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Back-Arrow'
            },
            width: {
                type: [Number, String],
                default: 18
            },
            height: {
                type: [Number, String],
                default: 14
            },
            iconColor: {
                type: String,
                default: 'currentColor'
            }
        }
    }
</script>

<style lang="css">
</style>
