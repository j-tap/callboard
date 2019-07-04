<template>
    <svg xmlns="http://www.w3.org/2000/svg":width="width"
         :height="height"
         viewBox="0 0 18 18"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-218.5-61.5h536v332h-536z"/>
            <path stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" d="M16.91 12.936v2.4a1.6 1.6 0 0 1-1.744 1.6 15.832 15.832 0 0 1-6.904-2.456 15.6 15.6 0 0 1-4.8-4.8 15.832 15.832 0 0 1-2.456-6.936A1.6 1.6 0 0 1 2.598 1h2.4a1.6 1.6 0 0 1 1.6 1.376c.102.768.29 1.522.56 2.248a1.6 1.6 0 0 1-.36 1.688L5.782 7.328a12.8 12.8 0 0 0 4.8 4.8l1.016-1.016a1.6 1.6 0 0 1 1.688-.36c.726.27 1.48.459 2.248.56a1.6 1.6 0 0 1 1.376 1.624z"/>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'DealsPhone'
            },
            width: {
                type: [Number, String],
                default: 18
            },
            height: {
                type: [Number, String],
                default: 18
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