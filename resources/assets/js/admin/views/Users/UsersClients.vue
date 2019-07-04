<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <datatable
                ref="datatable"
                :columns="[
                      {name: 'ID', key: 'id', sort: true},
                      {name: 'Имя пользователя', key: 'name', sort: true, link: true, itemLink: this.getItemLink},
                      {name: 'Email', key: 'email'},
                      {name: 'Организация', key: 'organization.org_name', sort: true, sort_key: 'organization_id', link: true, itemLink: this.getItemOrgLink},
                      {name: 'Роль', key: 'role', sort: true, values: getRoleArray()},
                      {name: 'Статус', key: 'status', sort: true, values: getOrgStatusArray()},
                ]"
                :dataUrl="dataUrl"
                :createRoute="{name: 'users.create'}"
                :createText="'Создать пользователя'"
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
    import {Component, Prop, Vue} from 'vue-property-decorator';
    import ViewMixins from '../../mixins/view'

    export default {
        mixins: [ViewMixins],
        watch: {
            $route (to, from) {
                this.updateData();
            }
        },
        methods: {
            updateData() {
                this.$refs.datatable.apiUrl = this.dataUrl;
                this.$refs.datatable.updateData();
            },

            getItemLink(item) {
                if (!this.$root.profile.permissions.users.edit)
                    return {};

                return {name: 'users.clients.edit', params: {id: item.id}};
            },

            getItemOrgLink(item) {
                if (!this.$root.profile.permissions.users.edit)
                    return {};

                return {name: 'clients.view', params: {id: item.organization_id}};
            }
        },
        computed: {
            dataUrl() {
                return '/admin/api/users/clients'
            }
        },
    }
</script>

<style scoped>
    .no-bg {
        background: transparent !important;
    }
</style>