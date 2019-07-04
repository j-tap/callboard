<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
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

                    <div v-if="this.$route.params.country && this.$route.params.region">
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
                                <input v-model="item.pos" type="text" class="form-control" id="pos" placeholder="Z pos">
                                <span class="help-block" v-if="errors.pos" :errors="errors">
                                {{ errors.pos[0]}}
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
                    name: null,
                }
            }
        },

        mounted() {
            if (this.$route.params.country && !this.$route.params.region) {
                this.item.country_id = this.$route.params.country;
            } else
            if (this.$route.params.region) {
                this.item.region_id = this.$route.params.region;
            }

            this.updateBreadCrumb();
        },

        methods: {
            updateBreadCrumb() {
                if (!this.$route.params.country) {
                    this.addBreadcrumb({name: 'Новая страна'});
                } else
                if (this.$route.params.country && !this.$route.params.region) {
                    this.addBreadcrumb({name: 'Регионы', path: 'kladr.list', params: {country: this.$route.params.country}});
                    this.addBreadcrumb({name: 'Новый регион'});
                } else
                if (this.$route.params.country && this.$route.params.region) {
                    this.addBreadcrumb({name: 'Регионы', path: 'kladr.list', params: {country: this.$route.params.country}});
                    this.addBreadcrumb({name: 'Города', path: 'kladr.list', params: {country: this.$route.params.country, region: this.$route.params.region}});
                    this.addBreadcrumb({name: 'Новый город'});
                }
            },

            getStoreApi() {
                if (!this.$route.params.country) {
                    this.$parent.$forceUpdate();

                    return '/admin/api/kladr/country/store';
                } else
                if (this.$route.params.country && !this.$route.params.region) {
                    this.$parent.$forceUpdate();

                    return '/admin/api/kladr/region/store';
                } else {
                    this.$parent.$forceUpdate();

                    return '/admin/api/kladr/city/store';
                }
            },

            saveForm(event) {
                event.preventDefault();

                axios.post(this.getStoreApi(), this.item)
                    .then((resp) => {
                        this.$router.push({name: 'kladr.list'});
                        this.messageCreated();
                    })
                    .catch(this.handleErrorResponse);
            }
        },
    }
</script>

<style scoped>
</style>