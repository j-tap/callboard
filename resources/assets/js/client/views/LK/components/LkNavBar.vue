<template>
    <header :class="'flex-row header f-noshrink ' + (this.$route.name == 'lk.services' ? 'header__transparent': '')">
        <router-link :to="{name:'map.categories', params: {} }" class="flex-box f-align-center f-content-center logo">
            <logoheader></logoheader>
        </router-link>
        <nav class="flex-row__col f-grow-1 f-content-right nav__list" v-if="$root.profile">
            <ul class="flex-row nav__list f-align-center">
                <li class="flex-row__col nav__list__item f-align-center">
                    <router-link class="nav__list__item-link f-align-center f-content-center"
                                 :to="{ name: 'lk.account', params: {} }" v-if="$root.profile.company.organization.type == 'supplier'">
                        <profilesvg iconColor="white"></profilesvg>
                    </router-link>
                    <router-link class="nav__list__item-link f-align-center f-content-center"
                                 :to="{ name: 'lk.profile', params: {} }" v-else>
                        <profilesvg iconColor="white"></profilesvg>
                    </router-link>
                </li>
                <li class="flex-row__col nav__list__item f-align-center">
                    <router-link class="nav__list__item-link f-align-center f-content-center"
                                 :to="{ name: 'lk.notifications', params: {} }">
                        <notificationsvg iconColor="white"></notificationsvg>
                    </router-link>
                </li>
                <li class="flex-row__col nav__list__item f-align-center ">
                    <span class="nav__list__item-notify" v-if="$root.notification"></span>
                    <router-link class="nav__list__item-link f-align-center f-content-center"
                                 :to="{ name: 'lk.dialogs', params: {} }">
                        <messagesvg iconColor="white"></messagesvg>
                    </router-link>
                </li>
                <li class="flex-row__col nav__list__item f-align-center ">
                    <router-link class="nav__list__item-link f-align-center f-content-center"
                                 :to="{ name: 'view.news', params: {} }">
                        <newssvg iconColor="white"></newssvg>
                    </router-link>
                </li>
                <li class="flex-row__col nav__list__item f-align-center ">
                    <router-link class="nav__list__item-link f-align-center f-content-center"
                                 :to="{ name: '', params: {} }">
                        <supportsvg iconColor="white"></supportsvg>
                    </router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
    export default {
       data(){
           return{

           }
       }
    }
</script>

<style lang="scss">
.header {

}
</style>