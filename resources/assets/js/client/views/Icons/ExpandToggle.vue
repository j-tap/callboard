<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 22 22"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-416.5-100.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-width="2" transform="translate(1 1)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 12l-4-4-4 4"/>
                <circle cx="10" cy="10" r="10"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'ExpandToggle'
            },
            width: {
                type: [Number, String],
                default: 22
            },
            height: {
                type: [Number, String],
                default: 22
            },
            iconColor: {
                type: String,
                default: '#027AFF'
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>