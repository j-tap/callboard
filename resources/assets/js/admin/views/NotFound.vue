<template>
    <section class="content">

        <div class="error-page">
            <h2 class="headline text-red">404</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Упссс. Страница не наидена...</h3>
                <p>
                    Возможно вы выбрали неверный путь, попробуйте начать его сначала
                </p>
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
    }
</script>

<style>
    .error-content {
        text-align: center;
    }

    .error-page > .headline {
        line-height: 45px;
    }
</style>