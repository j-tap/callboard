<template>
    <ul v-show="collapse"
        class="flex-row f-wrapp-wrapp f-content-between tile__list">
        <categorytile v-for="category in categoryList"
                      :key="category.id"
                      :text="category.name"
                      :color="color"
                      :catId="category.id"></categorytile>
    </ul>
</template>

<script>
    export default {
        props: ['collapse'],
        data() {
            return {
                categoryList: null,
                color: 'blue',
            }
        },
        methods: {

            loadCategories() {
                axios.get('/api/v1/category/tree').then((resp) => {
                    this.categoryList = resp.data.data;
                }).catch((error) => {
                    (error);
                    this.err = resp.err;
                });
            },
            
        },
        mounted() {
            this.loadCategories();
        }
    }
</script>

<style lang="css">
</style>
