<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <datatable
                :columns="[
                      {name: 'ID', key: 'id', sort: true},
                      {name: 'Название', key: 'name', sort: true, link: true, itemLink: this.getItemLink},
                      {name: 'Вопрос', key: 'question'},
                ]"
                :dataUrl="'/admin/api/deals/questions'"
                :createRoute="{name: 'deals.questions.create'}"
                :createText="'Создать вопрос'"
                :paginate="true"
                :search="true"
                :searchId="'name'"
            ></datatable>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import ViewMixins from '../../../mixins/view'

    export default {
        mixins: [ViewMixins],
        methods: {
            getItemLink(item) {
                if (!this.$root.profile.permissions.dealquestion.edit)
                    return {};

                return {name: 'deals.questions.edit', params: {id: item.id}};
            }
        }
    }
</script>

<style scoped>
    .no-bg {
        background: transparent !important;
    }
</style>