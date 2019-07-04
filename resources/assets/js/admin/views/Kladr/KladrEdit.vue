<template>
    <!-- Main content -->
    <section class="content">
      <progressbar v-if="!item"></progressbar>

        <div class="box" v-if="item">
            <div class="box-body">
                <form @submit="saveForm">
                    <div class="col-md-12">
                        <div :class="['form-group', errors.name ? 'has-error' : '']" >
                            <label for="name">Название</label>
                            <input v-model="item.name" type="text" class="form-control" id="name" placeholder="Введите название">
                            <span class="help-block" v-if="errors.name" :errors="errors">
                                {{ errors.name[0]}}
                            </span>
                        </div>
                    </div>

                    <div v-if="this.$route.params.country && this.$route.params.region && this.$route.params.city">
                        <div class="col-md-4">
                            <div :class="['form-group', errors.geo_lat ? 'has-error' : '']" >
                                <label for="geo_lat">Широта</label>
                                <input v-model="item.geo_lat" type="text" class="form-control" id="geo_lat" placeholder="Latitude">
                                <span class="help-block" v-if="errors.geo_lat" :errors="errors">
                                {{ errors.geo_lat[0]}}
                            </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div :class="['form-group', errors.geo_lon ? 'has-error' : '']" >
                                <label for="geo_lon">Долгота</label>
                                <input v-model="item.geo_lon" type="text" class="form-control" id="geo_lon" placeholder="Longitude">
                                <span class="help-block" v-if="errors.geo_lon" :errors="errors">
                                {{ errors.geo_lon[0]}}
                            </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div :class="['form-group', errors.pos ? 'has-error' : '']" >
                                <label for="pos">Позиция</label>
                                <input v-model="item.pos" type="text" class="form-control" id="pos" placeholder="Longitude">
                                <span class="help-block" v-if="errors.pos" :errors="errors">
                                {{ errors.pos[0]}}
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 frm-buttons">
                        <div class="btn-group">
                            <input v-if="this.$root.profile.permissions.kladr.edit" class="btn btn-default" type="submit" value="Редактировать"/>
                            <input v-if="this.$root.profile.permissions.kladr.delete" class="btn btn-danger" type="button" @click="deleteItem" value="Удалить"/>
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
                itemId: null,
                item: null
            }
        },
        mounted() {
            if (this.$route.params.country && !this.$route.params.region) {
                this.itemId = this.$route.params.country;
            } else
            if (this.$route.params.country && this.$route.params.region && !this.$route.params.city) {
                this.itemId = this.$route.params.region;
            } else {
                this.itemId = this.$route.params.city;
            }

            this.loadItem();
            this.updateBreadCrumb();
        },
        methods: {
            updateBreadCrumb() {
                if (this.$route.params.region) {
                    this.addBreadcrumb({name: 'Регионы', path: 'kladr.list', params: {country: this.$route.params.country}});
                }
                if (this.$route.params.city) {
                    this.addBreadcrumb({name: 'Города', path: 'kladr.list', params: {country: this.$route.params.country, region: this.$route.params.region}});
                }
            },

            getItemApi(id) {
                if (this.$route.params.country && !this.$route.params.region) {
                    return '/admin/api/kladr/country/' + id;
                } else
                if (this.$route.params.country && this.$route.params.region && !this.$route.params.city) {
                    return '/admin/api/kladr/region/' + id;
                } else {
                    return '/admin/api/kladr/city/' + id;
                }
            },

            loadItem() {
                axios.get(this.getItemApi(this.itemId))
                    .then((resp) => {
                        this.item = resp.data;
                        this.addBreadcrumb({name: this.item.name});
                    })
                    .catch((error) => {
                        this.goToNotFound();
                    });
            },

            deleteItem() {
                axios.delete(this.getItemApi(this.itemId))
                    .then((resp) => {
                        this.$router.push({name: 'kladr.list'});
                        this.messageDeleted();
                    });
            },

            saveForm(event) {
                event.preventDefault();

                axios.patch(this.getItemApi(this.item.id), this.item)
                    .then((resp) => {
                        this.messageSaved();
                    })
                    .catch(this.handleErrorResponse);
            }
        },
    }
</script>

<style scoped>
</style>
