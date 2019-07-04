<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 17 19"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <rect width="240" height="40" stroke="#1A89FE" rx="3" transform="translate(-47 -10)"/>
            <path stroke="#D8D8D8" d="M-525.5-130.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-504.5-85.5h721v200h-721z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" transform="translate(1)">
                <rect width="15" height="9.429" y="8.571" rx="2"/>
                <path d="M3.333 8.571V5.143C3.331 2.94 4.951 1.096 7.081.875c2.13-.222 4.076 1.253 4.502 3.41"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'edit'
            },
            width: {
                type: [Number, String],
                default: 17
            },
            height: {
                type: [Number, String],
                default: 19
            },
            iconColor: {
                type: String,
                default: 'currentColor'
            }
        }
    }
</script>

<style scoped>
a:hover g{
    stroke:white;
}
</style>