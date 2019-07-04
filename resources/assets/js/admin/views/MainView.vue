<template>
    <!-- Main content -->
    <section class="content">
        <div class="row" v-if="areaData">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{areaData.deals.finish}}<sup style="font-size: 20px">%</sup></h3>

                        <p>Успешных сделок за сутки</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{areaData.deals.all}}</h3>

                        <p>Новых сделок за сутки</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{areaData.deals.members}}</h3>

                        <p>Новых пользователей за сутки</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Подробнее <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </section>
    <!-- /.content -->
</template>

<script>
    import {Component, Prop, Vue} from 'vue-property-decorator';
    import Raphael from 'raphael';
    import {AreaChart} from 'vue-morris';
    import ViewMixins from '../mixins/view'

    export default {
        mixins: [ViewMixins],
        data() {
            return {
                areaData: null,
            }
        },
        methods:{
            getDailyInfo(){
                //ToDo Get Daily info API
            },
            getStatistic() {
                axios.get('/admin/api/statistic').then((resp) => {
                    this.areaData = resp.data;
                }).catch((err) => {
                    console.log(err);
                })
            }
        },
        created(){
            this.getStatistic();
        }
    }
</script>

<style scoped>

</style>