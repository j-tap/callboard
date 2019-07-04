<template>
    <div class="flex-box f-col user-access">
        <div class="user-access__wrapp">
            <div class="flex-row user-access__close">
                <div class="flex-row__col f-grow-1 f-align-center f-content-right">
                    <button class="button flex-box f-align-center f-content-right" @click="accessClose">
                        <p>Закрыть</p>
                        <span class="flex-box f-align-center f-content-center"><closesvg iconColor="white"></closesvg></span>
                    </button>
                </div>
            </div>
            <div class="container--flex f-col user-access__container">
                <div class="flex-row user-access__container__user-info f-align-start">
                    <div class="flex-row__col f-grow-1">
                        <v-text-field
                            v-model="data.user['name']"
                            :error="err ? err['user.name'] ? true : false : false"
                            label="ФИО"
                            color="#1a89fe"
                            hide-details
                            required></v-text-field>
                    </div>
                    <!--<div class="flex-row__col f-grow-1">-->
                    <!--<v-text-field-->
                    <!--v-model="second_name"-->
                    <!--label="Фамилия"-->
                    <!--color="#1a89fe"-->
                    <!--hide-details-->
                    <!--required></v-text-field>-->
                    <!--</div>-->
                    <div class="flex-row__col f-grow-1">
                        <v-text-field
                            v-model="data.user['email']"
                            :error="err ? err['user.email'] ? true : false : false"
                            label="E-mail"
                            color="#1a89fe"
                            hide-details
                            required></v-text-field>
                    </div>
                    <div class="flex-row__col f-grow-1">
                        <v-text-field
                            v-model="data.user['password']"
                            :error="err ? err['user.password'] ? true : false : false"
                            label="Пароль"
                            color="#1a89fe"
                            hide-details
                            required></v-text-field>
                    </div>
                </div>
                <div class="flex-box f-col f-grow-1 user-access__container-body">
                    <header class="flex-row">
                        <div class="flex-row__col f-width-full f-align-center"><span>Доступ к разделу</span></div>
                        <div class="flex-row__col f-width-full f-align-center"><span>Права</span></div>
                    </header>

                    <template v-for="permission in permissionList">
                        <div :class="'flex-row user-access__box-row f-align-center '+ (index == permission.permissions.length-1 ? 'user-access__box-row-border': '')" v-for="(permissionEl,index) in permission.permissions">
                            <div class="user-access__row" v-if="index==0">
                                <div class="flex-row__col f-width-full f-align-center">
                                    <span class="flex-box f-align-center">{{permission.name}}</span>
                                    <!--<v-switch-->
                                    <!--color="#79dc76"-->
                                    <!--hide-details></v-switch>-->
                                </div>

                                <div class="flex-row__col f-width-full f-align-center">
                                    <div class="flex-row__col">
                                        <span class="flex-box f-align-center">{{getPermissionLocale(permissionEl)}}</span>
                                        <v-switch v-model="data.permissions[permission.slug][permissionEl]"
                                                  class="mr-20"
                                                  color="#79dc76"
                                                  hide-details></v-switch>
                                    </div>
                                </div>
                            </div>
                            <div class="user-access__row" v-else>
                                <div class="flex-row__col f-width-full f-align-center f-offset-50">
                                    <div class="flex-row__col">
                                        <span class="flex-box f-align-center">{{getPermissionLocale(permissionEl)}}</span>
                                        <v-switch v-model="data.permissions[permission.slug][permissionEl]"
                                                  class="mr-20"
                                                  color="#79dc76"
                                                  hide-details></v-switch>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </template>
                    <div class="flex-row f-noshrink f-align-center f-content-center user-access__container__action">
                        <div class="flex-row__col ">
                            <button class="flex-box f-align-center f-content-center button btn-lg btn__solid-blue-sq" v-if="!$route.params.id" @click="saveUser">
                                <p>Добавить</p>
                            </button>
                            <button class="flex-box f-align-center f-content-center button btn-lg btn__solid-blue-sq" v-else @click="updateUser">
                                <p>Сохранить изменения</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["isAccessOpen"],
        data() {
            return {

                data: {
                    user: {},
                    permissions: {}
                },
                permissionList: null,
                err: null,
            }
        },
        created() {
            this.loadPermissions();
            if (this.$route.params.id) {
                this.getUserInfo();
            }
        },
        methods: {

            accessClose() {
                this.$router.push({name: 'lk.pro.accounts'})
            },

            loadPermissions() {
                this.$parent.$parent.loading = true;
                axios.get('/api/v1/organization/manage/permissions').then((resp) => {
                    this.permissionList = resp.data.data;
                    for (var prop in this.permissionList) {
                        var slug = resp.data.data[prop].slug;
                        this.data.permissions[slug] = {};
                    }
                    this.$parent.$parent.loading = false;
                }).catch((error) => {
                });
            },

            getUserInfo() {
                this.$parent.$parent.$parent.$parent.loading = true;
                axios.get('/api/v1/organization/manage/user/' + this.$route.params.id).then((resp) => {
                    this.data = resp.data.data;
                    this.$parent.$parent.loading = false;
                }).catch((error) => {
                    this.$parent.$parent.loading = false;
                })
            },

            saveUser() {
                this.err = {};
                this.$parent.$parent.loading = true;
                axios.post('/api/v1/organization/manage/users/store', this.data).then((resp) => {
                    this.$parent.$parent.snackbar.color = 'success';
                    this.$parent.$parent.snackbar.text = "Пользователь успешно добавлен";
                    this.$parent.$parent.snackbar.toggle = true;
                    this.$parent.$parent.loading = false;
                    this.$router.push({name:'lk.pro.accounts'});
                }).catch((error) => {
                    this.$parent.$parent.snackbar.color = 'error';
                    this.$parent.$parent.snackbar.text = "Ошибка";
                    this.$parent.$parent.snackbar.toggle = true;
                    this.$parent.$parent.loading = false;
                    this.err = error.response.data.errors;
                });
            },

            updateUser() {
                this.$parent.$parent.loading = true;
                axios.patch('/api/v1/organization/manage/users/update/' + this.$route.params.id, this.data).then((resp) => {
                    this.$parent.$parent.snackbar.color = 'success';
                    this.$parent.$parent.snackbar.text = "Данные обновлены";
                    this.$parent.$parent.snackbar.toggle = true;
                    this.$parent.$parent.loading = false;
                    this.$router.push({name:'lk.pro.accounts'});
                }).catch((error) => {
                    this.$parent.$parent.snackbar.color = 'error';
                    this.$parent.$parent.snackbar.text = "Ошибка";
                    this.$parent.$parent.snackbar.toggle = true;
                    this.$parent.$parent.loading = false;
                    this.err = error.response.data.errors;
                })
            },


            getPermissionLocale(permission) {
                switch (permission) {
                    case 'buy':
                        return 'Покупка';
                    case 'add':
                        return 'Добавление';
                    case 'show':
                        return 'Просмотр';
                    case 'create':
                        return 'Создание';
                    case 'edit':
                        return 'Редактирование';
                    case 'delete':
                        return 'Удаление';
                    case 'moderate':
                        return 'Премодерация';
                    default:
                        break;
                }
            },

        },

    }
</script>

<style lang="scss">

</style>