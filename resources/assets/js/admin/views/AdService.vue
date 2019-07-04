<template>
    <!-- Main content -->
    <section class="content">
        <div class="row" v-if="!items">
            <div class="col-md-6">
                <i class="fa fa-refresh fa-spin"></i>
                Загрузка данных...
            </div>
        </div>
        <div v-if="items" class="row" v-for="(item, index) in items">
            <div class="box-header"><h3 class="box-title">{{item.name}}</h3></div>
            <adservice-item
                :key="index"
                :item="item"
            ></adservice-item>
            <adservice-item v-for="(itm, index) in item.items" v-if="item.items"
                            :key="index +'child'"
                            :item="itm"
            ></adservice-item>

            <div class="col-md-2">
                <button type="button" class="btn btn-default" @click="addNewCard(item)">
                    <i class="fa fa-plus fa-align-center"></i>
                </button>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import ViewMixins from '../mixins/view'
    import {Component, Prop, Vue} from 'vue-property-decorator';

    Vue.component('adservice-item', require('./Components/AdServiceItem'));

    export default {
        mixins: [ViewMixins],
        data() {
            return {
                items: null
            }
        },
        mounted() {
            this.loadServices()
        },
        methods: {
            loadServices() {
                axios.get('/admin/api/ad/services').then((resp) => {
                    this.items = resp.data;
                });
            },
            addNewCard(item) {
                if (!item.items) {
                    item.items = [];
                    item.items.push({
                        "name": "",
                        "days": 1,
                        "cost": 300,
                        "parent_id": item.id
                    });
                    this.$forceUpdate();
                }
                else {
                    item.items.push({
                        "name": "",
                        "days": 1,
                        "cost": 300,
                        "parent_id": item.id
                    });
                    this.$forceUpdate();

                }
            },
        },
    }
</script>