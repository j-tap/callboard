<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 21 16"
         :aria-labelledby="iconName">
        
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-16.5-401.5h816v626h-816z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9.507 4.8A5.205 5.205 0 0 0 6.7 3.982c-2.938 0-5.32 2.437-5.32 5.444s2.382 5.445 5.32 5.445a5.26 5.26 0 0 0 4.053-1.918"/>
                <path d="M19.762 6.833c0-3.007-2.382-5.444-5.32-5.444-2.939 0-5.32 2.437-5.32 5.444s2.381 5.445 5.32 5.445c2.938 0 5.32-2.438 5.32-5.445z"/>
            </g>
        </g>
    </svg>
</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'cash'
            },
            width: {
                type: [Number, String],
                default: 21
            },
            height: {
                type: [Number, String],
                default: 16
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