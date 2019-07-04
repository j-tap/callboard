<template>
    <svg xmlns="http://www.w3.org/2000/svg"   :width="width"
         :height="height"
         viewBox="0 0 16 14"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-19.5-100.5h816v626h-816z"/>
            <g stroke="#FF564B" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 1L2 13M2 1l12 12"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'close'
            },
            width: {
                type: [Number, String],
                default: 16
            },
            height: {
                type: [Number, String],
                default: 14
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