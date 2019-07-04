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
                        </tr>
                        <tr v-if="item.organization">
                            <td>Организация</td>
                            <td>{{item.organization.org_name}}</td>
                        </tr>
                        <tr v-if="item.user">
                            <td>Пользователь, создавший сделку</td>
                            <td>
                                <router-link
                                        :to="{name: 'clients.edit', params: {id: item.user.id}}" target= '_blank'
                                >{{item.user.name}} ({{item.user.unique_id}})</router-link>
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
                                        @input="getAddresses(generateList)"
                                        @hit='addressSelected = $event'

                                />
                            </td>
                        <tr>
                            <td>Бюджет</td>
                            <td><input type="text" v-model="item.budget_to"></td>
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
                        <tr>
                            <td>Добавить фото</td>
                            <td>
                                <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input">
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
                                >{{item.user.name}} ({{item.user.unique_id}})</router-link>
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
                                        @input="getAddresses(generateList)"
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
                <div class="col-md-12">
                    <div v-for="i in images" class="col-md-2">
                        <div  class="img">
                            <img :src="i.file_full_path" alt="">
                            <div class="drop-img"><i @click="deleteImage(i.id)" class="fa fa-fw fa-close"></i></div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
            

            <div class="row box-body">
                <div class="col-md-12 frm-buttons">
                    <div class="btn-group">
                        <input class="btn btn-success" type="button" @click="saveItem()" value="Сохранить изменения">

                    </div>
                </div>
            </div>
            <div class="row box-body">
                <div class="col-md-12 frm-buttons">
                    <div class="btn-group">
                        <input class="btn btn-success" type="button" @click="successModeration()" value="Принять">
                        <input
                                class="btn btn-danger pull-right"
                                type="button"
                                @click="failModeration()"
                                value="Отклонить"
                        >
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import { Component, Prop, Vue } from "vue-property-decorator";
    import ViewMixins from "../../mixins/view";
    import Treeselect from "@riophae/vue-treeselect";
    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
    import BootstrapVue from 'bootstrap-vue'

    Vue.use(BootstrapVue);

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
                cities: [],
                cityName:'',
                images:[]
            };
        },
        mounted() {
            this.loadItem();
            this.getCategories();
        },

        watch: {
            cityName (newVal, oldVal)
            {
                this.addressValue = newVal
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
        },
        methods: {

            uploadImage(event) {

                const URL = '/admin/api/deals/upload/image';

                let data = new FormData();
                data.append('name', 'my-picture');
                data.append('file', event.target.files[0]);
                data.append('deal_id', this.item.id);
                data.append('user_id', this.user_id);

                let config = {
                    header : {
                        'Content-Type' : 'image/png'
                    }
                }

                axios.post(
                    URL,
                    data,
                    config
                ).then(
                    response => {
                      this.images=response.data.images;
                    }
                )
            },

            deleteImage (id) {

                var params={};
                params.id=id;
                const URL = '/admin/api/deals/image/delete';
                axios.post(
                    URL,
                    params
                ).then(
                    response => {
                        this.images=response.data.images;
                    }
                )
            },


            getAddresses (callback)
            {
                if (this.addressValue.length) {
                    axios.get('/api/v1/kladr/place?query='+ this.addressValue).then((resp) => {
                        console.log('%cError: %O', 'color:green;', resp);
                        this.kladr = resp.data.data;
                        // this.addressSelected = this.kladr.cities[0];
                        // this.$refs.typeahead.inputValue=this.addressValue;
                        callback()
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

            successModeration () {
                axios.patch("/admin/api/deals/moderation/success/" + this.$route.params.id).then(resp => {
                    this.item = resp.data;
                    this.messageSuccessModeration();
                    this.$router.push({ name: "deals.moderation" });
                });
            },

            failModeration () {
                axios.patch("/admin/api/deals/moderation/fails/" + this.$route.params.id).then(resp => {

                    this.messageFailsModeration();
                    this.$router.push({ name: "deals.moderation" });
                });
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
                    this.addressValue=this.item.cities[0].name;
                    this.cityName=this.item.cities[0].name;
                    this.images=this.item.images;
                    this.getAddresses();

                });
            },
            saveItem() {
                this.item.city=this.addressSelected.id;
                // this.item.city.push();
                axios
                    .patch("/admin/api/deals/" + this.item.id, { data: this.item })
                    .then(resp => {
                        this.messageSaved();
                        //this.$router.push({ name: "deals" });
                    });
            },
            deleteItem() {
                console.log("deleted");
                axios.delete("/admin/api/deals/" + this.item.id).then(resp => {
                    this.messageDeleted();
                    this.$router.push({ name: "deals" });
                });
            }
        },

    };
</script>
<style scoped>
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
    .img {
        position: relative;
        margin-bottom: 10px;
    }
    .img img {
        width: 100%;
        height: 200px;
        display: flex;
    }
    .drop-img {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
</style>