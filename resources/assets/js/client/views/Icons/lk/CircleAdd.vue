<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 23 23"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-483.5-401.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-63.5-13.5h244v49h-244z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" transform="translate(1 1)">
                <circle cx="10" cy="10" r="10"/>
                <path d="M10 6v8M6 10h8"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'CircleAdd'
            },
            width: {
                type: [Number, String],
                default: 23
            },
            height: {
                type: [Number, String],
                default: 23
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