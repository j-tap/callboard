<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :width="width"
         :height="height"
         viewBox="0 0 22 22"
         :aria-labelledby="iconName">
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-434.5-401.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-14.5-13.5h244v49h-244z"/>
            <g stroke="#1A89FE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" transform="translate(2 2)">
                <circle cx="9" cy="9" r="2.455"/>
                <path d="M15.055 11.455a1.35 1.35 0 0 0 .27 1.489l.049.049a1.636 1.636 0 1 1-2.316 2.315l-.049-.049a1.35 1.35 0 0 0-1.489-.27 1.35 1.35 0 0 0-.818 1.236v.139a1.636 1.636 0 0 1-3.273 0v-.074a1.35 1.35 0 0 0-.884-1.235 1.35 1.35 0 0 0-1.489.27l-.049.049a1.636 1.636 0 1 1-2.315-2.316l.049-.049a1.35 1.35 0 0 0 .27-1.489 1.35 1.35 0 0 0-1.236-.818h-.139a1.636 1.636 0 0 1 0-3.273h.074a1.35 1.35 0 0 0 1.235-.884 1.35 1.35 0 0 0-.27-1.489l-.049-.049a1.636 1.636 0 1 1 2.316-2.315l.049.049a1.35 1.35 0 0 0 1.489.27h.065a1.35 1.35 0 0 0 .819-1.236v-.139a1.636 1.636 0 0 1 3.272 0v.074a1.35 1.35 0 0 0 .819 1.235 1.35 1.35 0 0 0 1.489-.27l.049-.049a1.636 1.636 0 1 1 2.315 2.316l-.049.049a1.35 1.35 0 0 0-.27 1.489v.065a1.35 1.35 0 0 0 1.236.819h.139a1.636 1.636 0 0 1 0 3.272h-.074a1.35 1.35 0 0 0-1.235.819z"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'Settings'
            },
            width: {
                type: [Number, String],
                default: 22
            },
            height: {
                type: [Number, String],
                default: 22
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