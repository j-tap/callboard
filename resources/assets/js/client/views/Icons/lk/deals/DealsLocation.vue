<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 14 17"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-21.5-182.5h816v626h-816z"/>
            <path stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" d="M13.273 7.136C13.273 11.91 7.136 16 7.136 16S1 11.91 1 7.136a6.136 6.136 0 0 1 12.273 0zM7.136 9.182a2.045 2.045 0 1 0 0-4.091 2.045 2.045 0 0 0 0 4.09z"/>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'locationDeals'
            },
            width: {
                type: [Number, String],
                default: 14
            },
            height: {
                type: [Number, String],
                default: 17
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