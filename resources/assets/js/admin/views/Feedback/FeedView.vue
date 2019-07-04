<template>
    <!-- Main content -->
        <section class="content">
          <progressbar v-if="!item"></progressbar>

            <div class="box" v-if="item">
                <div class="row box-body">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="col-md-4">Параметр</th>
                                <th class="col-md-8">Значение</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr><td>Номер жалобы</td><td>{{item.id}}</td></tr>
                                <tr><td>Текст жалобы/обращения</td><td>{{item.description}}</td></tr>
                                <tr><td>Статус</td><td>{{item.status}}</td></tr>
                                <tr><td>Дата создания</td><td>{{item.created_at}}</td></tr>

                                <tr><td>Автор жалобы</td>
                                    <td v-if="item.owner">
                                        <router-link :to="{name: 'users.clients.edit', params: {id: item.owner.id}}">{{item.owner.name}}</router-link>
                                    </td>
                                    <td v-else="item.theme">
                                        {{item.theme}}
                                    </td>
                                </tr>

                                <tr v-if="item.message">
                                    <td>Жалоба на сообщение #{{item.message.id}}</td>
                                    <td>
                                        <ul>
                                            <li>{{item.message.user.name}}</li>
                                            <li v-if="item.message.user.organization">
                                                <router-link :to="{name: 'clients.view', params: {id: item.message.user.organization.id}}">{{item.message.user.organization.org_name}}</router-link>
                                            </li>
                                            <li>{{item.message.message}}</li>
                                            <li>{{item.message.created_at}}</li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr v-if="item.organization">
                                    <td>Жалоба на организацию #{{item.organization.id}}</td>
                                    <td>
                                        <router-link :to="{name: 'clients.view', params: {id: item.organization.id}}">{{item.organization.org_name}}</router-link>
                                    </td>
                                </tr>

                                <tr v-if="item.news">
                                    <td>Жалоба на новость #{{item.news.id}}</td>
                                    <td>
                                        <router-link :to="{name: 'news.edit', params: {id: item.news.id}}">{{item.news.title}}</router-link>
                                    </td>
                                </tr>

                                <tr v-if="item.news">
                                    <td>Жалоба на сделку #{{item.deal.id}}</td>
                                    <td>
                                        <router-link :to="{name: 'deal.view', params: {id: item.deal.id}}">{{item.deal.name}}</router-link>
                                    </td>
                                </tr>

                                <tr><td>Модератор</td>
                                    <td v-if="item.moder"><router-link :to="{name: 'users.edit', params: {id: item.moder.id}}">{{item.moder.name}}</router-link></td>
                                    <td v-else>Не выбран</td>
                                </tr>
                                <tr><td></td>
                                    <td>
                                        <select v-model="item.moder_id" :disabled="moders.length == 0" name="moders" class="form-control">
                                            <option value="">Не выбран</option>
                                            <option v-for="option in moders" v-bind:value="option.id">{{option.name}}</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 frm-buttons">
                        <div class="btn-group">
                            <input v-if="this.$root.profile.permissions.feedback.delete" class="btn btn-danger" type="button" @click="deleteItem" value="Удалить"/>
                            <input v-if="item.status != 'opened' && this.$root.profile.permissions.feedback.edit" class="btn btn-default" type="button" @click="item.status = 'opened'; updateItem()" value="Открыть"/>
                            <input v-if="item.status != 'progress' && this.$root.profile.permissions.feedback.edit" class="btn btn-default" type="button" @click="item.status = 'progress'; updateItem()" value="В работу"/>
                            <input v-if="item.status != 'closed' && this.$root.profile.permissions.feedback.edit" class="btn btn-default" type="button" @click="item.status = 'closed'; updateItem()" value="Закрыть"/>
                        </div>
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
                moders: [],
            }
        },
        mounted() {
            this.loadItem();
        },
        methods: {
            loadItem() {
                axios.get('/admin/api/feedback/' + this.$route.params.id)
                     .then((resp) => {
                         this.item = resp.data;
                     });

                axios.get('/admin/api/users')
                    .then((resp) => {
                        this.moders = resp.data.data;
                    });
            },

            updateItem() {
                axios.patch('/admin/api/feedback/' + this.item.id, this.item)
                    .then((resp) => {
                        this.messageSaved();
                    });
            },

            deleteItem() {
                axios.delete('/admin/api/feedback/' + this.item.id)
                    .then((resp) => {
                        this.messageDeleted();
                        this.$router.push({name: 'feedback.reports'});
                    });
            },
        },
    }
</script>
