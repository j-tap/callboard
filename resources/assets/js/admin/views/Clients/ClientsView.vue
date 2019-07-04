<template>
    <!-- Main content -->
        <section class="content">
          <progressbar v-if="!item"></progressbar>

            <div class="box" v-if="item">
                <div class="row box-body">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs pull-right">
                                <li :class="['pull-left', activeTab == 1 ? 'active':'']" @click="activeTab = 1"><a>Данные аккаунта</a></li>
                                <li :class="['pull-left', activeTab == 2 ? 'active':'']" @click="activeTab = 2"><a>Данные компании</a></li>
                                <li :class="['pull-left', activeTab == 3 ? 'active':'']" @click="activeTab = 3"><a>Сотрудники</a></li>
                                <li :class="['pull-left', activeTab == 4 ? 'active':'']" @click="activeTab = 4"><a>Склады</a></li>
                                <li :class="['pull-left', activeTab == 5 ? 'active':'']" @click="activeTab = 5"><a>Офисы</a></li>
                            </ul>
                            <div class="tab-content no-padding">
                                <div :class="['tab-pane row', activeTab == 5 ? 'active':'']">
                                    <div class="col-md-12">
                                        <table v-if="item.owner" id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="col-md-4">ID</th>
                                                <th class="col-md-8">Адрес</th>
                                                <th class="col-md-8">Координаты</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(office, key) in item.offices">
                                                <td>{{office.id}}</td>
                                                <td>{{office.address}}</td>
                                                <td>{{office.geo_lat}} {{office.geo_lon}}</td>
                                                <td v-if="$root.profile.permissions.clients.edit">
                                                    <button type="button" class="btn btn-danger btn-xs" v-on:click="deleteOffice(key)"><i class="fa fa-fw fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div :class="['tab-pane row', activeTab == 4 ? 'active':'']">
                                    <div class="col-md-12">
                                        <table v-if="item.owner" id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="col-md-4">ID</th>
                                                <th class="col-md-8">Адрес</th>
                                                <th class="col-md-8">Координаты</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(store, key) in item.stores">
                                                <td>{{store.id}}</td>
                                                <td>{{store.address}}</td>
                                                <td>{{store.geo_lat}} {{store.geo_lon}}</td>
                                                <td v-if="$root.profile.permissions.clients.edit">
                                                    <button type="button" class="btn btn-danger btn-xs" v-on:click="deleteStore(key)"><i class="fa fa-fw fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div :class="['tab-pane row', activeTab == 3 ? 'active':'']">
                                    <div class="col-md-12">
                                        <table v-if="item.owner" id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="col-md-4">ID</th>
                                                <th class="col-md-8">Имя пользователя</th>
                                                <th class="col-md-8">Email</th>
                                                <th class="col-md-8">Роль</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="user in item.users">
                                                    <td>{{user.id}}</td>
                                                    <td>
                                                        <router-link :to="{name: 'users.clients.edit', params: {id: user.id}}">{{user.name}}</router-link>
                                                    </td>
                                                    <td>{{user.email}}</td>
                                                    <td>{{user.role}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div :class="['tab-pane row', activeTab == 1 ? 'active':'']">
                                    <div class="col-md-12">
                                        <table v-if="item.owner" id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4">Тип данных</th>
                                                    <th class="col-md-8">Значение</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ID</td><td>{{item.owner.id}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Лигин в системе</td><td>{{item.owner.name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td><td>{{item.owner.email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Дата регистрации</td><td>{{item.owner.created_at}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div :class="['tab-pane row', activeTab == 2 ? 'active':'']">
                                    <div class="col-md-12">
                                        <table v-if="item" id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-4">Тип данных</th>
                                                    <th class="col-md-8">Значение</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ID</td><td>{{item.id}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Статус</td><td>{{getOrgStatus(item.org_status)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Тип</td><td>{{getOrgType(item.org_type)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Название</td><td>{{item.org_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Имя пользователя</td><td>{{item.first_name}} {{item.second_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>ИНН</td><td>{{item.org_inn}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Телефон</td><td>{{item.phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Веб сайт</td><td v-if="item.org_site">{{item.org_site}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Город</td><td v-if="item.city">{{item.city.region.country.name}} / {{item.city.region.name}} / {{item.city.name}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Организационно правовая форма</td><td v-if="item.legal_form">{{item.legal_form.name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>ФИО директора</td><td v-if="item.org_director">{{item.org_director}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Юр. адрес</td><td v-if="item.org_address">{{item.org_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Физ. адрес</td><td v-if="item.org_address_legal">{{item.org_address_legal}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Рейтинг</td><td>{{item.rating}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Описание</td><td v-if="item.org_description">{{item.org_description}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Дата создания</td><td>{{item.created_at}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Время работы</td><td>{{item.work_time}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Дата последнего изменения</td><td>{{item.updated_at}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Дата удаления</td><td>{{item.deleted_at}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 frm-buttons">
                        <router-link v-if="this.$root.profile.permissions.clients.edit" :to="{name: 'clients.edit', props: {id: item.id}}" class="btn btn-default">Редактировать</router-link>
                    </div>
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
                activeTab: 1,
                itemId: '',
                item: null,
            }
        },
        mounted() {
            this.loadItem();
        },
        methods: {
            loadItem() {
                axios.get('/admin/api/clients/' + this.$route.params.id)
                     .then((resp) => {
                         this.item = resp.data;
                     });
            },

            deleteOffice(id) {
                var office = this.item.offices[id];
                this.item.offices.splice(id, 1);
                axios.delete('/admin/api/clients/office/' + office.id)
                    .then((resp) => {
                    });
            },

            deleteStore(id) {
                var store = this.item.stores[id];
                this.item.stores.splice(id, 1);
                axios.delete('/admin/api/clients/store/' + store.id)
                    .then((resp) => {
                    });
            }
        },
    }
</script>
