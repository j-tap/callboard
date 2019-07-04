<template>
    <!-- Main content -->
    <section class="content">
      <progressbar v-if="!item"></progressbar>

        <div class="box" v-if="item">
            <div class="box-body">
                <form @submit="saveForm">
                    <div class="col-md-12">
                        <div :class="['form-group', errors.name ? 'has-error' : '']" >
                            <label for="name">Название формы</label>
                            <input v-model="item.name" type="text" class="form-control" id="name" placeholder="Введите название">
                            <span class="help-block" v-if="errors.name" :errors="errors">
                                {{ errors.name[0]}}
                            </span>
                        </div>
                        <div :class="['form-group', errors.short_name ? 'has-error' : '']" >
                            <label for="short_name">Абревиатура</label>
                            <input v-model="item.short_name" type="text" class="form-control" id="short_name" placeholder="Введите абревиатуру">
                            <span v-for class="help-block" v-if="errors.short_name" :errors="errors">
                                {{ errors.short_name[0] }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 frm-buttons">
                        <div class="btn-group">
                            <input v-if="this.$root.profile.permissions.legalforms.edit" class="btn btn-default" type="submit" value="Редактировать"/>
                            <input v-if="this.$root.profile.permissions.legalforms.delete" class="btn btn-danger" type="button" @click="deleteItem" value="Удалить"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import ViewMixins from '../../mixins/view'

    export default {
        mixins: [ViewMixins],
        data() {
            return {
                item: null
            }
        },
        mounted() {
            this.loadItem();
        },
        methods: {
            loadItem() {
                axios.get('/admin/api/orgs/legalforms/' + this.$route.params.id)
                     .then((resp) => {
                        this.item = resp.data;
                     });
            },

            deleteItem() {
                axios.delete('/admin/api/orgs/legalforms/' + this.item.id)
                     .then((resp) => {
                         this.$router.push({name: 'orgs.legalforms'});
                         this.messageDeleted();
                     });
            },

            saveForm(event) {
                event.preventDefault();

                axios.patch('/admin/api/orgs/legalforms/' + this.item.id, this.item)
                    .then((resp) => {
                        this.messageSaved();
                    })
                    .catch(this.handleErrorResponse);
            }
        }
    }
</script>

<style scoped>
</style>
