<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 25 24"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-437.5-471.5h1167v626h-1167z"/>
            <path stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.394 13.231C16.374 18.751 10 23 10 23s-9-6-9-13a9 9 0 0 1 17.134-3.858M10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            <g fill="#1A89FE" transform="translate(17 6)">
                <rect width="2" height="7" x="3" rx="1"/>
                <rect width="2" height="7" x="3" rx="1" transform="rotate(90 4 3.5)"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'OfficeAdd'
            },
            width: {
                type: [Number, String],
                default: 25
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

<style lang="scss" scoped>
a:hover{
    path{
        stroke:white;
    }
    g{
        g{
            fill:white;
        }
    }

}
</style>