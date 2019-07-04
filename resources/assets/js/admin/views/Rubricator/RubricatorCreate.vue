<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <form @submit="saveForm">
                    <div class="col-md-12">
                        <div :class="['form-group', errors.name ? 'has-error' : '']" >
                            <label for="name">Название рубрики</label>
                            <input v-model="item.name" type="text" class="form-control" id="name" placeholder="Введите название">
                            <span class="help-block" v-if="errors.name" :errors="errors">
                                {{ errors.name[0]}}
                            </span>
                        </div>
                        <div :class="['form-group', errors.description ? 'has-error' : '']" >
                            <label for="description">Описание</label>
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
                        <input class="btn btn-default pull-right" type="submit" value="Добавить"/>
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
                item: {
                    parent_id: 0,
                    name: null,
                    description: null,
                }
            }
        },
        mounted() {
            this.item.parent_id = this.$route.params.id || 0;
        },
        methods: {
            saveForm(event) {
                event.preventDefault();

                axios.post('/admin/api/categories/store', this.item)
                    .then((resp) => {
                        this.$router.push({name: 'rubricator'});
                        this.messageCreated();
                    })
                    .catch(this.handleErrorResponse);
            }
        }
    }
</script>

<style scoped>
</style>