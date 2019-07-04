import Vue from 'vue'

import Page404 from '../views/MapScreen/components/Page404.vue'
import CategoryList from '../views/MapScreen/components/CategoryList.vue'
import CategoryTile from '../views/MapScreen/components/CategoryTile.vue'
import CategoryIcons from '../views/MapScreen/components/CategoryIcons.vue'
import LkNavBar from '../views/LK/components/LkNavBar.vue'
import LkAccess from '../views/LK/components/LkAccess.vue'
import Loader from '../views/GeneralComponents/components/Loader.vue'

Vue.component('Loader', Loader)
Vue.component('CategoryIcons', CategoryIcons)
Vue.component('Page404', Page404);
Vue.component('CategoryList', CategoryList)
Vue.component('categorytile', CategoryTile)
Vue.component('LkNavBar', LkNavBar)
Vue.component('LkAccess', LkAccess)
