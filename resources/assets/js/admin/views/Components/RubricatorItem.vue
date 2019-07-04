<template>
    <div v-show="show" class="controls col-md-12">
        <a class="accordion-link" @click="toggle">{{ model.name }}</a>
        <router-link :to="{name: 'rubricator.create', params: {id: model.id}}" class="btn">
            <i class="fa fa-plus-circle"></i>
        </router-link>
        <router-link :to="{name: 'rubricator.edit', params: {id: model.id}}" class="btn">
            <i class="fa fa-pencil"></i>
        </router-link>
        <a class="btn" @click="deleteItem">
            <i class="fa fa-trash"></i>
        </a>
        <div class="col-md-12 items" v-show="open" v-if="isFolder">
            <rubricator-item
                class="item"
                v-for="(model, index) in model.items"
                :key="index"
                :model="model">
            </rubricator-item>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            model: Object
        },
        data() {
            return {
                open: false,
                show: true,
            }
        },
        computed: {
            isFolder() {
                return this.model.items &&
                    this.model.items.length
            }
        },
        methods: {
            toggle() {
                if (this.isFolder) {
                    this.open = !this.open
                }
            },
            deleteItem() {
                axios.delete('/admin/api/categories/' + this.model.id)
                     .then((resp) => {
                        this.show = false;
                     });
            },
        }
    }
</script>