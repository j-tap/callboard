<template>
    <div class="shadow">
        <div class="blockcomponent--wrapper">
            <div class="closeform--wrapper">
                <button
                        type="button"
                        v-on:click="$emit('closecomponent')"
                        class="btn pull-right closebutton"
                >X</button>
            </div>
            <div class="blockcomponent--body">
                <p class="blockcomponent--title">Пополнить кошелек</p>
                <form v-on:submit.prevent="updateBalance()" action="javascript:void(0);">
                    <div class="form-group">
                        <label for="summ">Введите сумму</label>
                        <input
                                required
                                v-model="summ"
                                type="text"
                                class="form-control"
                                id="summ"
                                placeholder="Введите сумму"
                        >
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Пополнить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import ViewMixins from "../../mixins/view";
    export default {
        mixins: [ViewMixins],
        props: {
            user: {
                type: [Array, Object]
            }
        },
        data() {
            return {
                summ: 0,
                scoreNumber: null
            };
        },
        methods: {


            updateBalance() {
                let params = {
                    unique_id: this.user.unique_id,
                    summ: this.summ
                };

                axios
                    .post("/admin/api/clients/update/balance", { params })
                    .then(resp => {
                        if (resp.data.result === true) {
                            this.showAlert("Кошелек пополнен");
                        } else {
                            this.showError("Произошла ошибка, попробуйте позднее");
                        }
                    })
                    .catch(this.handleErrorResponse);
            }
        }
    };
</script>
<style scoped>
    button.form-group {
        margin-bottom: 15px !important;
    }
    button.center-block {
        margin-top: 10px;
    }
    .shadow {
        position: fixed;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 10;
        background: #0006;
    }
    .blockcomponent--wrapper {
        width: 400px;
        position: fixed;
        left: calc(50% - 200px);
        top: 30%;
        background: white;
        padding: 15px;
    }
    .blockcomponent--title {
        font-weight: 600;
    }
    .closebutton {
        padding: 0;
        background: transparent;
        font-weight: 600;
        line-height: 0;
        cursor: pointer;
        height: 11px;
    }
</style>
