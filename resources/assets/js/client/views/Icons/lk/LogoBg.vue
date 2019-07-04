<template>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         :width="width"
         :height="height"
         viewBox="0 0 235 223"
         :aria-labelledby="iconName">
        
        <defs>
            <ellipse :id="iconName+`a`" cx="102.864" cy="99.65" rx="88.676" ry="88.846"/>
            <filter :id="iconName+`b`" width="128.2%" height="128.1%" x="-14.1%" y="-14.1%" filterUnits="objectBoundingBox">
                <feGaussianBlur in="SourceAlpha" result="shadowBlurInner1" stdDeviation="24.5"/>
                <feOffset dy="1" in="shadowBlurInner1" result="shadowOffsetInner1"/>
                <feComposite in="shadowOffsetInner1" in2="SourceAlpha" k2="-1" k3="1" operator="arithmetic" result="shadowInnerInner1"/>
                <feColorMatrix in="shadowInnerInner1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.114526721 0"/>
            </filter>
            <filter :id="iconName+`c`" width="120.1%" height="119%" x="-11%" y="-9.5%" filterUnits="objectBoundingBox">
                <feOffset dx="-2" in="SourceAlpha" result="shadowOffsetOuter1"/>
                <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation="6"/>
                <feColorMatrix in="shadowBlurOuter1" result="shadowMatrixOuter1" values="0 0 0 0 0.0781544607 0 0 0 0 0.463316413 0 0 0 0 0.872767857 0 0 0 1 0"/>
                <feMerge>
                    <feMergeNode in="shadowMatrixOuter1"/>
                    <feMergeNode in="SourceGraphic"/>
                </feMerge>
            </filter>
            <path :id="iconName+`d`" d="M.424.158h191.033v199.273H.424z"/>
            <linearGradient :id="iconName+`e`" x1="50%" x2="50%" y1="0%" y2="100%">
                <stop offset="0%" stop-color="#FFE869"/>
                <stop offset="100%" stop-color="#FFCD38"/>
            </linearGradient>
            <path :id="iconName+`h`" d="M105.82 7.586c-10.037 0-20.184 1.486-30.145 4.481-51.44 15.47-81.674 66.866-67.394 114.571 6.91 23.08 23.092 41.879 45.567 52.925 22.528 11.074 48.677 13.039 73.624 5.538 24.948-7.504 45.696-23.571 58.423-45.248 12.694-21.623 15.881-46.244 8.972-69.324-6.908-23.081-23.09-41.876-45.565-52.924-13.538-6.651-28.38-10.02-43.482-10.02M97.326 193.79c-15.739 0-31.21-3.509-45.328-10.45-23.535-11.568-40.49-31.276-47.738-55.492C-10.685 77.92 20.812 24.174 74.472 8.039l.601 2.014-.601-2.014c25.961-7.81 53.194-5.755 76.677 5.791 23.536 11.567 40.49 31.275 47.738 55.489 7.249 24.216 3.918 50.023-9.375 72.668-13.264 22.592-34.868 39.337-60.834 47.144-10.354 3.115-20.912 4.658-31.352 4.658"/>
            <filter :id="iconName+`g`" width="125.7%" height="127.3%" x="-12.9%" y="-13.1%" filterUnits="objectBoundingBox">
                <feOffset dy="1" in="SourceAlpha" result="shadowOffsetOuter1"/>
                <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation="8.5"/>
                <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0.0726509506 0 0 0 0 0.303970498 0 0 0 0 0.549877764 0 0 0 0.387001812 0"/>
            </filter>
            <linearGradient :id="iconName+`i`" x1="50%" x2="50%" y1="0%" y2="100%">
                <stop offset="0%" stop-color="#69E0FF"/>
                <stop offset="100%" stop-color="#38BEFF"/>
            </linearGradient>
            <linearGradient :id="iconName+`l`" x1="50%" x2="50%" y1="0%" y2="100%">
                <stop offset="0%" stop-color="#FFC49D"/>
                <stop offset="100%" stop-color="#FF9264"/>
            </linearGradient>
            <path :id="iconName+`k`" d="M97.076 7.35c-38.146 0-73.179 21.543-86.421 56.977-8.427 22.543-6.88 47.291 4.35 69.687 11.261 22.45 30.896 39.847 55.29 48.986 12.048 4.512 24.372 6.65 36.386 6.65 38.146 0 73.178-21.544 86.42-56.976 8.427-22.543 6.88-47.291-4.35-69.689-11.26-22.448-30.896-39.847-55.29-48.984-12.048-4.512-24.371-6.65-36.385-6.65m9.594 186.5c-12.502 0-25.314-2.223-37.845-6.916-25.39-9.51-45.834-27.636-57.57-51.036C-.508 112.446-2.118 86.503 6.721 62.855 24.95 14.09 82.463-9.59 134.932 10.064c25.389 9.512 45.834 27.636 57.57 51.038 11.762 23.45 13.371 49.394 4.532 73.044-13.874 37.115-50.516 59.705-90.364 59.705"/>
            <filter :id="iconName+`j`" width="110.9%" height="111.5%" x="-5.5%" y="-5.2%" filterUnits="objectBoundingBox">
                <feOffset dy="1" in="SourceAlpha" result="shadowOffsetOuter1"/>
                <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation="3.5"/>
                <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0.9982196 0 0 0 0 0.486862277 0 0 0 0 0.271060105 0 0 0 0.689764493 0"/>
            </filter>
        </defs>
        <g fill="none" fill-rule="evenodd">
            <path stroke="#D8D8D8" d="M-834.5-126.5h1167v626h-1167z"/>
            <path stroke="#D8D8D8" d="M-75.5-20.5h386v269h-386z"/>
            <g transform="translate(16 12)">
                <use fill="#1A89FF" :xlink:href="`#`+iconName+`a`"/>
                <use fill="#000" :filter="`url(#`+iconName+`b)`" :xlink:href="`#`+iconName+`a`"/>
            </g>
            <path fill="#BAEF83" d="M119.828 12.962c-25.27 0-49.02 10.002-66.881 28.165-17.844 18.145-27.67 42.265-27.67 67.917s9.826 49.773 27.67 67.917c17.861 18.164 41.612 28.167 66.881 28.167 25.267 0 49.02-10.003 66.881-28.167 17.844-18.144 27.67-42.265 27.67-67.917s-9.826-49.772-27.67-67.917c-17.861-18.163-41.614-28.165-66.881-28.165m0 4.2c49.901 0 90.354 41.137 90.354 91.882 0 50.744-40.453 91.88-90.354 91.88-49.901 0-90.354-41.136-90.354-91.88 0-50.745 40.453-91.882 90.354-91.882"/>
            <g :filter="`url(#`+iconName+`c)`" transform="translate(22.265 12)">
                <mask :id="iconName+`f`" fill="#fff">
                    <use :xlink:href="`#`+iconName+`d`"/>
                </mask>
                <path :fill="`url(#`+iconName+`e)`" d="M91.226 4.358c-11.9 0-23.862 2.45-35.23 7.63C34.095 21.964 17.649 40.466 9.688 64.08c-7.979 23.666-6.486 49.628 4.2 73.106 22.043 48.418 76.797 71.03 122.054 50.412 45.258-20.617 64.148-76.78 42.106-125.196-16.505-36.254-51.356-58.045-86.822-58.045m9.497 195.073c-37.069 0-73.447-22.7-90.656-60.502-11.133-24.454-12.68-51.51-4.36-76.19C14.045 38.01 31.287 18.628 54.255 8.166c47.368-21.58 104.615 1.971 127.618 52.496 23 50.524 3.18 109.183-44.188 130.766-11.929 5.432-24.483 8.004-36.961 8.004" mask="url(#f)"/>
            </g>
            <g transform="translate(16 12)">
                <use fill="#000" :filter="`url(#`+iconName+`g)`" :xlink:href="`#`+iconName+`h`"/>
                <use fill="#4FE3FE" :xlink:href="`#`+iconName+`h`"/>
            </g>
            <path :fill="`url(#`+iconName+`i)`" d="M53.377 21.732C8.243 50.874-6.565 108.594 20.367 150.404c16.584 25.74 45.186 39.537 75.255 39.54 18.766 0 38.1-5.374 55.443-16.572C196.2 144.23 211.007 86.508 184.075 44.7 157.143 2.896 98.514-7.41 53.378 21.732m42.255 172.41c-31.455 0-61.406-14.471-78.794-41.461C-11.347 108.927 4.023 48.599 51.103 18.199c47.08-30.395 108.313-19.528 136.501 24.224 28.186 43.754 12.816 104.082-34.264 134.48-18.038 11.648-38.165 17.239-57.708 17.239" transform="translate(16 12)"/>
            <g transform="translate(16 12)">
                <use fill="#000" :filter="`url(#`+iconName+`j)`" :xlink:href="`#`+iconName+`k`"/>
                <use :fill="`url(#`+iconName+`l)`" :xlink:href="`#`+iconName+`k`"/>
            </g>
        </g>
    </svg>

</template>

<script>
    export default {
        props: {
            iconName: {
                type: String,
                default: 'logobg'
            },
            width: {
                type: [Number, String],
                default: 235
            },
            height: {
                type: [Number, String],
                default: 223
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