<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 22 17"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-17.5-445.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round">
                <g transform="translate(1 1)">
                    <rect width="16.5" height="12" rx="2"/>
                    <path d="M0 4.5h16.5"/>
                </g>
                <path fill="#FFF" d="M20.889 11.944a3.944 3.944 0 1 0-7.889 0 3.944 3.944 0 0 0 7.889 0z"/>
                <path fill="#FFF" d="M15.889 11.944a3.944 3.944 0 1 0-7.889 0 3.944 3.944 0 0 0 7.889 0z"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'cardCash'
            },
            width: {
                type: [Number, String],
                default: 22
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