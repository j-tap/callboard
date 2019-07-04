<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <datatable
                ref="datatable"
                :columns="[
                      {name: 'ID', key: 'id'},
                      {name: 'Тема', key: 'theme', link: true , itemLink: this.getItemLink},
                      {name: 'Автор', key: 'owner.name', sort: true, sort_key: 'owner_id'},
                      {name: 'Ответственный', key: 'moder.name', sort: true, sort_key: 'moder_id'},
                      {name: 'Дата создания', key: 'created_at', sort: true},
                      {name: 'Статус', key: 'status', sort: true},
                ]"
                :dataUrl="this.getApi()"
                :paginate="true"
                :search="true"
                :searchId="'theme'"
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
            getApi() {
                if (this.$route.meta.props && this.$route.meta.props.reports) {
                    return '/admin/api/feedback/reports';
                }
                return '/admin/api/feedback/messages';
            },

            updateData() {
                this.setTitle(this.$route.meta.title);
                this.setBreadcrumbs(this.$route.meta.breadcrumbs);
                this.$refs.datatable.apiUrl = this.getApi();
                this.$refs.datatable.updateData();
            },

            getItemLink(item) {
                return {name: 'feedback.view', params: {id: item.id}};
            }
        },
    }
</script>