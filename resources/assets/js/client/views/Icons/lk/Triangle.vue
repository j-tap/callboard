<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 5 3"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-311.5-241.5h816v626h-816z"/>
            <path fill="#1A89FE" d="M2.5 3L0 0h5z"/>
            <path stroke="#FF7676" d="M-63.5-66.5h133v133h-133z"/>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'triangle'
            },
            width: {
                type: [Number, String],
                default: 5
            },
            height: {
                type: [Number, String],
                default: 3
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