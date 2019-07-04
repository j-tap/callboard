<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <form @submit="saveForm">
                    <div class="col-md-12">
                        <div :class="['form-group', errors.title ? 'has-error' : '']" >
                            <label for="title">Название новости</label>
                            <input v-model="item.title" type="text" class="form-control" id="title" placeholder="Введите название">
                            <span class="help-block" v-if="errors.title" :errors="errors">
                                {{ errors.title[0]}}
                            </span>
                        </div>
                        <div :class="['form-group', errors.url ? 'has-error' : '']" >
                            <label for="url">Ссылка</label>
                            <input v-model="item.url" type="text" class="form-control" id="url" placeholder="Введите URL">
                            <span v-for class="help-block" v-if="errors.url" :errors="errors">
                                {{ errors.url[0] }}
                            </span>
                        </div>
                        <div :class="['', errors.categories ? 'has-error' : '']" >
                            <label for="categories">Категории</label>
                            <treeselect v-model="item.categories" instanceId="categories" :multiple="true" :options="categories" :normalizer="getNode" />
                            <span v-for class="help-block" v-if="errors.categories" :errors="errors">
                                {{ errors.categories[0] }}
                            </span>
                        </div>
                        <br />
                        <div :class="['form-group', errors.description ? 'has-error' : '']" >
                            <label>Текст новости</label>

                            <vue-ckeditor
                                v-model="item.description"
                                :config="config"
                            />

                            <span v-for class="help-block" v-if="errors.description" :errors="errors">
                                {{ errors.description[0] }}
                            </span>
                        </div>
                        <div v-if="this.$root.profile.permissions.publications.moderate" :class="['', errors.status ? 'has-error' : '']" >
                            <label for="status">Статус</label>
                            <select v-model="item.status" class="form-control" name="status" id="status">
                                <option value="edit" selected>На редактировании</option>
                                <option value="approve">Подтверждена</option>
                                <option value="canceled">Отклонена</option>
                            </select>
                            <span v-for class="help-block" v-if="errors.status" :errors="errors">
                                {{ errors.status[0] }}
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
    import ViewMixins from '../../mixins/view'
    import VueCkeditor from 'vue-ckeditor2'
    import Treeselect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    export default {
        components: {VueCkeditor, Treeselect},
        mixins: [ViewMixins],
        data() {
            return {
                item: {
                    title: null,
                    description: null,
                    categories: null,
                    url: null,
                    status: 'edit',
                },
                categories: [],
                config: {
                    toolbar: [
                        ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
                    ],
                    height: 300
                }
            }
        },
        mounted() {
            this.getCategories();
            if (this.$route.meta.props && this.$route.meta.props.stock) {
                this.item.stock = 1;
            }
        },
        methods: {
            getNode(node) {
                return {
                    id: node.id,
                    label: node.name,
                    children: node.items,
                }
            },

            saveForm(event) {
                event.preventDefault();

                axios.post('/admin/api/news/store', this.item)
                    .then((resp) => {
                        this.messageCreated();

                        if (this.$route.meta.props && this.$route.meta.props.stock) {
                            this.$router.push({name: 'stock.list'});
                        } else
                            this.$router.push({name: 'news.list'});
                    })
                    .catch(this.handleErrorResponse);
            },

            getCategories() {
                axios.get('/admin/api/categories')
                    .then((resp) => {
                        this.categories = resp.data;
                    });
            }
        }
    }
</script>

<style scoped>
</style>