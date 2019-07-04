<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <datatable
                ref="datatable"
                :columns="[
                      {name: 'ID', key: 'id'},
                      {name: 'Название', key: 'title', link: true, itemLink: this.getItemLink},
                      {name: 'Автор', key: 'user.name', sort: true, sort_key: 'user_id'},
                      {name: 'Дата создания', key: 'created_at', sort: true},
                      {name: 'Статус', key: 'status', sort: true},
                ]"
                :dataUrl="this.getApi()"
                :createRoute="this.getCreateRoute()"
                :createText="this.getCreateText()"
                :paginate="true"
                :search="true"
                :searchId="'title'"
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
                this.updateData();
            }
        },
        methods: {
            getCreateText() {
                if (this.$route.meta.props && this.$route.meta.props.stock) {
                    return 'Создать акцию';
                }
                return 'Создать новость';
            },

            getCreateRoute() {
                if (this.$route.meta.props && this.$route.meta.props.stock) {
                    return {name: 'stock.create'};
                }
                return {name: 'news.create'};
            },

            getApi() {
                if (this.$route.meta.props && this.$route.meta.props.stock) {
                    return '/admin/api/stock';
                }
                return '/admin/api/news';
            },

            updateData() {
                this.setTitle(this.$route.meta.title);
                this.setBreadcrumbs(this.$route.meta.breadcrumbs);
                this.$refs.datatable.apiUrl = this.getApi();
                this.$refs.datatable.updateData();
            },

            getItemLink(item) {
                if (!this.$root.profile.permissions.publications.edit)
                    return {};

                if (this.$route.meta.props && this.$route.meta.props.stock) {
                    return {name: 'stock.edit', params: {id: item.id}};
                }
                return {name: 'news.edit', params: {id: item.id}};
            }
        },
    }
</script>