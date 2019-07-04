<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <datatable
                :columns="[
                      {name: 'ID', key: 'id'},
                      {name: 'Название', key: 'name', link: true, itemLink: this.getItemLink},
                      {name: 'Абревиатура', key: 'short_name'},
                ]"
                :dataUrl="'/admin/api/orgs/legalforms'"
                :createRoute="{name: 'orgs.legalforms.create'}"
                :createText="'Создать форму'"
                :paginate="false"
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
        methods: {
            getItemLink(item) {
                if (!this.$root.profile.permissions.legalforms.edit)
                    return {};

                return {name: 'orgs.legalforms.edit', params: {id: item.id}};
            }
        },
    }
</script>

<style scoped>
    .no-bg {
        background: transparent !important;
    }
</style>