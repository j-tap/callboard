<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
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
                    name: null,
                    short_name: null,
                }
            }
        },
        methods: {
            saveForm(event) {
                event.preventDefault();

                axios.post('/admin/api/orgs/legalforms/store', this.item)
                    .then((resp) => {
                        this.$router.push({name: 'orgs.legalforms'});
                        this.messageCreated();
                    })
                    .catch(this.handleErrorResponse);
            }
        }
    }
</script>

<style scoped>
</style>