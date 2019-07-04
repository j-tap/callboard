<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 19 17"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-31.5-311.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-10.5-16.5h124v49h-124z"/>
            <path stroke="#FF564B" stroke-linecap="round" stroke-linejoin="round" d="M8.109 1.798L1.218 13.514c-.29.51-.29 1.138-.004 1.65.286.511.817.83 1.395.836h13.782a1.622 1.622 0 0 0 1.395-.836 1.684 1.684 0 0 0-.004-1.65l-6.89-11.716A1.621 1.621 0 0 0 9.5 1c-.569 0-1.096.302-1.391.798z"/>
            <g fill="#FF564B" transform="translate(9 6)">
                <path fill-rule="nonzero" d="M0 .5a.5.5 0 1 1 1 0v3.368a.5.5 0 1 1-1 0V.5z"/>
                <circle cx=".5" cy="6.5" r="1"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Attention'
            },
            width: {
                type: [Number, String],
                default: 19
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