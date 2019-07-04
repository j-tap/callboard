<template>
    <div id="app">
        <div v-if="this.$root.loadError">
            <div class="callout callout-danger">
                <h4>Ошибка!</h4>
                <p>При загрузке данных приложения произошла ошибка! Сохраняйте спокойствие и свяжитесь со службой поддержки.</p>
            </div>
        </div>
        <div v-if="this.$root.profile">
            <nprogress-container></nprogress-container>
            <main-header></main-header>
            <main-sidebar></main-sidebar>
            <control-sidebar></control-sidebar>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{{pageTitle}}</h1>
                    <ol class="breadcrumb">
                        <li><router-link :to="{name: 'home'}"><i class="fa"></i> Главная</router-link></li>
                        <li v-for="crumb in breadcrumbs" :class="[crumb.path ? '' : 'active']">
                            <router-link v-if="crumb.path" :to="{name: crumb.path, params: crumb.params}">{{crumb.name}}</router-link>
                            <span v-else>{{crumb.name}}</span>
                        </li>
                    </ol>
                </section>
                <router-view :pageTitle="pageTitle"></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    import NprogressContainer from 'vue-nprogress/src/NprogressContainer';
    import MainHeader from "./Components/MainHeader";
    import ControlSidebar from "./Components/ControlSidebar";
    import MainSidebar from "./Components/MainSidebar";

    export default {
        components: {MainSidebar, ControlSidebar, MainHeader, NprogressContainer},
        data() {
            return {
                pageTitle: 'test',
                breadcrumbs: [],
            }
        },
        created() {
            this.$root.$on('showAlert', (message) => {
                alert(message);
            });

            this.$root.$on('setTitle', (title) => {
                this.pageTitle = title;
                this.$forceUpdate();
            });

            this.$root.$on('addBreadcrumb', (crumb) => {
                this.breadcrumbs.push(crumb);
                this.$forceUpdate();
            });

            this.$root.$on('clearBreadcrumbs', () => {
                this.breadcrumbs = [];
                this.$forceUpdate();
            });

            this.$root.$on('setBreadcrumbs', (crumbs) => {
                this.breadcrumbs = crumbs;
                this.$forceUpdate();
            });
        }
    }
</script>
<style>
    .callout {
        margin: 0;
    }
</style>