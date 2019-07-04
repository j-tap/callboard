require("../bootstrap");
require("./api/api");
// require('./api/api.filter');
require("./imports/icons.js");
require("./imports/components.js");
import "babel-polyfill";
import Vue from "vue";
import VueRouter from "vue-router";
import App from "./views/App";
import { store } from "./store";
// import MapMixin from './mixins/map.mixin'
import routes from "./routes/routes";
import ApplicationMixin from "./mixins/application";
import GlobalMixin from "./mixins/global";
import Vuetify from "vuetify";
import Cookies from "js-cookie";

import vClickOutside from "v-click-outside";
Vue.use(vClickOutside);
import "vuetify/dist/vuetify.min.css";
import "material-design-icons-iconfont/dist/material-design-icons.css";

require("../../sass/client/utils/vuetify-custom.scss");
window.io = require("socket.io-client");

Vue.use(Vuetify);
Vue.mixin(GlobalMixin);
// Vue.mixin(MapMixin)
Vue.use(VueRouter);

import VueFeather from "vue-feather";
Vue.component(VueFeather.name, VueFeather);

try {
  window.Popper = require("popper.js").default;
  window.$ = window.jQuery = require("jquery");
  require("bootstrap");
} catch (e) {}

import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);

import VeeValidate, { Validator } from "vee-validate";
import VeeValidateRu from "vee-validate/dist/locale/ru";
VeeValidateRu.messages.confirmed = () => "Пароли не совпадают.";

VeeValidateRu.messages.decimal = field => {
  return (
    "Поле " +
    field +
    " должно быть числовым и может содержать 2 знака после точки."
  );
};

Validator.localize({
  ru: VeeValidateRu
});
Vue.use(VeeValidate, {
  locale: "ru",
  events: "input|blur"
});

const router = new VueRouter({
  mode: "history",
  routes: routes
});

router.beforeEach((to, from, next) => {
  let token = Cookies.get("api_auth");

  if (!token && to.matched.some(m => m.meta.auth)) {
    next({ name: "register" });
  } else {
    document.title = to.meta.title;
    next();
  }
});

if (BUILD_MODE === "production") {
  window.isProdMode = true;
} else if (BUILD_MODE === "development") {
  window.isDevMode = true;
}

const app = new Vue({
  store,
  router,
  render: h => h(App),
  mixins: [ApplicationMixin],
  components: {}
});

Vue.prototype.$snackbar = app.$store.state.snackbar;

console.group(`%cGit info:`, "background:#222; color:#bada55");
console.log("%cdate: %s", "background:#222; color:#bada55", GIT_DATE);
console.log("%cbranch: %s", "background:#222; color:#bada55", GIT_BRANCH);
console.log("%cver: %s", "background:#222; color:#bada55", GIT_VERSION);
console.log("%chash: %s", "background:#222; color:#bada55", GIT_COMMITHASH);
console.groupEnd();

Vue.config.errorHandler = (err, vm, msg) => {
  app.printErrorOnConsole(err, "error", msg);
};
