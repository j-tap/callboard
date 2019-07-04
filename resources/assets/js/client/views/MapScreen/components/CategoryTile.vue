<template>
    <li class="tile__item" @click="catIdEmit">
        <div :class="'tile ' + (item.cl_background || 'grey')" >
            <CategoryIcons :icon="item.cl_icon"></CategoryIcons>
        </div>
        <p class="tile__item_p">{{item.name}}</p>
    </li>
</template>

<script>
    export default {
        props: ['item'],
        methods: {

            catIdEmit() {
                this.$parent.$emit('categoryUpdateEmit', this.item);
            }

        },
    }
</script>