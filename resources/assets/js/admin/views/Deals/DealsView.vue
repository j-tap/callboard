<template>
    <!-- Main content -->
    <section class="content">
        <progressbar v-if="!item"></progressbar>

        <div class="box" v-if="item">
            <div class="row box-body" v-if="item.type_deal=='sell'">
                <div class="deal-info sell-deal col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-4">Параметр</th>
                            <th class="col-md-8">Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Номер сделки</td>
                            <td>{{item.id}}</td>
                        </tr>
                        <tr>
                            <td>Тип сделки</td>
                            <td>Продажа</td>
                            <!--<td v-if="item.type_deal=='sell'">Продажа</td>-->
                        </tr>
                        <tr v-if="item.organization">
                            <td>Организация</td>
                            <td>{{item.organization.org_name}}</td>
                        </tr>
                        <tr v-if="item.user">
                            <td>Пользователь, создавший сделку</td>
                            <td>
                                <router-link
                                        :to="{name: 'clients.edit', params: {id: item.user.id}}"
                                >{{item.user.name}} ({{item.user.unique_id}})
                                </router-link>
                            </td>
                        </tr>
                        <tr>
                            <td>Название</td>
                            <td>
                                <div class="editable-area">
                                    <input type="text" v-model="item.name">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td>
                                <div class="editable-area">
                                    <textarea v-model="item.description"></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Категории</td>
                            <td>
                                <div class="editable-area">
                                    <treeselect
                                            v-model="item.category"
                                            instanceId="categories"
                                            :multiple="true"
                                            :options="categories"
                                            :normalizer="getNode"
                                    />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Город</td>
                            <td>{{item.cities[0].name}}</td>
                        </tr>
                        <tr>
                            <td>Бюджет</td>
                            <td>{{item.budget_to}}</td>
                        </tr>
                        <tr>
                            <td>Дата окончания</td>
                            <td>{{item.deadline_deal}}</td>
                        </tr>
                        <tr>
                            <td>Ссылка на сайте</td>
                            <td>
                                <router-link :to="addbidslink(item.id)">{{item.name}}</router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row box-body" v-else>
                <div class="deal-info sell-deal col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-4">Параметр</th>
                            <th class="col-md-8">Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Номер сделки</td>
                            <td>{{item.id}}</td>
                        </tr>
                        <tr>
                            <td>Тип сделки</td>
                            <td>Покупка</td>
                        </tr>
                        <tr v-if="item.user">
                            <td>Пользователь, создавший сделку</td>
                            <td>
                                <router-link
                                        :to="{name: 'clients.edit', params: {id: item.user.id}}"
                                >{{item.user.name}} ({{item.user.unique_id}})
                                </router-link>
                            </td>
                        </tr>
                        <tr>
                            <td>Название</td>
                            <td>
                                <div class="editable-area">
                                    <input type="text" v-model="item.name">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td>
                                <div class="editable-area">
                                    <textarea v-model="item.description"></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Категории</td>
                            <td>
                                <div class="editable-area">
                                    <treeselect
                                            v-model="item.category"
                                            instanceId="categories"
                                            :multiple="true"
                                            :options="categories"
                                            :normalizer="getNode"
                                    />
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Город</td>
                            <td>
                                <vue-bootstrap-typeahead
                                        title='Начните вводить город'
                                        :data='addressesList'
                                        v-model='addressValue'
                                        :serializer='s => s.title'
                                        placeholder='Город'
                                        ref='typeahead'
                                        @input='getAddresses()'
                                        @hit='addressSelected = $event'

                                />
                            </td>
                        </tr>
                        <tr>
                            <td>Дата окончания</td>
                            <td>{{item.deadline_deal}}</td>
                        </tr>
                        <tr>
                            <td>Ссылка на сайте</td>
                            <td>
                                <router-link :to="addbidslink(item.id)">{{item.name}}</router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row box-body">
                <div class="col-md-12 frm-buttons">
                    <div class="btn-group">
                        <input class="btn btn-default" type="button" @click="saveItem" value="Сохранить">
                        <input
                                v-if="this.$root.profile.permissions.publications.delete"
                                class="btn btn-danger pull-right"
                                type="button"
                                @click="viewDelete=true"
                                value="Удалить"
                        >
                        <confirmDelete v-if="viewDelete" @delete="deleteItem()"
                                       @close="viewDelete=false"></confirmDelete>
                    </div>
                </div>
            </div>

            <div v-if="item.status=='banned'" class="row box-body">
                <div class="col-md-12 frm-buttons">
                    <div class="btn-group">
                        <input class="btn btn-success" type="button" @click="restoreModeration()" value="Восстановить">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import {Component, Prop, Vue} from "vue-property-decorator";
    import ViewMixins from "../../mixins/view";
    import Treeselect from "@riophae/vue-treeselect";
    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
    import BootstrapVue from 'bootstrap-vue'

    Vue.use(BootstrapVue)
    Vue.component("confirmDelete", {
        template: `
    <div class="shadow">
      <div class="confirmDelete-wrapper clearfix">
      <h3>Вы уверены?</h3>
      <div class="col-md-12 frm-buttons">
        <input class="btn btn-danger" type="button" @click="$emit('delete')" value="Удалить">
        <input class="btn btn-default" type="button" @click="$emit('close')" value="Отмена">
      </div>
    </div>
    </div>
  `
    });


    export default {

        mixins: [ViewMixins],
        components: {
            Treeselect,
            VueBootstrapTypeahead,
        },

        data() {
            return {
                viewDelete: false,
                activeTab: 1,
                itemId: "",
                item: null,
                clearedData: null,
                categories: null,
                kladr: null,
                addressesList: [],
                addressValue: '',
                addressSelected: {},
                images: [],
                imagesUploaded:[],
                err: {}

            };
        },
        mounted() {
            this.loadItem();
            this.getCategories();
        },


        methods: {

            restoreModeration () {
                axios.get('/admin/api/deals/refund/moderation/'+ this.item.id).then((resp) => {
                    this.$router.push({name: "deals"});
                }).catch((error) => {
                    console.log('%cError: %O', 'color:red;', error.response)
                })
            },

            setImages (images)
            {
                this.images = images
            },
            onImagesChange (evt, ind)
            {
                if (window.FileReader) {
                    const file = evt.target.files[0]

                    if (file && file.type && file.type.indexOf('image') >= 0) {
                        let reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = function (e) {
                            const img = reader.result

                            this.updPreloadImages(ind, img)
                            this.$emit('setImagesEmit', this.images)
                        }.bind(this)
                    }
                    else {
                        console.log('%cError:Error file type!', 'color:red;')
                        this.$emit('setImagesEmit', this.images)
                    }
                }
            },

            deleteImage (index, imgId)
            {
                if (imgId) {
                    axios.post('/api/v1/deals/deleteimage', {id: imgId})
                        .then((resp) => {
                            this.imagesUploaded.splice(index, 1)
                        })
                        .catch(error => {
                            console.log('%cError: %O', 'color:red;', error.response)
                        })
                }
                this.updPreloadImages(index, null)
            },

            updPreloadImages (ind, val)
            {
                if (typeof ind === 'number' && typeof val !== 'undefined') {
                    this.preloadImagesTmp[ind] = val
                    this.preloadImages = []
                    this.preloadImages = this.preloadImagesTmp
                }
                else {
                    this.cleanPreloadImages()
                }
            },
            cleanPreloadImages (ind)
            {
                if (ind) {
                    this.preloadImagesTmp[ind] = null
                }
                else {
                    this.preloadImagesTmp = []
                }
                this.preloadImages = []
                this.preloadImages = this.preloadImagesTmp
            },

            getAddresses ()
            {
                if (this.addressValue.length) {
                    axios.get('/api/v1/kladr/place?query='+ this.addressValue).then((resp) => {
                        console.log('%cError: %O', 'color:green;', resp);
                        this.kladr = resp.data.data;
                        this.generateList();
                    }).catch((error) => {
                        console.log('%cError: %O', 'color:red;', error.response)
                    })
                }
            },
            generateList ()
            {
                if (this.kladr) {
                    this.addressesList = []
                    const cities = this.kladr.cities

                    for (let i in cities) {
                        console.log('%cError: %O', 'color:green;', cities[i])
                        const city = cities[i]
                        city.title = this.getStringAddr(city)
                        this.addressesList.push(city)
                    }
                }
            },

            getStringAddr (city)
            {
                return city.name +', '+ city.region_name
            },

            addbidslink(id) {
                return "/bids/" + id;
            },
            getCategories() {
                axios.get("/admin/api/categories").then(resp => {
                    this.categories = resp.data;
                });
            },
            getNode(node) {
                return {
                    id: node.id,
                    label: node.name,
                    children: node.items
                };
            },
            loadItem() {
                axios.get("/admin/api/deals/" + this.$route.params.id).then(resp => {
                    this.item = resp.data;
                    this.addressSelected=this.item.cities[0];
                });
            },
            saveItem() {

                this.item.addressSelected=this.addressSelected;
                axios
                    .patch("/admin/api/deals/" + this.item.id, {data: this.item})
                    .then(resp => {
                        if (resp.data.result == true) {
                            this.messageSaved();
                        } else {
                            alert(resp.data.error);
                        }

                        // this.$router.push({ name: "deals" });
                    });
            },
            deleteItem() {
                console.log("deleted");
                axios.delete("/admin/api/deals/" + this.item.id).then(resp => {
                    this.messageDeleted();
                    this.$router.push({name: "deals"});
                });
            }
        },

        watch: {
            cityName (newVal, oldVal)
            {
                this.addressValue = newVal;
                this.getAddresses(() => {
                    this.addressValue = this.kladr.cities[0].name // this.getStringAddr(this.kladr.cities[0])
                    this.$refs.typeahead.inputValue = this.addressValue
                    this.addressSelected = this.kladr.cities[0]
                    this.$validator.validateAll()
                })
            },
            addressSelected (newVal, oldVal)
            {
                this.$emit('setCityEmit', newVal.id)
            },
        }
    };
</script>


<style  lang="scss"  scoped>

    .btn-group {
        width: 100%;
    }

    .editable-area textarea {
        width: 100%;
        min-height: 80px;
        resize: vertical;
        padding: 0 5px;
    }

    .editable-area input {
        width: 100%;
        padding: 0 5px;
        min-height: 30px;
    }

    .btn-group >>> .shadow {
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: #0006;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    .btn-group >>> .confirmDelete-wrapper {
        position: absolute;
        z-index: 3;
        padding: 20px;
        background: white;
        width: 320px;
        text-align: center;
        top: 30vh;
        left: calc(50% - 210px);
        border-radius: 5px;
        border: 1px solid gray;
    }


</style>