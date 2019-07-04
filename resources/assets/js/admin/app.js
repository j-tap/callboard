require("../bootstrap");
require("../../../../node_modules/jquery/dist/jquery");
require("../../../../node_modules/jquery-ui/ui/widget");
require("../../../../node_modules/bootstrap/dist/js/bootstrap");
require("../../../../node_modules/admin-lte/dist/js/adminlte.min.js");
require("../../../../node_modules/admin-lte/plugins/iCheck/icheck");
require("../../../../node_modules/datatables.net/js/jquery.dataTables");
require("../../../../node_modules/datatables.net-bs/js/dataTables.bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import NProgress from "vue-nprogress";
import App from "./views/App";
import routes from "./app.routes";
import LocaleMixins from "./mixins/locale";
import Message from "vue-m-message";
import ApplicationMixin from "./mixins/application";
import ViewMixins from "./mixins/view";
import ProgressBar from "./views/Components/Progressbar";

//подключение новых компонентов  -начало

// блокировать/разблокировать пользователя
import userblock from "./views/Components/blockcomponent";
Vue.component("userblock", userblock);

// формирование и отправка счёта
import scoreform from "./views/Components/scoreform";
Vue.component("scoreform", scoreform);
// подключение новых компонентов  -конец

Vue.use(Message);
Vue.use(VueRouter);
Vue.use(NProgress, {
  latencyThreshold: 200,
  router: true,
  http: false
});
Vue.mixin(LocaleMixins);

Vue.component("datatable", require("./views/Components/Datatable.vue"));
Vue.component("progressbar", ProgressBar);

const router = new VueRouter({
  mode: "history",
  routes: routes
});

router.beforeEach((to, from, next) => {
	// document.title = to.meta.title;
	const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title)
	// Найти ближайший элемент маршрута с метатегами
	const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags)
	const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags)
	// Если был найден маршрут с заголовком, присвойте заголовку документа (страницы) это значение
	if (nearestWithTitle) document.title = nearestWithTitle.meta.title
	// Удалите все устаревшие метатеги из документа, используя атрибут ключа, который мы установили ниже
	Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el))
	// Пропустить рендеринг метатегов, если их нет
	if (!nearestWithMeta) return next()
	// Превратите определения метатегов в реальные элементы в head
	nearestWithMeta.meta.metaTags.map(tagDef => {
		const tag = document.createElement('meta')

		Object.keys(tagDef).forEach(key => {
			tag.setAttribute(key, tagDef[key])
		})
		// Мы используем это, чтобы отследить, какие метатеги мы создаем, чтобы не мешать другим
		tag.setAttribute('data-vue-router-controlled', '')

		return tag
	})
	// Добавьте метатеги в document head
	.forEach(tag => document.head.appendChild(tag))
	next()
});

const nprogress = new NProgress({ parent: ".nprogress-container" });

const app = new Vue({
  nprogress,
  router,
  mixins: [ApplicationMixin, ViewMixins],
  render: h => h(App),
  components: {
    NProgress
  }
});
