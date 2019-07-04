<template>
    <!-- Main content -->
    <section class="content">
        <div v-if="!info" class="row">
            <div class="col-md-12">
                <div class="callout callout-info">
                    <h4>Данные о системе</h4>
                    <p>Подождите, идет сбор данных о системе.</p>
                </div>
            </div>
        </div>
        <div v-if="info" class="row">
            <!-- Left -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Информация о клиенте (IP)</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                                <tr><td>Город</td><td>{{info.client.city}}</td></tr>
                                <tr><td>Регион</td><td>{{info.client.region}}</td></tr>
                                <tr><td>Страна</td><td>{{info.client.country}}</td></tr>
                                <tr><td>Имя хоста</td><td>{{info.client.hostname}}</td></tr>
                                <tr><td>IP Address</td><td>{{info.client.ip}}</td></tr>
                                <tr><td>Организация</td><td>{{info.client.org}}</td></tr>
                                <tr><td>Координаты</td><td>{{info.client.loc}}</td></tr>
                                <tr><td>Телефон</td><td>{{info.client.phone}}</td></tr>
                                <tr><td>Почтовый код</td><td>{{info.client.postal}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Информация о хосте (IP)</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr><td>Город</td><td>{{info.host.city}}</td></tr>
                            <tr><td>Регион</td><td>{{info.host.region}}</td></tr>
                            <tr><td>Страна</td><td>{{info.host.country}}</td></tr>
                            <tr><td>Имя хоста</td><td>{{info.host.hostname}}</td></tr>
                            <tr><td>IP Address</td><td>{{info.host.ip}}</td></tr>
                            <tr><td>Организация</td><td>{{info.host.org}}</td></tr>
                            <tr><td>Координаты</td><td>{{info.host.loc}}</td></tr>
                            <tr><td>Телефон</td><td>{{info.host.phone}}</td></tr>
                            <tr><td>Почтовый код</td><td>{{info.host.postal}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Right -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Информация о БД</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                                <tr><td>Driver</td><td>{{info.database.driver}}</td></tr>
                                <tr><td>Версия</td><td>{{info.database.version}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Железо</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                                <tr><td>Модель</td><td>{{info.server.hardware.model}}</td></tr>
                                <tr><td>CPU</td><td>{{info.server.hardware.cpu}}</td></tr>
                                <tr><td>CPU кол-во</td><td>{{info.server.hardware.cpu_count}}</td></tr>
                                <tr><td>HDD (free)</td><td>{{info.server.hardware.disk.free}}</td></tr>
                                <tr><td>HDD (total)</td><td>{{info.server.hardware.disk.total}}</td></tr>
                                <tr><td>RAM (free)</td><td>{{info.server.hardware.ram.free}}</td></tr>
                                <tr><td>RAM (total)</td><td>{{info.server.hardware.ram.total}}</td></tr>
                                <tr><td>Swap (free)</td><td>{{info.server.hardware.swap.free}}</td></tr>
                                <tr><td>Swap (total)</td><td>{{info.server.hardware.swap.total}}</td></tr>
                                <tr><td>Виртуализация</td><td>{{info.server.hardware.virtualization}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Программная часть</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                                <tr><td>Архитектура</td><td>{{info.server.software.arc}}</td></tr>
                                <tr><td>Дистрибутив</td><td>{{info.server.software.distro}}</td></tr>
                                <tr><td>Ядро</td><td>{{info.server.software.kernek}}</td></tr>
                                <tr><td>ОС</td><td>{{info.server.software.os}}</td></tr>
                                <tr><td>PHP</td><td>{{info.server.software.php}}</td></tr>
                                <tr><td>Webserver</td><td>{{info.server.software.webserver}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Uptime</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr><td>Uptime</td><td>{{info.server.uptime.uptime}}</td></tr>
                            <tr><td>Booted at</td><td>{{info.server.uptime.booted_at}}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
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
                info: null
            }
        },
        mounted() {
            this.getInfo();
        },
        methods: {
            getInfo() {
                this.$root.$nprogress.start();

                axios.get('/admin/api/sysinfo')
                    .then((resp) => {
                        this.$root.$nprogress.done();
                        this.info = resp.data;
                    })
                    .catch(() => {
                        this.$root.$nprogress.done();
                        this.showError('Неудалось получить данные о системе');
                    });
            }
        }
    }
</script>