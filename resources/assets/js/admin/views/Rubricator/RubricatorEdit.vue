<template>
    <!-- Main content -->
    <section class="content">
        <progressbar v-if="!item"></progressbar>

        <div class="box" v-if="item">
            <div class="box-body">
                <form @submit="saveForm">
                    <div class="col-md-12">
                        <div :class="['form-group', errors.name ? 'has-error' : '']" >
                            <label for="name">Название вопроса</label>
                            <input v-model="item.name" type="text" class="form-control" id="name" placeholder="Введите название">
                            <span class="help-block" v-if="errors.name" :errors="errors">
                                {{ errors.name[0]}}
                            </span>
                        </div>
                        <div :class="['form-group', errors.description ? 'has-error' : '']" >
                            <label for="description">Описание рубрики</label>
                            <input v-model="item.description" type="text" class="form-control" id="description" placeholder="Введите описание">
                            <span v-for class="help-block" v-if="errors.description" :errors="errors">
                                {{ errors.description[0] }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-6">
                            <div :class="['form-group', errors.cl_icon ? 'has-error' : '']" >
                                <label for="cl_icon">Стиль иконки</label>
                                <input v-model="item.cl_icon" type="text" class="form-control" id="cl_icon" placeholder="Class name">
                                <span class="help-block" v-if="errors.cl_icon" :errors="errors">
                                    {{ errors.cl_icon[0]}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div :class="['form-group', errors.cl_background? 'has-error' : '']" >
                                <label for="cl_background">Стиль фона</label>
                                <input v-model="item.cl_background" type="text" class="form-control" id="cl_background" placeholder="Class name">
                                <span v-for class="help-block" v-if="errors.cl_background" :errors="errors">
                                    {{ errors.cl_background[0] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frm-buttons">
                        <div class="btn-group">
                            <input v-if="this.$root.profile.permissions.categories.edit" class="btn btn-default" type="submit" value="Редактировать"/>
                            <input v-if="this.$root.profile.permissions.users.delete" class="btn btn-danger" type="button" @click="deleteItem" value="Удалить"/>
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
                axios.get('/admin/api/categories/' + this.$route.params.id)
                     .then((resp) => {
                        this.item = resp.data;
                     });
            },

            deleteItem() {
                axios.delete('/admin/api/categories/' + this.item.id)
                     .then((resp) => {
                        this.$router.push({name: 'rubricator'});
                     });
            },

            saveForm(event) {
                event.preventDefault();

                axios.patch('/admin/api/categories/' + this.item.id, this.item)
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
