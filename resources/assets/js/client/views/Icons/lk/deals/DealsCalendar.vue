<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 15 16"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-21.5-143.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" transform="translate(1 1)">
                <rect width="12.6" height="12.6" y="1.4" rx="2"/>
                <path d="M9.1 0v2.8M3.5 0v2.8M0 5.6h12.6"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'calendar'
            },
            width: {
                type: [Number, String],
                default: 15
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

</style>