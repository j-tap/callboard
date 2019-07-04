<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 15 16"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-38.5-194.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-17.5-149.5h721v200h-721z"/>
            <g :stroke="iconColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 11.5v2.1A1.4 1.4 0 0 0 2.4 15h9.8a1.4 1.4 0 0 0 1.4-1.4v-2.1M10.1 3.8L7.3 1 4.5 3.8M7.3 1v9.8"/>
            </g>
        </g>
    </svg>

</template>
<!--#1A89FE-->
<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'upload'
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
                default: '#1A89FE'
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>