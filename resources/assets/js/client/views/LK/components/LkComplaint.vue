<template>
    <div class="complaint" v-if="$route.params.data">
        <div class="complaint-container">
            <div class="complaint-body">
                <div class="flex-row complaint-body__header f-content-center"><h3>Пожаловаться</h3></div>
                <div class="flex-box complaint-body__info  f-content-center f-col">
                    <div class="flex-row ">
                        <div class="flex-row__col f-grow-1">
                            <h3>{{$route.params.data.organization.name}}</h3>
                        </div>
                        <div class="flex-row__col">
                            <span class="flex-box f-align-center f-content-center complaint-time">{{complaint.time}}</span>
                        </div>
                    </div>
                    <!--<div class="flex-row">-->
                    <!--<p class="lk__messages_p-grey"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. At,-->
                    <!--minus.-->
                    <!--</p>-->
                    <!--</div>-->
                </div>
                <div class="flex-row complaint-body__desc f-content-center f-col">
                    <v-text-field
                        v-model="item.theme"
                        color="#1a89fe"
                        :error="err ? !!err['theme'] : false"
                        :rules="[ () => !!item.description || 'Обязательное поле']"

                        label="Тема"
                    ></v-text-field>
                    <v-textarea
                        v-model="item.description"
                        auto-grow
                        color="#1a89fe"
                        label="Описание"
                        :error="err ? !!err['description'] : false"
                        :rules="[ () => !!item.description && item.description.length >= 8 || 'Не менее 8 символов']"
                        rows="1"
                        counter="360"
                    ></v-textarea>
                </div>
                <div class="flex-row complaint-body__action f-content-center">
                    <button class="button btn-md btn__solid-blue-round" @click="sendComplaint">
                        <p> Отправить</p>
                    </button>
                    <button class="button btn-md btn__solid-red-round" @click="modalClose">
                        <p>Отмена</p>
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LkComplaint",
        data() {
            return {
                item: {
                    theme: null,
                    description: null,
                    time: null,
                },
                optionsCurrentDate: {
                    hour: 'numeric',
                    minute: 'numeric',
                },
                err: null,
            }
        },
        methods: {
            modalClose() {
                this.$router.push({name: 'lk.dialogs'});
            },
            sendComplaint() {
                this.err = {};
                axios.post('/api/v1/feedback/report', this.complaint).then((resp) => {
                    this.$parent.$parent.snackbar.color = 'success';
                    this.$parent.$parent.snackbar.text = "Жалоба отправлена";
                    this.$parent.$parent.snackbar.toggle = true;
                    this.$parent.$parent.loading = false;
                    this.$router.push({name: 'lk.dialogs'});
                }).catch((err) => {
                    this.$parent.$parent.snackbar.color = 'error';
                    this.$parent.$parent.snackbar.text = "Ошибка";
                    this.$parent.$parent.snackbar.toggle = true;
                    this.$parent.$parent.loading = false;
                    this.err = err.response.data.errors;
                })
            },

        },
        computed: {
            complaint() {
                let data = {
                    theme: this.item.theme,
                    description: this.item.description,
                    time: new Date().toISOString().substring(11, 16),
                    org_id: this.$route.params.data.organization.id,
                };
                return data;
            },
        },
        created() {
            if (!this.$route.params.data) {
                this.modalClose();
            }
        }
    }
</script>

<style lang="scss">

</style>