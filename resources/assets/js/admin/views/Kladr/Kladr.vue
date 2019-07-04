<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <datatable
                ref="datatable"
                :columns="this.getColumns()"
                :dataUrl="getApi"
                :createRoute="this.getCreateRoute()"
                :createText="'Создать'"
            ></datatable>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import ViewMixins from '../../mixins/view'

    export default {
        mixins: [ViewMixins],
        watch: {
            $route (to, from) {
                this.onCreated();
                this.updateData();
            }
        },
        mounted() {
            this.updateBreadCrumb();
        },
        methods: {
            updateData() {
                this.$refs.datatable.apiUrl = this.getApi;
                this.$refs.datatable.updateData();
                this.updateBreadCrumb();
            },

            updateBreadCrumb() {
                if (this.$route.params.country) {
                    this.addBreadcrumb({name: 'Регионы', path: 'kladr.list', params: {country: this.$route.params.country}});
                }
                if (this.$route.params.region) {
                    this.addBreadcrumb({name: 'Города'});
                }
            },

            getButtonLink(item) {
                if (!this.$route.params.country) {
                    return {name: 'kladr.list', params: {country: item.id}};
                } else {
                    return {name: 'kladr.list', params: {country: this.$route.params.country, region: item.id}};
                }
            },

            getEditLink(item) {
                if (!this.$route.params.country) {
                    return {name: 'kladr.edit', params: {country: item.id}};
                } else
                if (this.$route.params.country && !this.$route.params.region ) {
                    return {name: 'kladr.edit', params: {country: this.$route.params.country, region: item.id}};
                } else {
                    return {name: 'kladr.edit', params: {country: this.$route.params.country, region: this.$route.params.country, city: item.id}};
                }
            },

            getCreateRoute() {
                if (!this.$route.params.country) {
                    return {name: 'kladr.create'};
                } else
                if (this.$route.params.country && !this.$route.params.region) {
                    return {name: 'kladr.create', params: {country: this.$route.params.country}};
                } else {
                    return {name: 'kladr.create', params: {country: this.$route.params.country, region: this.$route.params.region}};
                }
            },

            getColumns() {
                var islink = false;

                if (!this.$route.params.country || !this.$route.params.region) {
                    islink = true;
                }

                var columns = [
                    {name: 'ID', key: 'id'},
                    {name: 'Название', key: 'name', link: islink, itemLink: this.getButtonLink},
                ];

                if (this.$root.profile.permissions.kladr.edit)
                    columns.push({name: '', button: true, buttonLabel: 'Редактировать', buttonLink: this.getEditLink});


                return columns;
            },
        },
        computed: {
            getApi() {
                if (!this.$route.params.country) {
                    this.$parent.$forceUpdate();

                    return '/admin/api/kladr/countries';
                } else
                if (this.$route.params.country && !this.$route.params.region) {
                    this.$parent.$forceUpdate();

                    return '/admin/api/kladr/regions/' + this.$route.params.country;
                } else {
                    this.$parent.$forceUpdate();

                    return '/admin/api/kladr/cities/' + this.$route.params.region;
                }
            }
        }
    }
</script>

<style scoped>
    .no-bg {
        background: transparent !important;
    }
</style>
