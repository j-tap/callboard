<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 16 15"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <rect width="240" height="40" stroke="#1A89FE" rx="3" transform="translate(-27 -12)"/>
            <path stroke="#D8D8D8" d="M-505.5-191.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-484.5-146.5h721v200h-721z"/>
            <path stroke-width="1.5" stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" d="M11.111 0L15 3.889 4.889 14H1v-3.889z"/>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'unlock'
            },
            width: {
                type: [Number, String],
                default: 16
            },
            height: {
                type: [Number, String],
                default: 15
            },
            iconColor: {
                type: String,
                default: 'currentColor'
            }
        }
    }
</script>

<style lang="scss" scoped>
    a:hover path {
        stroke: white;
    }

    .pro__email-box-actions {
        a:hover path{
            stroke: #1A89FE;
        }
    }
</style>