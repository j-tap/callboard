<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 23 21"
         :aria-labelledby="iconName">
        
        <g fill="none"
           fill-rule="evenodd">
            <path stroke="#D8D8D8"
                  d="M-89.5-23.5h312v140h-312z"/>
            <path :fill="iconColor"
                  :stroke="iconColor"
                  stroke-linecap="square"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M20 9v11H3V9"/>
            <path :fill="iconColor"
                  :stroke="iconColor2"
                  stroke-linecap="round"
                  stroke-width="2"
                  d="M1 9.5L11.5 2 22 9.5"/>
            <path fill="#F8F8FF"
                  d="M5 12h13v9H5z"/>
            <g :stroke="iconColor">
                <path d="M5 14.5h13M5 17.5h13"/>
            </g>
            <path d="M-14-14h50v50h-50z"/>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Stock'
            },
            width: {
                type: [Number, String],
                default: 23
            },
            height: {
                type: [Number, String],
                default: 21
            },
            iconColor: {
                type: String,
                default: '#2FAEFF'
            },
            iconColor2: {
                type: String,
                default: '#047BFF'
            }
        }
    }
</script>

<style scoped>

</style>
