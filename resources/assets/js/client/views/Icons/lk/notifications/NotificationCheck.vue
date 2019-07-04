<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 18 13"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-20.5-57.5h816v626h-816z"/>
            <path :stroke-width="strokeWidth" stroke="#47D162" stroke-linecap="round" stroke-linejoin="round" d="M17 1L6 12 1 7"/>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'check'
            },
            width: {
                type: [Number, String],
                default: 18
            },
            height: {
                type: [Number, String],
                default: 13
            },
            iconColor: {
                type: String,
                default: 'currentColor'
            },
            strokeWidth: {
                type: String,
                default: "1"
            }
        }
    }
</script>

<style scoped>

</style>