<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 20 17"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-20.5-355.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 1)">
                <path d="M11.667 14.667V13.11A3.111 3.111 0 0 0 8.556 10H3.11A3.111 3.111 0 0 0 0 13.111v1.556"/>
                <circle cx="5.111" cy="3.111" r="3.111"/>
                <path d="M12 6.556l1.556 1.555L16.666 5"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'userCheck'
            },
            width: {
                type: [Number, String],
                default: 20
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