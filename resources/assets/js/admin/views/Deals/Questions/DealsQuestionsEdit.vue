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
                        <div :class="['form-group', errors.question ? 'has-error' : '']" >
                            <label for="question">Вопрос</label>
                            <input v-model="item.question" type="text" class="form-control" id="question" placeholder="Введите вопрос">
                            <span v-for class="help-block" v-if="errors.question" :errors="errors">
                                {{ errors.question[0] }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 frm-buttons">
                        <div class="btn-group">
                            <input v-if="this.$root.profile.permissions.dealquestion.edit" class="btn btn-default" type="submit" value="Редактировать"/>
                            <input v-if="this.$root.profile.permissions.dealquestion.delete" class="btn btn-danger" type="button" @click="deleteItem" value="Удалить"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import ViewMixins from '../../../mixins/view'

    export default {
        mixins: [ViewMixins],
        data() {
            return {
                itemId: null,
                item: null,
            }
        },
        mounted() {
            this.loadItem();
        },
        methods: {
            loadItem() {
                axios.get('/admin/api/deals/questions/' + this.$route.params.id).then(
                     (resp) => {
                        this.item = resp.data;
                     });
            },

            deleteItem: function() {
                axios.delete('/admin/api/deals/questions/' + this.item.id)
                     .then((resp) => {
                        this.$router.push({name: 'deals.questions'});
                        this.messageDeleted();
                     });
            },

            saveForm(event) {
                event.preventDefault();

                axios.patch('/admin/api/deals/questions/' + this.item.id, this.item)
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
