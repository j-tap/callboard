<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 24 24"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd" stroke="#D8D8D8">
            <path d="M-516.5-310.5h1167v626h-1167z"/>
            <path d="M-348.5-15.5h386v49h-386z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.44 11.05l-9.19 9.19a6.003 6.003 0 1 1-8.49-8.49l9.19-9.19a4.002 4.002 0 0 1 5.66 5.66l-9.2 9.19a2.001 2.001 0 0 1-2.83-2.83l8.49-8.48"/>
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
                default: 24
            },
            height: {
                type: [Number, String],
                default: 24
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