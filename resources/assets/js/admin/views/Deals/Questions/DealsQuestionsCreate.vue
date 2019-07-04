<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
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
                        <input class="btn btn-default pull-right" type="submit" value="Добавить"/>
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
                item: {
                    name: null,
                    question: null,
                }
            }
        },
        methods: {
            saveForm(event) {
                event.preventDefault();

                axios.post('/admin/api/deals/questions/store', this.item)
                    .then((resp) => {
                        this.messageCreated();
                        this.$router.push({name: 'deals.questions'});
                    })
                    .catch(this.handleErrorResponse);
            }
        }
    }
</script>

<style scoped>
</style>