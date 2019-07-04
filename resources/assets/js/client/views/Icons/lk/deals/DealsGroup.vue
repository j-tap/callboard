<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 19 15"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-19.5-269.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" transform="translate(1 1)">
                <path d="M12.444 14v-1.556a3.111 3.111 0 0 0-3.11-3.11H3.11A3.111 3.111 0 0 0 0 12.443V14"/>
                <circle cx="6.222" cy="3.111" r="3.111"/>
                <path d="M17.111 14v-1.556a3.111 3.111 0 0 0-2.333-3.01M11.667.101a3.111 3.111 0 0 1 0 6.028"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'group'
            },
            width: {
                type: [Number, String],
                default: 19
            },
            height: {
                type: [Number, String],
                default: 15
            },
            iconColor: {
                type: String,
                default: 'currentColor'
            }
        }
    }
</script>

<style scoped>
    button:hover path{
        stroke:white;
    }
</style>