<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 16 14"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-494.5-104.5h816v626h-816z"/>
            <g :stroke="iconColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M1 7h14M9 1l6 6-6 6"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Right-Arrow-Small'
            },
            width: {
                type: [Number, String],
                default: 16
            },
            height: {
                type: [Number, String],
                default: 14
            },
            iconColor: {
                type: String,
                default: '#1A89FE'
            }
        }
    }
</script>

<style scoped>

</style>