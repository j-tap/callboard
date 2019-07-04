<template>
    <svg xmlns="http://www.w3.org/2000/svg"  :width="width"
         :height="height"
         viewBox="0 0 16 24"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-330.5-475.5h816v626h-816z"/>
            <path stroke="#D8D8D8" d="M-96.5-13.5h161v53h-161z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" transform="translate(1 1)" :stroke-width="strokeWidth">
                <circle cx="7" cy="7" r="7"/>
                <path d="M3.21 12.89L2 22l5-3 5 3-1.21-9.12"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Award'
            },
            width: {
                type: [Number, String],
                default: 16
            },
            height: {
                type: [Number, String],
                default: 24
            },
            iconColor: {
                type: String,
                default: '#1A89FE'
            },
            strokeWidth:{
                type:[Number,String],
                default:1
            }
        }
    }
</script>

<style scoped>

</style>