<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 56 56"
         :aria-labelledby="iconName">
        
        <g fill="none"
           class="circle"
           fill-rule="evenodd">
            <path stroke="#D8D8D8"
                  d="M-699.5-183.5h1241v269h-1241z"/>
            <g :stroke="iconColor"
               stroke-width="2"
               transform="translate(1 1)">
                <g stroke-linecap="round"
                   class="arrow"
                   stroke-linejoin="round">
                    <path d="M19 27h16M29 21l6 6-6 6"/>
                </g>
                <circle cx="27"
                        cy="27"
                        r="27"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Right-Arrow'
            },
            width: {
                type: [Number, String],
                default: 56
            },
            height: {
                type: [Number, String],
                default: 56
            },
            iconColor: {
                type: String,
                default: '#fff'
            }
        }
    }
</script>

<style lang="scss" scoped>
    svg {
        border-radius: 50%;
        transition: 0.3s;
        cursor: pointer;
        &:hover {
            transition: 0.1s;
            background-color: white;
            .arrow {
                transition: 0.1s;
                /*stroke: $Main-blue;*/
                stroke: #36b9ff;
            }

        }

    }
</style>
