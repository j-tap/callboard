<template>
    <!-- Main content -->
    <section class="content">
        <progressbar v-if="!items"></progressbar>
        <div class="box" v-if="items">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="rubricator">
                    <div class="col-md-12">
                        <router-link v-if="this.$root.profile.permissions.categories.create" :to="{name: 'rubricator.create'}" class="create btn btn-default pull-right">
                            Создать
                        </router-link>
                    </div>
                    <rubricator-item
                        v-for="(items, index) in items"
                        :key="index"
                        :model="items">
                    </rubricator-item>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import {Component, Prop, Vue} from 'vue-property-decorator';
    import ViewMixins from '../../mixins/view'
    Vue.component('rubricator-item', require('../Components/RubricatorItem'));

    export default {
        mixins: [ViewMixins],
        data() {
            return {
                items: null,
            }
        },
        methods: {
            loadData() {
                this.$root.$nprogress.start();
                axios.get('/admin/api/categories')
                     .then((resp) => {
                         this.$root.$nprogress.done();
                         this.items = resp.data;
                     })
                     .catch((resp) => {
                         this.$root.$nprogress.done();
                     });
            },
        },
        mounted() {
            this.loadData();
        }
    }
</script>

<style lang="scss" scoped>
    .rubricator {
        .create {
        }
        .items {
            .item {
                > .items {
                    display: none;
                }
                > .controls {
                    a {
                        text-decoration: underline;
                        font-size: 18px;
                    }
                    .accordion-icon {

                    }
                    .accordion-link {
                        cursor: pointer;
                    }
                    .accordion-icon {
                        &.fa-chevron-down {
                            transform: rotate(275deg);
                        }
                    }
                }
                &.opened {
                    > .controls {
                        .fa-chevron-down {
                            transform: rotate(0);
                        }
                    }
                    > .items {
                        display: block;
                    }
                }
            }
        }
    }
</style>
