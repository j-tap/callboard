<template>
    <div class="content" v-if="statistic">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Количество сделок</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Параметры</th>
                                <th style="width: 60px"></th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Размещенных</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.deals.all}}</span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Успешных</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.deals.finish}}</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Минимальный бюджет сделки</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.deals.min_budget}}</span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Максимальный бюджет сделки</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.deals.max_budget}}</span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Средний бюджет сделки</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.deals.middle_budget}}</span></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Количество участников</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.deals.members}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- ======================= -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Количество быстрых сделок</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Параметры</th>
                                <th style="width: 60px"></th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Размещенных</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.fast_deals.all}}</span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Успешных</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.fast_deals.finish}}</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Минимальный бюджет сделки</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.fast_deals.min_budget}}</span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Максимальный бюджет сделки</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.fast_deals.max_budget}}</span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Средний бюджет сделки</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.fast_deals.middle_budget}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Количество участников</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.fast_deals.members}}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- =================== -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Количество новых пользователей</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Параметры</th>
                                <th style="width: 60px"></th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Общее</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.user.all}}</span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Пользователи-поставщики</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.user.sellers}}</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Пользователи-покупатели</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.user.buyers}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- ======================= -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Покупка платных услуг</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Параметры</th>
                                <th style="width: 60px"></th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Покупка PRO - аккаунта</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.pro.buys}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Покупка рекламы в рубрике</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.pro.ad_rubric}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Покупка рекламы на платформе</td>
                                <td>
                                    <span class="badge bg-light-blue">{{this.statistic.pro.ad_platform}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Покупка размещения акций</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.pro.ad_stocks}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Покупка выделенного в поиске и на карте</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.pro.ad_map}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Покупка доступа к быстрым сделкам</td>
                                <td>
                                    <span class="badge bg-light-blue">{{this.statistic.pro.ad_fast}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>Покупка дополнительного участия в сделках</td>
                                <td><span class="badge bg-light-blue">{{this.statistic.pro.ad_member}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td>Покупка дополнительного размещения новости</td>
                                <td>
                                    <span class="badge bg-light-blue">{{this.statistic.pro.ad_news}}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- ============ -->
        </div>
    </div>
</template>

<script>
    import ViewMixins from '../mixins/view'

    export default {
        mixins: [ViewMixins],
        props: ['wTitle', 'wParams', 'wStatistic'],
        data() {
            return {
                statistic: null,
            }
        },
        methods: {
            getStatistic() {
                axios.get('/admin/api/statistic').then((resp) => {
                    this.statistic = resp.data;
                }).catch((err) => {
                    console.log(err);
                })
            }
        },
        created() {
            this.getStatistic();
        }
    }
</script>

<style>

</style>