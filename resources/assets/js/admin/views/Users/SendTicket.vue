<template>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <form class="row box-body" @submit="saveForm">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div :class="['form-group', errors['user.name'] ? 'has-error' : '']">
                            <label for="title">Тема</label>
                            <input
                                    v-model="title"
                                    type="text"
                                    class="form-control"
                                    id="title"
                                    placeholder="Введите тему обращения"
                            >

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12">
                        <div :class="['form-group', errors['user.name'] ? 'has-error' : '']">
                            <label for="text_body">Текст</label>
                            <textarea
                                    v-model="text_body"
                                    type="text"
                                    class="form-control"
                                    id="text_body"
                                    placeholder="Введите текст обращения"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 frm-buttons">
                    <input class="btn btn-default pull-right" type="submit" value="Добавить">
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import ViewMixins from "../../mixins/view";

    export default {
        mixins: [ViewMixins],
        data() {
            return {
                title:'',
                text_body:''
            };
        },
        mounted() {

        },
        methods: {
            saveForm(event) {
                event.preventDefault();
                var params ={};
                params.title=this.title;
                params.text_body=this.text_body;
                axios
                    .post("/admin/api/users/create/ticket/1", params)
                    .then(resp => {
                        this.messageCreated();

                    })
                    .catch(error => {
                        this.handleErrorResponse();
                    });
            },


        }
    };
</script>