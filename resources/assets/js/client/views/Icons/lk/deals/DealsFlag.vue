<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 13 16"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-22.5-225.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 10.1s.7-.7 2.8-.7c2.1 0 3.5 1.4 5.6 1.4 2.1 0 2.8-.7 2.8-.7V1.7s-.7.7-2.8.7C7.3 2.4 5.9 1 3.8 1 1.7 1 1 1.7 1 1.7v8.4zM1 15v-4.9"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'flag'
            },
            width: {
                type: [Number, String],
                default: 13
            },
            height: {
                type: [Number, String],
                default: 16
            },
            iconColor: {
                type: String,
                default: 'currentColor'
            }
        }
    }
</script>

<style scoped>
    button:hover path{
        stroke:white;
    }
</style>