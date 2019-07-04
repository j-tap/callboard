<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 21 17"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-167.5-62.5h536v332h-536z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2.9 1h15.2c1.045 0 1.9.844 1.9 1.875v11.25C20 15.156 19.145 16 18.1 16H2.9C1.855 16 1 15.156 1 14.125V2.875C1 1.844 1.855 1 2.9 1z"/>
                <path d="M20 2.875l-9.5 6.563L1 2.875"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'DealsMail'
            },
            width: {
                type: [Number, String],
                default: 21
            },
            height: {
                type: [Number, String],
                default: 17
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