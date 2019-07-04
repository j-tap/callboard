<template>

    <div class="col-md-2">
        <div class="box box-solid">
            <div class="box-header with-border" v-if="item.id">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">{{item.name}}</h3>
            </div>
            <div class="box-header with-border" v-if="!item.id">
                    <input type="text" placeholder="Введите название слуги" class="form-control" v-model="item.name">
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="days">Дней </label>
                    <input class="form-control" v-model="item.days" id="days" type="number"/>
                </div>
                <div class="form-group">
                    <label for="cost">Цена </label>
                    <input class="form-control" v-model="item.cost" id="cost" type="number"/>
                </div>
                <div v-if="this.$root.profile.permissions.adservice.edit" class="frm-buttons">
                    <div class="btn-group" v-if="item.id">
                        <input class="btn btn-xs btn-success" @click="updateItem()" value="Принять" type="submit"/>
                    </div>
                    <div class="btn-group" v-if="!item.id">
                        <input class="btn btn-xs btn-success" @click="saveItem" value="Сохранить" type="submit"/>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</template>

<script>
    export default {
        props: {
            item: Object
        },
        mounted() {
        },
        methods: {
            updateItem() {
                axios.patch('/admin/api/ad/service/' + this.item.id, this.item).then((resp) => {
                    this.$root.messageSaved();
                }).catch(this.$root.handleErrorResponse);
            },
            saveItem() {
                axios.post('/admin/api/ad/services/store', this.item).then((resp) => {
                    console.log(resp);
                }).catch((err) => {
                    console.log(err.response.data.errors);
                })
            }
        }
    }
</script>